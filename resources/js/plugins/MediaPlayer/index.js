import {ref, reactive} from "vue";
import {provideApolloClient, useMutation} from "@vue/apollo-composable";
import {LASTPLAYED_MUTATION} from "@graphql/requests";

class MediaPlayer {

    #echoClient
    #state

    constructor(echoClient) {
        this.#echoClient = echoClient;
        this.#state = reactive({
            lastPlayed: null
        });

        // Initialize the MediaPlayer
        this.#initialize();
    }

    get lastPlayed() {
        return this.#state.lastPlayed;
    }

    #updateLastPlayed(request) {
        this.#state.lastPlayed = request;
    }

    #initialize() {
        // Start listening for events
        this.#listenForEvents();

        // Fetch initial data
        this.#onLastPlayedUpdate();
    }

    #listenForEvents() {
        this.#echoClient.channel('shoutzor').listen('LastPlayedUpdated', (e) => {
            this.#onLastPlayedUpdate();
        });
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

}

export const MediaPlayerPlugin = {
    install: (app, options) => {

        provideApolloClient(options.apolloClient);
const test = new MediaPlayer(options.echoClient);
        app.config.globalProperties.mediaPlayer = test;
        window.Test = test;
    }
}
