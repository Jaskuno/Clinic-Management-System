from flask import Flask, render_template, request, redirect
import mysql.connector

app = Flask(__name__)

# MySQL database configuration
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="clinic"
)

cursor = db.cursor()

# Flask route for rendering the HTML form
@app.route('/')
def index():
    return render_template('templates/register.html')

# Flask route for handling form submission
@app.route('/submit_form', methods=['POST'])
def submit_form():
    if request.method == 'POST':
        email = request.form['Email']
        username = request.form['Username']
        address = request.form['Address']
        contact_number = request.form['ContactNumber']
        password = request.form['Password']

        # MySQL query to insert data into the database
        insert_query = "INSERT INTO doctoracc (Email, Username, Address, ContactNumber, Password) VALUES (%s, %s, %s, %s, %s)"
        values = (email, username, address, contact_number, password)

        try:
            cursor.execute(insert_query, values)
            db.commit()
            return redirect('/success')  # Redirect to a success page
        except Exception as e:
            db.rollback()
            return f"An error occurred: {str(e)}"

# Additional Flask route for a success page
@app.route('/success')
def success():
    return "Registration successful!"

if __name__ == '__main__':
    app.run(debug=True)