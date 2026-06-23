const express = require('express');
const router = express.Router()

const { exec, spawn, execFile }  = require('child_process'); // Modified by Rezilant AI, 2026-03-10 12:27:32 GMT, Added execFile import for secure command execution


// Modified by Rezilant AI, 2026-03-10 12:27:32 GMT, Added allowlist of permitted operations to prevent command injection
// Define allowed commands/operations
const ALLOWED_OPERATIONS = {
  'ping': '/bin/ping',
  'traceroute': '/usr/bin/traceroute'
};

router.post('/ping', (req,res) => {
    // Modified by Rezilant AI, 2026-03-10 12:27:32 GMT, Replaced exec with execFile and added input validation to prevent command injection
    const operation = req.body.operation || 'ping';
    const url = req.body.url;
    
    // Validate operation against allowlist
    if (!ALLOWED_OPERATIONS[operation]) {
      return res.status(400).json({ error: 'Invalid operation' });
    }
    
    // Validate URL format (basic example)
    const urlPattern = /^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!urlPattern.test(url)) {
      return res.status(400).json({ error: 'Invalid URL format' });
    }
    
    // Use execFile with separate arguments (prevents shell injection)
    execFile(ALLOWED_OPERATIONS[operation], ['-c', '4', url], (error, stdout, stderr) => {
      if (error) {
        return res.status(500).json({ error: 'Execution failed' });
      }
      res.json({ output: stdout });
    });
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