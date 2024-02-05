<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient List</title>
    <style>
        body {
            font-family: Century Gothic;
            background-color: #F5F5F5;
        }
		::-webkit-scrollbar {
			display: none;
		}
        .container {
            width: 85%;
            margin: 20px auto;
            padding: 20px;
            border: 2px solid #74B49B;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
		.container h1 {
            text-align: center;
            border-bottom: 2px solid #74B49B;
            color: #333;
        }
        .patient-list li {
			display: flex;
			flex-wrap: wrap;
			width: 87%;
			height: 40px;
			border-radius: 10px;
			justify-content: space-between;
			align-items: center;
			padding: 0 50px;
			border: 1px solid #ddd;
			background-color: #f9f9f9;
			cursor: pointer;
			margin-bottom: 10px;
		}
        .patient-list li .list p {
            display: inline;
            margin-left: 50px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
    </style>
    <script>
        function showPatientInfo(patientId) {
            window.location.href = 'patient_info.php?patient_id=' + patientId;
        }
    </script>
</head>
<body>
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "patients";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    ?>

    <div class="container">
        <h1>Patient List</h1>
        <ul class="patient-list">
            <?php
                $patientListQuery = "SELECT * FROM patient_info";
                $patientListResult = $conn->query($patientListQuery);

                if ($patientListResult->num_rows > 0) {
                    while ($patient = $patientListResult->fetch_assoc()) {
                        echo '<li onclick="showPatientInfo(' . $patient['patient_id'] . ')">
                                <div class="list">
                                    <p>' . $patient['name'] . '</p>
                                </div>
                            </li>';
                    }
                }
            ?>
        </ul>
    </div>

    <?php
        $conn->close();
    ?>
</body>
</html>
