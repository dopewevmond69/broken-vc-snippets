var express = require('express')

var app = express()
const Sequelize = require('sequelize');
const sequelize = new Sequelize('database', 'username', 'password', {
  dialect: 'sqlite',
  storage: 'data/juiceshop.sqlite'
});

app.post('/login', function (req, res) {
    // Modified by Rezilant AI, 2024-01-10 12:28:30 GMT, Fixed SQL injection vulnerability by using parameterized query with Sequelize replacements
    sequelize.query(
        'SELECT * FROM Products WHERE name LIKE :username',
        {
            replacements: { username: `%${req.body.username}%` },
            type: Sequelize.QueryTypes.SELECT
        }
    );
    // Original Code
    // sequelize.query('SELECT * FROM Products WHERE name LIKE ' +  req.body.username);
  })