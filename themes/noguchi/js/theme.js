import React from 'react';

export const themes = {
	default: {
		foreground: '#000000',
		background: '#eeeeee',
		browse: {

		}
	},
	custom: {
		foreground: '#cc0000',
		background: '#00cc00',
		browse: {

		}

	}
};

export const ThemeContext = React.createContext(
	themes.default // default value
);
