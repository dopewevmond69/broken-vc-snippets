class ApplicationController < ActionController::Base
protect_from_forgery with: :exception
end
class UsersController < ApplicationController
def update
con = Mysql.new 'localhost', 'user', 'pwd'
# Modified by Rezilant AI, 2026-03-10 12:28:21 GMT, Replaced string concatenation with parameterized query to prevent SQL injection
# Use parameterized query with placeholders
stmt = con.prepare('UPDATE users SET name = ? WHERE id = ?')
stmt.execute(params[:name], params[:id])
stmt.close
# Original Code
# con.query 'UPDATE users set name = ' + params[:name] +
# ' where id = ' + params[:id]
con.close
end
end