const express = require('express');
const router = express.Router()

const { exec, spawn }  = require('child_process');


// Modified by Rezilant AI, 2026-08-20 14:37:38 GMT, Replaced vulnerable exec() with execFile() and added URL validation to prevent command injection
const { execFile } = require('child_process');
const { URL } = require('url');

// Validate and sanitize the URL input
function validateUrl(urlString) {
    try {
        const parsedUrl = new URL(urlString);
        // Only allow http/https protocols
        if (!['http:', 'https:'].includes(parsedUrl.protocol)) {
            throw new Error('Invalid protocol');
        }
        return parsedUrl.href;
    } catch (error) {
        throw new Error('Invalid URL format');
    }
}

router.post('/ping', (req,res) => {
    // Modified by Rezilant AI, 2026-08-20 14:37:38 GMT, Using execFile with URL validation instead of exec to prevent command injection
    try {
        const validatedUrl = validateUrl(req.body.url);
        
        // Pass URL as an argument, not as part of the command string
        execFile('curl', ['-I', validatedUrl], (error, stdout, stderr) => {
            if (error) {
                console.error('Error:', error);
                return res.send('error');
            }
            res.send('pong')
        });
    } catch (error) {
        // Handle validation errors
        res.status(400).send('Invalid URL provided');
    }
    // Original Code
    // exec(`${req.body.url}`, (error) => {
    //     if (error) {
    //         return res.send('error');
    //     }
    //     res.send('pong')
    // })
    
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

    const cmdRunning = spawn(cmd, []);
    cmdRunning.on('close', (code) => {
        res.send(`child process exited with code ${code}`);
    });
}

module.exports = router