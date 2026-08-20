const express = require('express');
const config = require('../config')
const router = express.Router()

const MongoClient = require('mongodb').MongoClient;
const url = config.MONGODB_URI;

router.post('/customers/register', async (req, res) => {

    const client = await MongoClient.connect(url, { useNewUrlParser: true })
        .catch(err => { console.log(err); });
    if (!client) {
        return res.json({ status: "Error" });
    }
    const db = client.db(config.MONGODB_DB_NAME);
    const customers = db.collection("customers")
    
    let myobj = { name: req.body.name, address: req.body.address };
    customers.insertOne(myobj, function (err) {
        if (err) throw err;
        console.log("user registered");
        res.json({ status:"success", "message": "user inserted" })
        db.close();
    });
    
})


// Vulnerable search function
router.post('/customers/find', async (req, res) => {

    const client = await MongoClient.connect(url, { useNewUrlParser: true })
        .catch(err => { console.log(err); });
    if (!client) {
        return res.json({ status: "Error" });
    }
    const db = client.db(config.MONGODB_DB_NAME);
    const customers = db.collection("customers")

    // Modified by Rezilant AI, 2026-08-20 12:55:52 GMT, Added input sanitization to prevent NoSQL injection attacks
    const mongoSanitize = require('mongo-sanitize');
    const sanitizedName = mongoSanitize(req.body.name);
    let myobj = { name: sanitizedName };

    // Original Code
    // let name = req.body.name
    // let myobj = { name: name };
    customers.findOne(myobj, function (err, result) {
        if (err) throw err;
        db.close();
        res.json(result)
    });

  
})

// Vulnerable Authentication
// Authentication Bypass Example
// curl -X POST http://localhost:3000/customers/login/ --data "{\"email\": {\"\$gt\":\"\"} , \"password\": {\"\$gt\":\"\"}}" -H "Content-Type: application/json"

router.post('/customers/login', async (req, res) => {

    const client = await MongoClient.connect(url, { useNewUrlParser: true })
        .catch(err => { console.log(err); });
    if (!client) {
        return res.json({ status: "Error" });
    }
    const db = client.db(config.MONGODB_DB_NAME);
    const customers = db.collection("customers")

    let myobj = { email: req.body.email, password: req.body.password };
    customers.findOne(myobj, function (err, result) {
        if (err) throw err;
        db.close();
        res.json(result)
    });

 
})

module.exports = router