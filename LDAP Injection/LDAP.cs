using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.DirectoryServices;
using System.Text;

namespace WebFox.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class LDAP : ControllerBase
    {
        [HttpGet("{user}")]
        public void LdapInje(string user)
        {
            // Modified by Rezilant AI, 2026-03-18 13:06:15 GMT, Added LDAP injection prevention with proper input encoding
            // Sanitize the user input by encoding LDAP special characters
            string sanitizedUser = EncodeLdapSearchFilter(user);
            
            DirectoryEntry de = new DirectoryEntry("LDAP://DC=mycompany,DC=com");
            DirectorySearcher searcher = new DirectorySearcher(de);
            
            // Use the sanitized input in the filter
            searcher.Filter = $"(&(objectClass=user)(|(cn={sanitizedUser})(sAMAccountName={sanitizedUser})))";
            
            // Original Code
            // searcher.Filter = "(&(objectClass=user)(|(cn=" + user + ")(sAMAccountName=" + user + ")))"; //When I'm concatenating the user name, here I got the security flag which is below.

            SearchResult result = searcher.FindOne();
        }
        
        // Modified by Rezilant AI, 2026-03-18 13:06:15 GMT, Added helper method to encode special LDAP characters
        // Encode special LDAP characters to prevent injection
        private string EncodeLdapSearchFilter(string searchFilter)
        {
            StringBuilder sb = new StringBuilder();
            foreach (char c in searchFilter)
            {
                switch (c)
                {
                    case '\\': sb.Append(@"\5c"); break;
                    case '*':  sb.Append(@"\2a"); break;
                    case '(':  sb.Append(@"\28"); break;
                    case ')':  sb.Append(@"\29"); break;
                    case '\0': sb.Append(@"\00"); break;
                    default:   sb.Append(c); break;
                }
            }
            return sb.ToString();
        }
    }
}