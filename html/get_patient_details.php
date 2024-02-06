<?php
if (isset($_GET['patientID'])) {
    $patientID = $_GET['patientID'];

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "cms");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch patient details from the database based on the patientID
    $patientDetailsQuery = "SELECT * FROM patient_info WHERE info_ID = $patientID";
    $patientDetailsResult = $conn->query($patientDetailsQuery);

    if ($patientDetailsResult->num_rows > 0) {
        $patientDetails = $patientDetailsResult->fetch_assoc();

        // You can customize the HTML structure here based on your requirements
        $output = '<h2>' . $patientDetails['info_Name'] . '</h2>';
        $output .= '<p>Age: ' . $patientDetails['info_Age'] . '</p>';
        $output .= '<p>Gender: ' . $patientDetails['info_Sex'] . '</p>';
        $output .= '<p>Contact No.: ' . $patientDetails['info_Contact'] . '</p>';
        $output .= '<p>Email: ' . $patientDetails['info_Email'] . '</p>';
        $output .= '<p>Status: ' . $patientDetails['info_Status'] . '</p>';

        echo $output;
    } else {
        echo 'Patient not found.';
    }

    // Close the database connection
    $conn->close();
} else {
    echo 'Invalid request.';
}
?>