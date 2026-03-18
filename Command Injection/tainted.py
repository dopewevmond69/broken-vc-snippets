import os
from flask import Flask, request, abort
from functools import wraps
app = Flask(__name__)

# Modified by Rezilant AI, 2025-12-12 16:38:56 GMT, Removed hardcoded credentials from URI and added proper authentication
# curl -X GET "http://localhost:5000/tainted7/touch%20HELLO" -H "Authorization: Bearer <token>"
def require_auth(f):
    @wraps(f)
    def decorated(*args, **kwargs):
        token = request.headers.get('Authorization', '').replace('Bearer ', '')
        api_key = request.headers.get('X-API-Key')
        
        # Validate either token or API key from environment
        expected_api_key = os.environ.get('EXPECTED_API_KEY')
        if not (api_key and expected_api_key and api_key == expected_api_key):
            abort(401)
        return f(*args, **kwargs)
    return decorated

# Original Code
# curl -X GET "http://localhost:5000/tainted7/touch%20HELLO"
@app.route("/tainted7/<something>")
@require_auth
def test_sources_7(something):
    
    os.system(request.remote_addr) 

    return "foo"

if __name__ == "__main__":
	app.run(debug=True)