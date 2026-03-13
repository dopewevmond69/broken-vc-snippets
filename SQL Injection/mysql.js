const express = require('express');
const router = express.Router()

const config = require('../../config')
const mysql      = require('mysql');
const connection = mysql.createConnection({
  host     : config.MYSQL_HOST,
  port     : config.MYSQL_PORT,
  user     : config.MYSQL_USER,
  password : config.MYSQL_PASSWORD,
  database : config.MYSQL_DB_NAME,
});
 
connection.connect();

router.get('/example1/user/:id', (req,res) => {
    let userId = req.params.id;
    let query = {
        sql : "SELECT * FROM users WHERE id=" + userId
    }
    connection.query(query,(err, result) => {
        res.json(result);
    });
})

// Modified by Rezilant AI, 2026-03-13 01:28:24 GMT, Fixed SQL injection by using parameterized query with placeholder
router.get('/example2/user/:id',  (req,res) => {
    let userId = req.params.id;
    connection.query("SELECT * FROM users WHERE id = ?", [userId], (err, result) => {
        if (err) {
            return res.status(500).json({ error: 'Database error' });
        }
        res.json(result);
    });
})
// Original Code
//router.get('/example2/user/:id',  (req,res) => {
//    let userId = req.params.id;
//    connection.query("SELECT * FROM users WHERE id=" + userId,(err, result) => {
//        res.json(result);
//    });
//})

router.get('/example3/user/:id',  (req,res) => {
    let userId = req.params.id;
    connection.query({
        sql : "SELECT * FROM users WHERE id=" +userId
    },(err, result) => {
        res.json(result);
    });
})


module.exports = router