#! C:/Users/gmb04/Desktop/FileRecovery/BAET/python/python.exe
print("Content-Type: text/html\n")
print()

import mysql.connector
import cgi

# Get form data
form = cgi.FieldStorage()

username_or_email = form.getvalue("Username")
password = form.getvalue("Password")

# Function to establish a connection to Xampp MySQL
def connect_to_mysql():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="cms"
    )

# Function to validate login credentials
def validate_login(username_or_email, password):
    try:
        connection = connect_to_mysql()
        cursor = connection.cursor()

        query = "SELECT * FROM doctors WHERE (doctor_Username = %s OR doctor_Email = %s) AND doctor_Password = %s"
        values = (username_or_email, username_or_email, password)

        cursor.execute(query, values)
        result = cursor.fetchone()

        if result:
            print("""
            <script>
                alert('Log-in successfully!');
                window.location.href = 'Home.html';
            </script>
            """)
        else:
            print("""
            <script>
                alert('Invalid username/email or password!');
                window.location.href = 'Login.html';
            </script>
            """)

    except Exception as e:
        print("Error: {}".format(e))

    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

# Validate login credentials
validate_login(username_or_email, password)