<?php
include __DIR__ . '/mysqlConn.php';
session_start();
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated values from the form
    $doctor_Email = $_POST['doctor_Email'];
    $doctor_Username = $_POST['doctor_Username'];
    $doctor_Address = $_POST['doctor_Address'];
    $doctor_Contact = $_POST['doctor_Contact'];
    $doctor_Password = $_POST['doctor_Password'];


    if (isset($_SESSION['doctor_ID'])) {
        $doctor_ID = $_SESSION['doctor_ID']; 
        // Update data in the database
        $connection = connect_to_mysql();

        $query = "UPDATE doctors 
                  SET doctor_Email = ?, doctor_Username = ?, doctor_Address = ?, doctor_Contact = ?, doctor_Password = ?
                  WHERE doctor_ID = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'sssssi', $doctor_Email, $doctor_Username, $doctor_Address, $doctor_Contact, $doctor_Password, $doctor_ID);

        $result = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($connection);

        if ($result) {
            echo "<script>
                    alert('Profile updated successfully!');
                    window.location.href = 'dashboard.php?doctor_ID=$doctor_ID';
                  </script>";
        } else {
            echo "Error updating profile: " . mysqli_error($connection);
        }
    } else {
        echo "Error: doctor_ID not set in the session.";
    }
} else {

    header("Location: dashboard.php");
    exit();
}
?>