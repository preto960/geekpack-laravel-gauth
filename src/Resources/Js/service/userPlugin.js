export default {
    install(app) {
      // Accede a la store desde el contexto global de la aplicación
      app.config.globalProperties.$user = (key) => {
        const store = app.config.globalProperties.$store;
        const user = store.state.data?.user || {};
        const data = store.state.data || {};
  
        // Devuelve el valor basado en la clave solicitada
        switch (key) {
          case 'username':
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
  