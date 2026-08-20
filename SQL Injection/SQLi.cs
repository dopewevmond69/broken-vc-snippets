using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System;
using System.Data.SqlClient;

namespace WebFox.Controllers
{
    [ApiController]
    [Route("[controller]")]
    public class Sqli : ControllerBase
    {

        private readonly ILogger<Sqli> _logger;

        public Sqli(ILogger<Sqli> logger)
        {
            _logger = logger;
        }


        [HttpGet("{id}")]
        public string DoSqli(string id)
        {
            string conString = "I AM a connection String";
            // Modified by Rezilant AI, 2026-08-20 12:57:06 GMT, Fixed SQL Injection vulnerability by using parameterized query
            using (SqlConnection con = new SqlConnection(conString))
            {
                using (SqlCommand cmd = new SqlCommand("SELECT * FROM users WHERE userId = @userId", con))
                {
                    cmd.Parameters.AddWithValue("@userId", id);
                    // Original Code
                    // using (SqlCommand cmd = new SqlCommand("SELECT * FROM users WHERE userId = '" + id + "'"))
                    // {
                        // using (SqlConnection con = new SqlConnection(conString))
                        // {
                            con.Open();
                            cmd.Connection = con;
                            SqlDataReader reader = cmd.ExecuteReader();
                            string res = "";
                            while (reader.Read())
                            {
                                res += reader["userName"];
                            }
                            return res;
                        // }
                    // }
                }
            }
        }
    }
}