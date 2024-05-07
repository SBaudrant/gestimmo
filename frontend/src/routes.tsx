import React from 'react';
import { Redirect, Route, Switch } from 'react-router-dom';

import Home from './components/home/Home';
import Users from './components/users/Users';
import Sidebar from './components/sidebar/Sidebar';

const routes = (
  <Sidebar>
    <Switch>
      <Route exact path="/">
        <Redirect to="/home" />
      </Route>
      <Route path="/home">
        <Home />
      </Route>
      <Route path="/users">
        <Users />
      </Route>
      <Route component={() => <div>Not Found</div>} />
    </Switch>
  </Sidebar>
);

export default routes;
