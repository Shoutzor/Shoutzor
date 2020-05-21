import shoutzor from '../../api/shoutzor'

// initial state
const state = () => ({
    all: []
})

// getters
const getters = {}

// actions
const actions = {
    getMedia ({ commit }) {
        shoutzor.fetchMedia(media => {
            commit('setMedia', media)
        })
    }
}

// mutations
const mutations = {
    setMedia (state, media) {
        state.all = media
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
