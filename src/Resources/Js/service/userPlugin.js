export default {
    install(app) {
      app.config.globalProperties.$getUser = (key) => {
        const store = app.config.globalProperties.$store;
        const user = store.state.data?.user || {};
        const data = store.state.data || {};
  
        switch (key) {
          case 'name':
            return user.name;
          case 'email':
            return user.email;
          case 'roles':
            return data.roles || [];
          case 'permissions':
            return data.permissions || [];
          case 'token':
            return data.access_token;
          case 'token_type':
            return data.token_type;
          case 'time_expire':
            return data.time_expire;
          default:
            return null;
        }
      };
    }
  }
  