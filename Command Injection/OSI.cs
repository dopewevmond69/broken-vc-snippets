using Microsoft.AspNetCore.Mvc;
using System;
using System.Diagnostics;
using System.Collections.Generic;
using System.IO;
using System.Security;

namespace WebFox.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class OsInjection : ControllerBase
    {
        // Modified by Rezilant AI, 2026-03-10 12:27:59 GMT, Added allowlist for binary validation to prevent command injection
        private static readonly HashSet<string> AllowedBinaries = new HashSet<string>
        {
            "cmd.exe",
            "powershell.exe",
            "notepad.exe"
            // Add other legitimate binaries as needed
        };

        [HttpGet("{binFile}")]
        public string os(string binFile)
        {
            // Modified by Rezilant AI, 2026-03-10 12:27:59 GMT, Implemented secure input validation with allowlist approach
            // Extract just the filename without path to prevent directory traversal
            string fileName = Path.GetFileName(binFile);
            
            // Validate against allowlist to ensure only permitted binaries can execute
            if (!AllowedBinaries.Contains(fileName.ToLowerInvariant()))
            {
                throw new SecurityException($"Binary '{fileName}' is not allowed");
            }
            
            // Use full path from a trusted location (system directory)
            string trustedPath = Path.Combine(
                Environment.GetFolderPath(Environment.SpecialFolder.System),
                fileName
            );
            
            // Verify the file exists in the trusted location before execution
            if (!File.Exists(trustedPath))
            {
                throw new FileNotFoundException($"Binary not found: {trustedPath}");
            }

            Process p = new Process();
            // Modified by Rezilant AI, 2026-03-10 12:27:59 GMT, Using validated and sanitized path from trusted location
            p.StartInfo.FileName = trustedPath; // Now compliant - validated input from trusted location
            // Original Code
            // p.StartInfo.FileName = binFile; // Noncompliant
            p.StartInfo.RedirectStandardOutput = true;
            // Modified by Rezilant AI, 2026-03-10 12:27:59 GMT, Disabled shell execution to prevent shell interpretation attacks
            p.StartInfo.UseShellExecute = false; // Prevent shell interpretation
            p.StartInfo.CreateNoWindow = true; // Don't create a visible window
            p.Start();
            string output = p.StandardOutput.ReadToEnd();
            p.Dispose();
            return output;
        }
    }
}