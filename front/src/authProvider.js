
const entrypoint = process.env.REACT_APP_API_AUTHENTICATE;

const authProvider = {
  login: ({ username, password }) =>  {
    const request = new Request(entrypoint, {
      method: 'POST',
      body: JSON.stringify({ email: username, password }),
      headers: new Headers({ 'Content-Type': 'application/json' }),
    });
    return fetch(request)
      .then(response => {
        if (response.status < 200 || response.status >= 300) {
          throw new Error(response.statusText);
        }
        return response.json();
      })
      .then(({ token }) => {
        localStorage.setItem('token', token);
      });
  },
  logout: () => {
    localStorage.removeItem('token');
    // TODO : Appeler l'API pour se déconnecter
    return Promise.resolve();
  },
  checkAuth: () => {
    return localStorage.getItem('token')
    ? Promise.resolve()
    : Promise.reject()
  },
  checkError: (error) => {
    const status = error.status;
    if (status === 401 || status === 403) {
      localStorage.removeItem('token');
      return Promise.reject();
    }
    return Promise.resolve();
  },
  // Page "Vous n'avez pas les authorisations pour accéder à cette page"
  //: Promise.reject({ redirectTo: '/no-access' }),
  // TODO : COmmenté à voir si je vais en avoir besoin ou pas
  getPermissions: () => {
      const role = localStorage.getItem('permissions');
      return role ? Promise.resolve(role) : Promise.reject();
  }
};

export default authProvider;
