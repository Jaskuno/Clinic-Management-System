#! C:/Users/gmb04/Desktop/FileRecovery/BAET/python/python.exe
print("Content-Type: text/html\n")
print()

import mysql.connector
import cgi

# Get form data
form = cgi.FieldStorage()

patientName = form.getvalue("patientName")
age = form.getvalue("age")
sex = form.getvalue("sex")
status = form.getvalue("status")
appointmentDate = form.getvalue("appointmentDate")
emailAddress = form.getvalue("emailAddress")
contactNumber = form.getvalue("contactNumber")
concern = form.getvalue("concern")

# Function to establish a connection to MySQL
def connect_to_mysql():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="cms"
    )
    
# Function to insert data into the database
def insert_data(patientName, age, sex, status, appointmentDate, emailAddress, contactNumber, concern):
    try:
        connection = connect_to_mysql()
        cursor = connection.cursor()

        query = "INSERT INTO customerapnmt (patient_Name, patient_Age, patient_Sex, patient_Status, patient_ApmtDate, patient_Email, patient_Contact, patient_Concern) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
        values = (patientName, age, sex, status, appointmentDate, emailAddress, contactNumber, concern)


        cursor.execute(query, values)
        connection.commit()

        print("""
            <script>
                alert('Successfully make an Appointment!');
                window.location.href = '../Home.html';
            </script>
        """)

    except Exception as e:
        print("Error: {}".format(e))

    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

# Insert data into the database
insert_data(patientName, age, sex, status, appointmentDate, emailAddress, contactNumber, concern)
