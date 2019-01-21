'use strict';

var manager = require('./server_manager.js');

manager({
	port: 8080,
	host: '0.0.0.0'
});