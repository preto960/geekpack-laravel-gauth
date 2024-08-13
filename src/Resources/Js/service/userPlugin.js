export default {
    install(app) {
      app.config.globalProperties.$getUser = (key) => {
        const store = app.config.globalProperties.$store;
        const user = store.state.data?.user || {};
        const profile = store.state.data?.profile || {};
        const data = store.state.data || {};
  
        switch (key) {
          case 'firstname':
            return profile.firstname;
          case 'lastname':
            return profile.lastname;
          case 'fullname':
            return profile.firstname+' '+profile.lastname;
          case 'email':
            return user.email;
          case 'created_at':
            return user.created_at;
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
  