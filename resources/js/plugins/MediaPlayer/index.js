import {reactive} from "vue";
import {provideApolloClient, useMutation} from "@vue/apollo-composable";
import {LASTPLAYED_MUTATION} from "@graphql/requests";
import dashjs from 'dashjs';
import {PlayerState} from "@models/PlayerState";

class MediaPlayer {

    #initialized

    #broadcastUrl
    #echoClient
    #state

    #player

    constructor(broadcastUrl, echoClient) {
        this.#initialized = false;

        this.#broadcastUrl = broadcastUrl;
        this.#echoClient = echoClient;
        this.#state = reactive({
            lastPlayed: null,
            playerStatus: PlayerState.STOPPED
        });
    }

    get playerStatus() {
        return this.#state.playerStatus;
    }

    #updatePlayerState(state) {
        this.#state.playerStatus = state;
    }

    get lastPlayed() {
        return this.#state.lastPlayed;
    }

    #updateLastPlayed(request) {
        this.#state.lastPlayed = request;
    }

    initialize() {
        if(this.#initialized) {
            return;
        }

        this.#player = dashjs.MediaPlayer().create();
        this.#player.initialize(document.querySelector("#mediaPlayerSource"), null, false);

        // Start listening for events
        this.#listenForEvents();

        // Fetch initial data
        this.#onLastPlayedUpdate();

        this.#initialized = true;
    }

    #listenForEvents() {
        this.#echoClient.channel('shoutzor').listen('LastPlayedUpdated', (e) => {
            this.#onLastPlayedUpdate();
        });

        //DashJS Player: Loading
        this.#player.on(dashjs.MediaPlayer.events["STREAM_INITIALIZING"], (e) => this.#updatePlayerState(PlayerState.LOADING));
        this.#player.on(dashjs.MediaPlayer.events["PLAYBACK_WAITING"], (e) => this.#updatePlayerState(PlayerState.LOADING));
        this.#player.on(dashjs.MediaPlayer.events["PLAYBACK_STALLED"], (e) => this.#updatePlayerState(PlayerState.LOADING));

        //DashJS Player: Playing
        this.#player.on(dashjs.MediaPlayer.events["PLAYBACK_PLAYING"], (e) => this.#updatePlayerState(PlayerState.PLAYING));

        //DashJS Player: Stopped
        this.#player.on(dashjs.MediaPlayer.events["ERROR"], () => this.#updatePlayerState(PlayerState.STOPPED));
        this.#player.on(dashjs.MediaPlayer.events["PLAYBACK_ERROR"], () => this.#updatePlayerState(PlayerState.STOPPED));
        this.#player.on(dashjs.MediaPlayer.events["PLAYBACK_ENDED"], () => this.#updatePlayerState(PlayerState.STOPPED));
        this.#player.on(dashjs.MediaPlayer.events["PLAYBACK_PAUSED"], () => this.#updatePlayerState(PlayerState.STOPPED));
    }

    #onLastPlayedUpdate() {
        const { mutate: lastPlayedMutate } = useMutation(LASTPLAYED_MUTATION, {
            fetchPolicy: 'no-cache'
        });

        lastPlayedMutate()
            .then(result => {
                this.#updateLastPlayed(result.data.lastPlayed.request);
            })
            .catch(error => {
                console.error("Failed to update Last Played Request", error);
            });
    }

    play() {
        this.#player.attachSource(this.#broadcastUrl);
        this.#player.play();
    }

    stop() {
        this.#player.pause();
        this.#player.attachSource(null);

        //TODO figure out why this is needed. Event should work on its own.
        this.#updatePlayerState(PlayerState.STOPPED);
    }

    setVolume(volume) {
        this.#player.setVolume(volume);
    }
}

export const MediaPlayerPlugin = {
    install: (app, options) => {
        provideApolloClient(options.apolloClient);

        app.config.globalProperties.mediaPlayer = new MediaPlayer(options.broadcastUrl, options.echoClient);
    }
}
