/**
 * Webpack Custom Config.
 */
const path = require('path');
const defaultConfig = require('@wordpress/scripts/config/webpack.config.js');

module.exports = {
	...defaultConfig,
	entry: {
		'primary-category': path.resolve(
			__dirname,
			'assets',
			'primary-category.js'
		),
	},
	output: {
		path: path.resolve(__dirname, 'dist'),
	},
};
