/**
 * Browsersync for `npm run dev`: proxies the local site and reloads it on changes.
 *
 * The site URL is read from WP_HOME in the project's .env, so the file works unchanged
 * on any site. CSS is injected without a reload; PHP, theme.json and block changes
 * reload the page.
 */

const fs = require('fs');
const path = require('path');

const envFile = path.resolve(__dirname, '../../../../.env');
const env = fs.existsSync(envFile) ? fs.readFileSync(envFile, 'utf8') : '';
const home = (env.match(/^WP_HOME=['"]?([^'"\r\n]+)/m) || [])[1];

if (!home) {
	throw new Error('WP_HOME is missing in ' + envFile + ' – Browsersync needs the local site URL.');
}

module.exports = {
	proxy: home,
	files: ['assets/css/*.css', '**/*.php', 'theme.json', 'blocks/**/*.{css,json}'],
	watchOptions: {
		ignored: ['node_modules/**'],
	},
	open: true,
	notify: false,
	ui: false,
};
