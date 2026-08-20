using System;
using System.IO;
using Microsoft.AspNetCore.Mvc;

namespace WebFox.Controllers.PathTraversal
{
    public class PathTraversalTest2 : ControllerBase
    {
        private const string RootFolder = @"C:\Temp\Data\";

        [HttpGet("{userInput}")]
        public void Test(string userInput)    
        {    
            try
            {
                // Modified by Rezilant AI, 2026-08-20 14:40:52 GMT, Added path traversal validation to prevent directory escape attacks
                var fullPath = Path.Combine(RootFolder, userInput);
                var resolvedPath = Path.GetFullPath(fullPath);

                // Verify the resolved path is still within RootFolder
                if (!resolvedPath.StartsWith(Path.GetFullPath(RootFolder) + Path.DirectorySeparatorChar))
                {
                    throw new UnauthorizedAccessException("Access to path is denied.");
                }

                // Now safe to use resolvedPath
                System.IO.File.Delete(resolvedPath);

                // Original Code
                // var fullPath = Path.Combine(RootFolder, userInput);
                // System.IO.File.Delete(fullPath);
            }    
            catch (IOException ioExp)    
            {    
                Console.WriteLine(ioExp.Message);    
            }
            Console.ReadKey();    
        }
    }
}