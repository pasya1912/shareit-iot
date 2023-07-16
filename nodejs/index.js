var http = require('http');
const express = require('express');
var mysql = require('mysql');
const socketIO = require('socket.io');
const moment = require('moment-timezone');

// Set timezone to Asia/Jakarta
moment.tz.setDefault('Asia/Jakarta');

function connectToDatabase() {
    const connection = mysql.createConnection({
        host: 'localhost',       // Replace with your MySQL host
        user: 'root',   // Replace with your MySQL username
        password: '',   // Replace with your MySQL password
        database: 'shareit',        // Replace with your MySQL database name
        timezone: 'Asia/Jakarta' // Set the timezone for the connection

    });

    // Establish the initial connection
    connection.connect((error) => {
        if (error) {
            console.error('Error connecting to MySQL database: ', error);
            // Retry the connection after a delay
            setTimeout(connectToDatabase, 2000);
            return;
        }
        console.log('Connected to MySQL database!');
    });

    // Handle error events to detect disconnections
    connection.on('error', (error) => {
        console.error('MySQL connection error: ', error);
        if (error.code === 'PROTOCOL_CONNECTION_LOST') {
            // Connection lost, attempt to reconnect
            connectToDatabase();
        } else {
            throw error;
        }
    });

    return connection;
}
const app = express();
const server = http.createServer(app);
const io = socketIO(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"],
        credentials: true
    }
});
const port = 3000;
server.listen(port, () => {
    console.log(`Server listening on port ${port}`);
});

const dbConnection = connectToDatabase();
var oldHistory = [];
io.on('connection', function (socket) {
    //get jarak from mysql
    // Example query usage
    dbConnection.query('SELECT * FROM setting WHERE `key` = \'jarak\'', (error, results) => {
        if (error) {
            console.log('Error executing query: ', error)

            return;
        }
        io.emit('dataJarak', results[0].value);
    });
    dbConnection.query('SELECT * FROM history ORDER BY waktu DESC LIMIT 50', (error, results) => {
        if (error) {
            console.log('Error executing query: ', error)

            return;
        }
        console.log(results);
        io.emit('dataHistory', results);
    });
    //get jarak from mysql every 1 seconds
    setInterval(function () {
        dbConnection.query('SELECT * FROM setting WHERE `key` = \'jarak\'', (error, results) => {
            if (error) {
                console.log('Error executing query: ', error)
    
                return;
            }
            io.emit('dataJarak', results[0].value);
        });
    }, 1000);


    //every 5 seconds get data history from mysql then send to client data history max 50
    setInterval(function () {
        dbConnection.query('SELECT * FROM history ORDER BY waktu DESC LIMIT 50', (error, results) => {
            if (error) {
                console.log('Error executing query: ', error)

                return;
            }
            console.log(results);
            io.emit('dataHistory', results);
        });
    }
        , 15000);

});