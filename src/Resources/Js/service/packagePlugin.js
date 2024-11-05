export default {
  install(app) {
    app.config.globalProperties.$getPackage = (key) => {
      const store = app.config.globalProperties.$store;
      const installedPackages = store.state.props ? store.state.props.canPackage : [];
      return installedPackages.includes(key);
    };
  }
}
  