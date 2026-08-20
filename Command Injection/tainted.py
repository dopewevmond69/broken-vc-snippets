import os
from flask import Flask, request
import subprocess
import ipaddress

app = Flask(__name__)

# curl -X GET "http://localhost:5000/tainted7/touch%20HELLO"
@app.route("/tainted7/<something>")
def test_sources_7(something):
    
    # Modified by Rezilant AI, 2026-08-20 14:38:56 GMT, Replaced os.system with subprocess.run to prevent command injection by validating IP and using argument list instead of shell execution
    try:
        ipaddress.ip_address(request.remote_addr)
        result = subprocess.run(['echo', request.remote_addr],
                              shell=False,
                              capture_output=True,
                              timeout=5,
                              check=True)
    except (ValueError, subprocess.TimeoutExpired, subprocess.CalledProcessError):
        pass
    
    # Original Code
    # os.system(request.remote_addr) 

    return "foo"

if __name__ == "__main__":
	app.run(debug=True)