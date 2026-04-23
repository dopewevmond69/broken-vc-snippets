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
    exec(
        'gzip ' + req.query.file_path,
        function (err, data) {
          console.log('err: ', err)
          console.log('data: ', data);
          res.send('done');
    });
})

router.get('/run', (req,res) => {
   let cmd = req.params.cmd;
   runMe(cmd,res)
});

function runMe(cmd,res){
//    return spawn(cmd);

    // Modified by Rezilant AI, 2026-03-10 12:27:47 GMT, Added whitelist validation and secure spawn configuration to prevent command injection attacks
    const allowedCommands = {
        'list': 'ls',
        'date': 'date',
        'whoami': 'whoami',
        'pwd': 'pwd'
    };
    
    // Validate against whitelist
    const command = allowedCommands[cmd];
    
    if (!command) {
        return res.status(400).send('Command not allowed');
    }
    
    // Execute only whitelisted commands
    const cmdRunning = spawn(command, [], {
        shell: false,  // Disable shell interpretation
        timeout: 5000  // Add timeout
    });
    
    // Original Code
    // const cmdRunning = spawn(cmd, []);
    cmdRunning.on('close', (code) => {
        res.send(`child process exited with code ${code}`);
    });
}

module.exports = router