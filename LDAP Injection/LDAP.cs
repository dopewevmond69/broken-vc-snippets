using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.DirectoryServices;

namespace WebFox.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class LDAP : ControllerBase
    {
        [HttpGet("{user}")]
        public void LdapInje(string user)
        {
            DirectoryEntry de = new DirectoryEntry("LDAP://DC=mycompany,DC=com");
            DirectorySearcher searcher = new DirectorySearcher(de);
            // Modified by Rezilant AI, 2026-08-20 14:40:26 GMT, Added LDAP encoding to prevent injection attacks
            string sanitizedUser = EscapeLDAPSearchFilter(user);
            searcher.Filter = "(&(objectClass=user)(|(cn=" + sanitizedUser + ")(sAMAccountName=" + sanitizedUser + ")))";
            // Original Code
            //searcher.Filter = "(&(objectClass=user)(|(cn=" + user + ")(sAMAccountName=" + user + ")))"; //When I'm concatenating the user name, here I got the security flag which is below.

            SearchResult result = searcher.FindOne();
        }

        // Modified by Rezilant AI, 2026-08-20 14:40:26 GMT, Helper method to encode LDAP special characters
        private static string EscapeLDAPSearchFilter(string input)
        {
            if (string.IsNullOrEmpty(input))
                return input;
                
            return input
                .Replace("\\", "\\5c")  // Backslash must be first
                .Replace("*", "\\2a")
                .Replace("(", "\\28")
                .Replace(")", "\\29")
                .Replace("\0", "\\00")
                .Replace("/", "\\2f");
        }
    }
}