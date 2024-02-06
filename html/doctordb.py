#! C:/Users/gmb04/Desktop/FileRecovery/BAET/python/python.exe
print("Content-Type: text/html\n")
print()

import mysql.connector
import cgi

# Get form data
form = cgi.FieldStorage()

email = form.getvalue("DOCTOR_Email")
username = form.getvalue("DOCTOR_Username")
address = form.getvalue("DOCTOR_Address")
contact_number = form.getvalue("DOCTOR_ContactNumber")
password = form.getvalue("DOCTOR_Password")
name = form.getvalue("DOCTOR_Name")

# Function to establish a connection to MySQL
def connect_to_mysql():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="cms"
    )
    
# Function to insert data into the database
def insert_data(email, username, address, contact_number, password, name):
    try:
        connection = connect_to_mysql()
        cursor = connection.cursor()

        query = "INSERT INTO doctors (doctor_Email, doctor_Address, doctor_Contact, doctor_Username, doctor_Password, doctor_Name) VALUES (%s, %s, %s, %s, %s, %s)"
        values = (email, address, contact_number, username, password, name)

        cursor.execute(query, values)
        connection.commit()

        print("""
            <script>
                alert('Registration successful!');
                window.location.href = 'Login.html';
            </script>
        """)

    except Exception as e:
        print("Error: {}".format(e))

    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

# Insert data into the database
insert_data(email, username, address, contact_number, password, name)
