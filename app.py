from flask import Flask, request,render_template,url_for, session
# from flask_mysqldb import MySQL
# import MySQLdb.cursors
import re
import mysql.connector
import json
import mysql.connector

from werkzeug.utils import redirect

app=Flask(__name__)

app.config.from_object('config.DevelopmentConfig')
with open('credentials.json','r') as f:
    config=json.load(f)

# app.config['MYSQL_HOST'] = 'localhost'
# app.config['MYSQL_USER'] = 'root'
# app.config['MYSQL_PASSWORD'] = 'saritamanas'
# app.config['MYSQL_DB'] = 'owasp_top10'
 
# mysql = MySQL(app)



mydb = mysql.connector.connect(
  host=config['MYSQL_HOST'],
  user=config["MYSQL_USER"],
  password=config[ "MYSQL_PASSWORD"],
  database=config["database"]
)

mycursor = mydb.cursor()

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/form')
def form():
    return render_template('form.html')

@app.route('/register',methods=['POST','GET'])
def register():
    msg=''
    if request.method=='POST' and 'username' in request.form and 'password' in request.form and 'email' in request.form:
        username=request.form['username']
        password=request.form['password']
        email=request.form['email']
        
        mycursor.execute('SELECT * FROM accounts WHERE username=%s',(username, ))
        # account=cursor.fetchone()
        account = mycursor.fetchall()
        if account:
            msg='Account already exists'
        elif not re.match(r'[^@]+@[^@]+\.[^@]+', email):
            msg='Invalid email'
        elif not re.match(r'[A-Za-z0-9]+', username):
            msg='Username must only contain characters and number! '
        elif not username or not password or not email:
            msg='Please fill the form completely!'
        else:
            mycursor.execute('INSERT INTO accounts VALUES (NULL,%s,%s,%s)',(username,password,email, ))
            mydb.commit()
            msg='You have successfully registered'
        return render_template('register.html',msg=msg)
    elif request.method=='GET':
        return render_template('register.html',msg = msg)

@app.route('/login',methods=['POST','GET'])
def login():
    msg=''
    if request.method=='POST' and 'username' in request.form and 'password' in request.form:
        username=request.form['username']
        password=request.form['password']
        # cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        mycursor.execute('SELECT * FROM accounts WHERE username = %s AND password = %s', (username, password))
        account = mycursor.fetchall()
        print(account)
        print(username)
        if account:
            session['loggedin']=True
            session['id']=account[0][0]
            session['username']=account[0][1]
            msg='successfully loggedin'
            print("logged in")
            return render_template('index.html',msg=msg)
        else:
            msg='incorrect username/password'
    return render_template('login.html',msg=msg)


@app.route('/logout')
def logout():
    session.pop('loggedin',None)
    session.pop('id',None)
    session.pop('username',None)
    print("Logged out")
    return redirect(url_for('login'))





## DATABASE CODE
# create database owasp_top10;
# use owasp_top10;
# show tables;

# CREATE TABLE IF NOT EXISTS `accounts` (
#  `id` int(11) NOT NULL auto_increment,
#  `username` varchar(50) NOT NULL,
#  `password` varchar(255) NOT NULL,
#  `email` varchar(100) NOT NULL,
#   PRIMARY KEY(`id`)
#   )ENGINE=InnoDB auto_increment=2 default char set=utf8
 

if __name__ == '__main__':

    app.run(host='0.0.0.0',debug=True,port=5000)
