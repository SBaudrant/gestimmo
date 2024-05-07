import React from 'react';
import { Provider } from 'react-redux';
import { ConnectedRouter } from 'connected-react-router';
import { Store } from 'redux';
import { History } from 'history';

import './App.scss';
import { ApplicationState } from './store';
import routes from './routes';
import './i18n/i18n';

interface MainProps {
  store: Store<ApplicationState>;
  history: History;
}

const App: React.FC<MainProps> = ({ store, history }) => {
  return (
    <Provider store={store}>
      <ConnectedRouter history={history}>
        { routes }
      </ConnectedRouter>
    </Provider>
  );
}

export default App;
