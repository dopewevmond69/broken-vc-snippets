var express = require('express')

var app = express()
const Sequelize = require('sequelize');
const sequelize = new Sequelize('database', 'username', 'password', {
  dialect: 'sqlite',
  storage: 'data/juiceshop.sqlite'
});

app.post('/login', function (req, res) {
    // Modified by Rezilant AI, 2026-03-13 01:58:59 GMT, Fixed SQL injection vulnerability by using parameterized query instead of string concatenation
    sequelize.query(
        'SELECT * FROM Products WHERE name LIKE :username',
        {
            replacements: { username: req.body.username },
            type: sequelize.QueryTypes.SELECT
        }
    );
    // Original Code
    // sequelize.query('SELECT * FROM Products WHERE name LIKE ' +  req.body.username);
  })