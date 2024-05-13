const files = {
	sass: {
		src: ['./assets/**/css/*.scss'],
		watch: ['./assets/**/css/*.scss', './assets/**/css/**/*.scss'],
	},
	js: {
		src: ['assets/**/js/*.js', '!assets/**/js/*.min.js'],
		watch: ['assets/**/js/*.js', '!assets/**/js/*.min.js'],
	},
	php: {
		watch: ['./*.php', './**/*.php', './**/**/*.php'],
	}
}

const browserSyncAtts = {
	open: 'external',
	host: 'wp.x',
	proxy: {
		target: 'https://wp.x/'
	},
	https: {
		key: '/Users/jeroensormani/.config/valet/Certificates/wp.x.key',
		cert: '/Users/jeroensormani/.config/valet/Certificates/wp.x.crt',
	},
	// reloadDelay: 10
}


module.exports = {
	files,
	browserSyncAtts
}
