using System.IO;
using Microsoft.AspNetCore.Mvc;
using System;

namespace WebFox.Controllers.PathTraversal
{
    public class PathTraversalTest3 : ControllerBase
    {
        private const string RootFolder = @"C:\Temp\Data\"; 
        
        [HttpGet("{userInput}")]
        public void Test(string userInput)    
        {
            string[] lines = { "First line", "Second line", "Third line" };
            // Modified by Rezilant AI, 2026-08-20 14:41:17 GMT, Fixed path traversal vulnerability by sanitizing user input with Path.GetFileName() and validating against directory traversal attempts
            string safeFileName = Path.GetFileName(userInput);
            string safePath = Path.Combine(RootFolder, safeFileName);
            
            // Additional validation to prevent empty filenames and remaining traversal attempts
            if (string.IsNullOrEmpty(safeFileName) || safeFileName.Contains(".."))
            {
                throw new ArgumentException("Invalid filename");
            }
            
            // Original Code
            // using (var outputFile = new StreamWriter(RootFolder + userInput))
            using (var outputFile = new StreamWriter(safePath))
            {
                foreach (var line in lines)
                    outputFile.WriteLine(line);
            }
        }
    }
}