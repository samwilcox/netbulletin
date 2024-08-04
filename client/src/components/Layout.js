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

import React, { useEffect, useState } from 'react';
import ApiService from '../ApiService';
import { setThemePath } from '../utils/ThemeUtils';

/**
 * This component lays out the structure of the application.
 * @param {mixed} children the children 
 */
const Layout = ({ children }) => {
    const [theme, setTheme] = useState({});
    const [error, setError] = useState(null);

    useEffect(() => {
        ApiService.getData('/theme')
            .then(data => {
                console.log(`Received data: ${data}`);
                const path = `../themes/${data.themeFolder}`;
                setThemePath(path);
                setTheme(data);
            })
            .catch(error => setError(error));
    }, []);

    if (error) {
        return <div></div>;
    }

    const themeFolder = theme.themeFolder;
    const themePath = `../themes/${themeFolder}`;
    const Header = React.lazy(() => import(`${themePath}/components/Header`));
    const Footer = React.lazy(() => import(`${themePath}/components/Footer`));

    return (
        <div className='App'>
            <React.Suspense fallback={<div>Loading...</div>}>
                <Header />
                <main>
                    {children}
                </main>
                <Footer />
            </React.Suspense>
        </div>
    );
};

export default Layout;