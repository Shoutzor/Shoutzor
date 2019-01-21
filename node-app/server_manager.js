var Manager = function(options) {
	var express = require('express');
	
	// App
	const app = express();

	app.get('/', (req, res) => {
	  res.send('Hello world\n');
	});

	app.listen(options.port, options.host);
	console.log(`Manager listening on http://${options.host}:${options.port}`);

}

module.exports = Manager;