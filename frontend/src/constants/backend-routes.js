const BackendRoutes = {
    users: {
        getAll: {
            path: "/users/login",
            method: "GET"
        },
        create: {
            path: "/users",
            method: "POST"
        },
        get: {
            path: "/users/{id}",
            method: "GET"
        },
        login: {
            path: "/users/login",
            method: "POST"
        },
        logout: {
            path: "/users/logout",
            method: "POST"
        },
        initPassword: {
            path: "/users/init_password",
            method: "POST"
        },

    },
    "tenants": {

    }
};

export default BackendRoutes;