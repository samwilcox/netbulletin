/**
 * NET BULLETIN
 * 
 * By Sam Wilcox <sam@netbulletin.net>
 * https://www.netbulletin.net
 * 
 * This software is released under the MIT license.
 * To view more details, visit:
 * https://license.netbulletin.net
 */

import React from 'react';
import { BrowserRouter as Router, Route, Routes as Switch } from 'react-router-dom';
import Layout from './components/Layout';
import routes from './router/AppRoutes'

function App() {
  return (
    <Router>
      <Layout>
        <Switch>
        {routes.map(({ path, exact, component: Component }, index) => (
            <Route
              key={index}
              path={path}
              element={<Component />}
            />
          ))}
        </Switch>
      </Layout>
    </Router>
  );
}

export default App;
