import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';

export default new createStore({
  state: {
    data: null,
    props: null,
    theme: "light"
  },
  mutations: {
    setUser(state, data) {
      state.data = data;
    },
    setProps(state, props) {
        state.props = props;
    },
    setThemeToggle(state, theme) {
      state.theme = theme;
  },
  },
  plugins: [createPersistedState()],
});
