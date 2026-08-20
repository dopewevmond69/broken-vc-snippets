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
    // Modified by Rezilant AI, 2026-08-20 12:57:39 GMT, Fixed SQL injection by using parameterized query with placeholders
    const sql = 'SELECT * FROM users WHERE id = ?';
    const params = [userId];
    connection.query(sql, params, (err, result) => {
        if (err) {
            return res.status(500).json({ error: 'Database error' });
        }
        res.json(result);
    });
    // Original Code
    // let query = {
    //     sql : "SELECT * FROM users WHERE id=" + userId
    // }
    // connection.query(query,(err, result) => {
    //     res.json(result);
    // });
})

router.get('/example2/user/:id',  (req,res) => {
    let userId = req.params.id;
    // Modified by Rezilant AI, 2026-08-20 12:57:39 GMT, Fixed SQL injection by using parameterized query with placeholders
    const sql = 'SELECT * FROM users WHERE id = ?';
    const params = [userId];
    connection.query(sql, params, (err, result) => {
        if (err) {
            return res.status(500).json({ error: 'Database error' });
        }
        res.json(result);
    });
    // Original Code
    // connection.query("SELECT * FROM users WHERE id=" + userId,(err, result) => {
    //     res.json(result);
    // });
})

router.get('/example3/user/:id',  (req,res) => {
    let userId = req.params.id;
    // Modified by Rezilant AI, 2026-08-20 12:57:39 GMT, Fixed SQL injection by using parameterized query with placeholders
    const sql = 'SELECT * FROM users WHERE id = ?';
    const params = [userId];
    connection.query(sql, params, (err, result) => {
        if (err) {
            return res.status(500).json({ error: 'Database error' });
        }
        res.json(result);
    });
    // Original Code
    // connection.query({
    //     sql : "SELECT * FROM users WHERE id=" +userId
    // },(err, result) => {
    //     res.json(result);
    // });
})


module.exports = router