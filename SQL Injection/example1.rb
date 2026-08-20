class ApplicationController < ActionController::Base
protect_from_forgery with: :exception
end
class UsersController < ApplicationController
def update
con = Mysql.new 'localhost', 'user', 'pwd'
# Modified by Rezilant AI, 2026-08-20 14:36:51 GMT, Replaced string concatenation with parameterized query to prevent SQL injection
# SECURE: Parameterized query prevents SQL injection by separating SQL logic from user data
con.query('UPDATE users SET name = ? WHERE id = ?', params[:name], params[:id])
# Original Code
# con.query 'UPDATE users set name = ' + params[:name] +
# ' where id = ' + params[:id]
con.close
end
end