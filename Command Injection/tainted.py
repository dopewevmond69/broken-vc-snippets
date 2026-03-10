import os
from flask import Flask, request
import subprocess
app = Flask(__name__)

# curl -X GET "http://localhost:5000/tainted7/touch%20HELLO"
@app.route("/tainted7/<something>")
def test_sources_7(something):
    
    # Modified by Rezilant AI, 2026-03-10 12:27:53 GMT, Replaced os.system() with subprocess.run() to prevent command injection by treating IP address as literal argument instead of executable code
    subprocess.run(['echo', request.remote_addr], check=True, capture_output=True)
    
    # Original Code
    # os.system(request.remote_addr) 

    return "foo"

if __name__ == "__main__":
	app.run(debug=True)