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

import React, { createContext, useContext, useState, useEffect } from 'react';
import ApiService from '../ApiService';

const ThemeContext = createContext();

export const useTheme = () => useContext(ThemeContext);

export const ThemeProvider = ({ children }) => {
    const [theme, setTheme] = useState('');

    useEffect(() => {
        const fetchUserTheme = async () => {
            try {
                const response = await ApiService.getData('/user/theme');
                setTheme(response.data.theme || 'default');
            } catch (error) {
                console.error('Error fetching user theme:', error);
                setTheme('');
            }
        };
    }, []);
};