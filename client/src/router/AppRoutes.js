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

import React from "react";
import { getThemePath } from "../utils/ThemeUtils";
const themePath = getThemePath();

// Lazy import all our theme files (its a long list!)...
const Home = React.lazy(() => import(`${themePath}/pages/Home`));

const Routes = [
    { path: '/', exact: true, component: Home }
];

export default Routes;