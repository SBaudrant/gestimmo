import {
    createBrowserRouter,
    redirect,
    RouterProvider,
} from "react-router-dom";

import { Home } from './pages/Home'
import { Header } from "./components/Header";
import { Dashboard } from "./pages/Dashboard";
import { Properties } from "./pages/Properties";
import { LoginPage } from "./pages/Login";

export const SiteLinks = {
    home: {
        label: 'Home',
        url: '/',
    },
    dashboard: {
        label: 'Dashboard',
        url: 'dashboard',
    },
    properties: {
        label: 'My properties',
        url: 'properties',
    },
    login: {
        label: 'Login',
        url: 'login',
    }
}

// @TODO add userAuthProvider
const isLoggedIn = () => {
        return false;
}

const redirectAnonymousUsers = async () => {
    console.log('ici')
    const user = isLoggedIn()
    if (!user) {
        console.log('la')
        // if you know you can't render the route, you can
        // throw a redirect to stop executing code here,
        // sending the user to a new route
        throw redirect(SiteLinks.login.url);
    }

    return null;
}

const redirectLoggedInUsers = async () => {
    const user = isLoggedIn()
    if (user) {
        // if you know you can't render the route, you can
        // throw a redirect to stop executing code here,
        // sending the user to a new route
        throw redirect(SiteLinks.home.url);
    }

    return null;
}


const router = createBrowserRouter([
    {
        path: SiteLinks.home.url,
        element: <Header />,
        loader: async () => redirectAnonymousUsers(),
        children: [
            {
                path: SiteLinks.home.url,
                element: <Home />,
            },
            {
                path: SiteLinks.dashboard.url,
                element: <Dashboard />,
            },
            {
                path: SiteLinks.properties.url,
                element: <Properties />,
            },
        ]
    },
    {
        path: SiteLinks.login.url,
        element: <LoginPage />,
        loader: async () => redirectLoggedInUsers(),
    }
]);

function Router() {
    return <RouterProvider router={router} />
}

export default Router;