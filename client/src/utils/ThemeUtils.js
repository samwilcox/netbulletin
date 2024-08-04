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

let themePath = null;

/**
 * Sets the theme path.
 * @param {string} path the theme path 
 */
export function setThemePath(path) {
    themePath = path;
}

/**
 * Get the theme path.
 * @returns the theme path
 */
export function getThemePath() {
    return themePath;
}

export const getDynamicThemeComponent = (themePaths, theme, component) => {
    const componentPath = themePaths[theme] && themePaths[theme][component]
        ? themePaths[themePath][component]
        : themePaths.default[component];

    return import(`../${componentPath}`);
};