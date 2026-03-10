const express = require('express');
const router = express.Router()

const { exec, spawn }  = require('child_process');


router.post('/ping', (req,res) => {
    exec(`${req.body.url}`, (error) => {
        if (error) {
            return res.send('error');
        }
        res.send('pong')
    })
    
})

router.post('/gzip', (req,res) => {
    // Modified by Rezilant AI, 2026-03-10 12:27:40 GMT, replaced exec with execFile to prevent command injection
    const { execFile } = require('child_process');
    const path = require('path');
    
    // Validate and sanitize the file path
    const filePath = req.query.file_path;
    
    // Validate: ensure the file path doesn't contain dangerous characters
    if (!filePath || /[;&|`$()]/.test(filePath)) {
        return res.status(400).send('Invalid file path');
    }
    
    // Resolve to absolute path and prevent directory traversal
    const safePath = path.resolve('/allowed/directory/', path.basename(filePath));
    
    // Use execFile with array arguments (no shell interpretation)
    execFile('gzip', [safePath], (err, stdout, stderr) => {
        if (err) {
            console.error('Error:', err);
            return res.status(500).send('Compression failed');
        }
        res.send('done');
    });
    
    // Original Code
    // exec(
    //     'gzip ' + req.query.file_path,
    //     function (err, data) {
    //       console.log('err: ', err)
    //       console.log('data: ', data);
    //       res.send('done');
    // });
})

router.get('/run', (req,res) => {
   let cmd = req.params.cmd;
   runMe(cmd,res)
});

function runMe(cmd,res){
//    return spawn(cmd);

    const cmdRunning = spawn(cmd, []);
    cmdRunning.on('close', (code) => {
        res.send(`child process exited with code ${code}`);
    });
}

module.exports = router