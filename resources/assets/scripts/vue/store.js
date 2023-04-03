import { createStore } from 'vuex'

export default createStore({
  state() {
    return {
      isLocked: false,
      notice: null,
    };
  },
  mutations: {
    setNotice(state, content) {
      state.notice = content;
    },
    removeNotice(state) {
      state.notice = null;
    },
    lock(state) {
      state.isLocked = true;
    },
    unlock(state) {
      state.isLocked = false;
    },
  },
});
