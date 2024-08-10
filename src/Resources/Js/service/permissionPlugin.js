export default {
  install(app) {
    app.config.globalProperties.$hasPermission = (permission) => {
      const store = app.config.globalProperties.$store;
      const permissions = store.state.data ? store.state.data.permissions : [];
      return permissions.includes(permission);
    };
  }
}