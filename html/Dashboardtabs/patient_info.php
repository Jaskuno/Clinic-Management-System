<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Information</title>
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
			margin-top: 20px;
			margin-bottom: 20px;
			margin-left: auto;
			margin-right: auto;
			padding: 20px;
			border: 2px solid #74B49B;
			border-radius: 10px;
			background-color: white;
			box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
		}
		.row {
			display: flex;
		}
		.column {
			flex: 50%;
			margin-left: 30px;
		}
		h1 {
			text-align: center;
			border-bottom: 2px solid #74B49B;
			color: #333;
		}
		img {
			width: 55%;
			height: auto;
			border: 1px solid #74B49B;
			border-radius: 10px;
			margin-left: 70px;
		}
		label {
			display: inline-block;
			margin-top: 10px;
			margin-left: 20px;
			font-size: 20px;
			font-weight: bold;
			color: #333;
		}
		.column p {
			display: inline;
			margin-left: 10px;
			color: #666;
		}
		li {
			display: flex;
			flex-wrap: wrap;
			width: 87%;
			border-radius: 10px;
			justify-content: space-between;
			align-items: center;
			padding: 0 50px;
			border: 1px solid #ddd;
			background-color: #f9f9f9;
			cursor: pointer;
			margin-bottom: 10px;
			
		}
		li .list p {
			display: inline;
			margin-left: 50px;
			font-size: 20px;
			font-weight: bold;
			color: #333;
		}
		li button {
			border: none;
			font-size: 30px;
			cursor: pointer;
			background-color: #f9f9f9;
			color: #333;
		}
		li .info p {
			text-align: justify;
			color: #666;
		}
    </style>
	<script>
		window.onload = function() {
			var dropdownButtons = document.getElementsByClassName("dropdown-button");
			for (var i = 0; i < dropdownButtons.length; i++) {
				dropdownButtons[i].addEventListener("click", function() {
					var info = this.nextElementSibling;
					if (info.style.display === "none") {
						info.style.display = "block";
					} else {
						info.style.display = "none";
					}
				});
			}
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

        if (isset($_GET['patient_id'])) {
            $patientId = $_GET['patient_id'];

            $patientQuery = "SELECT * FROM patient_info WHERE patient_id = $patientId";
            $patientResult = $conn->query($patientQuery);

            if ($patientResult->num_rows > 0) {
                $patientRow = $patientResult->fetch_assoc();

                $historyQuery = "SELECT * FROM patient_history WHERE patient_id = $patientId";
                $historyResult = $conn->query($historyQuery);
            }
        }
    ?>

    <div class="container">
        <h1>Patient Information</h1>
        <div class="row">
            <div class="column">
                <img src="user.png" alt="Patient">
            </div>
            <div class="column">
                <label>Name: </label><p><?php echo $patientRow['name']; ?></p><br>
                <label>Age: </label><p><?php echo $patientRow['age']; ?></p><br>
                <label>Gender: </label><p><?php echo $patientRow['gender']; ?></p><br>
                <label>Contact No.: </label><p><?php echo $patientRow['contact_no']; ?></p>
            </div>
            <div class="column">
                <label>Email: </label><p><?php echo $patientRow['email']; ?></p><br>
                <label>Status: </label><p><?php echo $patientRow['status']; ?></p><br>
                <label>Birthday: </label><p><?php echo $patientRow['birthday']; ?></p>
            </div>
        </div>
    </div>

    <?php
        if ($historyResult->num_rows > 0) {
            echo '<div class="container history-container">
                    <h1>History</h1>
                    <ul class="history-list">';

            while ($historyRow = $historyResult->fetch_assoc()) {
                echo '<li>
                        <div class="list">
                            <p>' . $historyRow['date'] . '</p>
                            <p>' . $historyRow['doctor'] . '</p>
                        </div>
                        <button class="dropdown-button">▼</button>
                        <div class="info" style="display: none;">
                            <label>Chief Complaint: </label><p>' . $historyRow['chief_complaint'] . '</p>
                            <label>Consultation Results: </label><p>' . $historyRow['consultation_results'] . '</p><br><br>
                        </div>
                    </li>';
            }

            echo '</ul></div>';
        }

        $conn->close();
    ?>
</body>
</html>
