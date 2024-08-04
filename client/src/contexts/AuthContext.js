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

const AuthContext = createContext();

export const useAuth = () => useContext(AuthContext);

/**
 * Auth provider context.
 * @param {object} children the children 
 * @returns 
 */
export const AuthProvider = ({ children }) => {
    const [isSignedIn, setIsSignedIn] = useState(false);
    const [userData, setUserData] = useState(null);

    useEffect(() => {
        // Checks the user status
        const checkAuthStatus = async () => {
            try {
                const response = await ApiService.getData('/auth/status');
                setIsSignedIn(response.data.signedIn);
                setUserData(response.data.user || null);
            } catch (error) {
                console.error('Error checking authentication status:', error);
                setIsSignedIn(false);
                setUserData(null);
            }
        };

        checkAuthStatus();
    }, []);

    /**
     * 
     * @param {object} credentials the user credentials 
     */
    const signin = async (credentials) => {
        try {
            const response = await ApiService.createData('/auth/signin', credentials);
            setIsSignedIn(response.data.signedIn);
            setUserData(response.data.signedIn ? response.data.user : null);
        } catch (error) {
            console.error('Sign in failed:', error);
            setIsSignedIn(false);
            setUserData(null);
        }
    };

    const signout = async () => {
        try {
            const response = await ApiService.getData('/auth/signout');
            setIsSignedIn(response.data.signedIn);
            setUserData(null);
        } catch (error) {
            console.error('Sign out failed:', error);
        }
    };

    return (
        <AuthContext.Provider value={{ isSignedIn, userData, signin, signout }}>
            {children}
        </AuthContext.Provider>
    );
};