using System;
using System.IO;
using Microsoft.AspNetCore.Mvc;

namespace WebFox.Controllers.PathTraversal
{
    public class PathTraversalTest4 : ControllerBase
    {
        private const string RootFolder = @"C:\Temp\Data\"; 
        
        [HttpGet("{userInput}")]
        public void Test(string userInput)    
        {
            string[] lines = { "First line", "Second line", "Third line" };
            // Modified by Rezilant AI, 2026-08-20 14:41:40 GMT, Added path validation to prevent path traversal attacks by sanitizing input and ensuring resolved path stays within RootFolder
            string sanitizedInput = Path.GetFileName(userInput); // Remove any path components
            string fullPath = Path.GetFullPath(Path.Combine(RootFolder, sanitizedInput));

            // Ensure the resolved path is still within the allowed directory
            if (!fullPath.StartsWith(Path.GetFullPath(RootFolder), StringComparison.OrdinalIgnoreCase))
            {
                throw new UnauthorizedAccessException("Access to the specified path is denied.");
            }

            using var outputFile = new StreamWriter(fullPath);
            // Original Code
            // using var outputFile = new StreamWriter(RootFolder + userInput);
            foreach (var line in lines)
                outputFile.WriteLine(line);
        }
    }
}