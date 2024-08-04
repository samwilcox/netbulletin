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
import axios from 'axios';

/**
 * Class ApiService
 * 
 * Handles the communication between the front-end to the back-end.
 */
class ApiService {
    /**
     * Constructor that sets up this class.
     */
    constructor() {
        this.apiBaseUrl = process.env.REACT_APP_API_BASE_URL;
        console.log(process.env);
        this.client = axios.create({
            baseURL: this.apiBaseUrl,
            headers: {
                'Content-Type': 'application/json',
            },
        });
    }

    /**
     * Gets data from the API.
     * @param {string} endpoint the API endpoint
     */
    getData(endpoint) {
        return this.client.get(endpoint)
            .then(response => response.data)
            .catch(error => this.handleError(error));
    }

    /**
     * Creates data on the API endpoint.
     * @param {string} endpoint the API endpoint
     * @param {object} data the data object
     */
    createData(endpoint, data) {
        return this.client.post(endpoint, data)
            .then(response => response.data)
            .catch(error => this.handleError(error));
    }

    /**
     * Handles errors.
     * @param {object} error the error object instance 
     */
    handleError(error) {
        if (error.response) {
            return Promise.reject(error.response.data.message || error.response.data);
        }

        return Promise.reject(error.message);
    }
}

export default new ApiService();