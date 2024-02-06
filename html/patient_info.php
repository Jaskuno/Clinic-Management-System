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
		.patient_info_container {
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
		.patient_info_row {
			display: flex;
		}
		.patient_info_column {
			display:block;
			flex:50%;
			margin-left: 30px;
		}
		.patient_info_header {
			text-align: center;
			border-bottom: 2px solid #74B49B;
			color: #333;
		}
		.patient_info_column .patient_info_img {
			width: 55%;
			height: auto;
			border: 1px solid #74B49B;
			border-radius: 10px;
			margin-left: 70px;
		}
		.patient_info_label {
			display: inline-block;
			margin-top: 10px;
			margin-left: 20px;
			font-size: 20px;
			font-weight: bold;
			color: #333;
		}
		.patient_info_column .patient_info_p {
			display: inline;
			margin-left: 10px;
			color: #666;
		}
		.patient_history_lists {
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
		.patient_history_lists .patient_history_list .patient_history {
			display: inline;
			margin-left: 50px;
			font-size: 20px;
			font-weight: bold;
			color: #333;
		}
		.patient_history_lists .dropdown-button {
			border: none;
			font-size: 30px;
			cursor: pointer;
			background-color: #f9f9f9;
			color: #333;
		}
		.patient_history_lists .patient_history_info .patient_history_label {
			font-weight: bold;
		}
		.patient_history_lists .patient_history_info .patient_history_p {
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
        $dbname = "cms";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_GET['info_ID'])) {
            $patientId = $_GET['info_ID'];

            $patientQuery = "SELECT * FROM patient_info WHERE info_ID = $patientId";
            $patientResult = $conn->query($patientQuery);

            if ($patientResult->num_rows > 0) {
                $patientRow = $patientResult->fetch_assoc();

                $historyQuery = "SELECT * FROM patient_history WHERE info_ID = $patientId";
                $historyResult = $conn->query($historyQuery);
            }
        }
    ?>

    <div class="patient_info_container">
        <h1 class="patient_info_header"><a href="http://localhost/Clinic-Management-System/html/dashboard.php"><img src="../Pics/logo.png" width="60px" height="60px"/></a>Patient Information</h1>
        <div class="patient_info_row">
            <div class="patient_info_column">
                <img src="user.png" alt="Patient" class="patient_info_img">
            </div>
            <div class="patient_info_column">
				<div>
                <label class="patient_info_label">Name: </label><p class="patient_info_p"><?php echo $patientRow['info_Name']; ?></p><br>
				</div>
				<div>
				<label class="patient_info_label">Age: </label><p class="patient_info_p"><?php echo $patientRow['info_Age']; ?></p><br>
                </div>
				<div>
				<label class="patient_info_label">Gender: </label><p class="patient_info_p"><?php echo $patientRow['info_Sex']; ?></p><br>
				</div>
			</div>
            <div class="patient_info_column">
				<div>
				<label class="patient_info_label">Contact No.: </label><p class="patient_info_p"><?php echo $patientRow['info_Contact']; ?></p>
				</div>
				<div>
				<label class="patient_info_label">Email: </label><p class="patient_info_p"><?php echo $patientRow['info_Email']; ?></p><br>
				</div>
				<div>
				<label class="patient_info_label">Status: </label><p class="patient_info_p"><?php echo $patientRow['info_Status']; ?></p><br>
				</div>
            </div>
        </div>
    </div>

    <?php
        if ($historyResult->num_rows > 0) {
            echo '<div class="patient_info_container history-container">
                    <h1 class="patient_info_header">History</h1>
                    <ul class="history-list">';

            while ($historyRow = $historyResult->fetch_assoc()) {
                echo '<li class="patient_history_lists">
                        <div class="patient_history_list">
                            <p class="patient_history">' . $historyRow['date'] . '</p>
                            <p class="patient_history">' . $historyRow['doctor'] . '</p>
                        </div>
                        <button class="dropdown-button">▼</button>
                        <div class="patient_history_info" style="display: none;">
                            <label class="patient_history_label">Chief Complaint: </label><p class="patient_history_p">' . $historyRow['chief_complaint'] . '</p>
                            <label class="patient_history_label">Consultation Results: </label><p class="patient_history_p">' . $historyRow['consultation_results'] . '</p><br><br>
                        </div>
                    </li>';
            }

            echo '</ul></div>';
        }

        $conn->close();
    ?>
	
</body>
</html>
