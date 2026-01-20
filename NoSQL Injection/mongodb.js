const express = requireexpress
const config = require../config
const router = express.Router

const MongoClient = requiremongodb.MongoClient
const url = config.MONGODB_URI

router.post/customers/register, async req, res = 

    const client = await MongoClient.connecturl,  useNewUrlParser: true 
        .catcherr =  console.logerr 
    if !client 
        return res.json status: Error 
    
    const db = client.dbconfig.MONGODB_DB_NAME
    cons