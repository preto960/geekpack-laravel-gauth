import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';

export default new createStore({
  state: {
    data: null,
    props: null,
  },
  mutations: {
    setUser(state, data) {
      state.data = data;
    },
    setProps(state, props) {
        state.props = props;
    },
  },
  plugins: [createPersistedState()],
});
