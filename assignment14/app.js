var db_connect = require('./db_connect.js').then(
    function(data) {
        console.log(data[0].question);
    }
);