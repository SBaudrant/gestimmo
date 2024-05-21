import {
    createBrowserRouter,
    RouterProvider,
} from "react-router-dom";

import { Home } from './pages/Home'
import { Dashboard } from "./pages/Dashboard";
import { Login } from "./pages/Login";
import { Properties } from "./pages/Properties";
import { Header } from "./components/Header";

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


const router = createBrowserRouter([
    {
        path: SiteLinks.home.url,
        element: <Header />,
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
            {
                path: SiteLinks.login.url,
                element: <Login />,
            },
        ],
        
    },
]);

function Router() {
    return <RouterProvider router={router} />
}

export default Router;