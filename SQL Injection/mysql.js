const express = requireexpress
const router = express.Router

const config = require../../config
const mysql      = requiremysql
const connection = mysql.createConnection
  host     : config.MYSQL_HOST,
  port     : config.MYSQL_PORT,
  user     : config.MYSQL_USER,
  password : config.MYSQL_PASSWORD,
  database : config.MYSQL_DB_NAME,

 
connection.connect

router.get/example1/user/:id, req,res = 
    let userId = req.params.id
    // Modified by Rezilant AI, 202