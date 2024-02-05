<?php
// Retrieve doctor_ID from the URL parameter
$doctor_ID = isset($_GET['doctor_ID']) ? $_GET['doctor_ID'] : '';

// Function to establish a connection to Xampp MySQL
function connect_to_mysql() {
    return mysqli_connect("localhost", "root", "", "cms");
}

// Function to fetch specific user information based on doctor_ID
function fetch_user_info($doctor_ID) {
    $connection = connect_to_mysql();

    $query = "SELECT doctor_Email, doctor_Address, doctor_Contact, doctor_Username, doctor_Password, doctor_Name FROM doctors WHERE doctor_ID = '$doctor_ID'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user_info = mysqli_fetch_assoc($result);
    } else {
        $user_info = null;
    }

    mysqli_close($connection);

    return $user_info;
}

// Fetch user information
$user_info = fetch_user_info($doctor_ID);
?>
</body>
</html>
<!DOCTYPE html>
<html>
<head> 
<title> Dashboard </title>
<style>
	/* html {
		overflow-y: hidden;
	} */
	* {
		text-decoration: none;
	}
	body {
		margin: 0;
		padding: 0;
        background-color: #2D4354;
	}
	
	/*HHHHHHHHEEEEEEEEEEEEAAAAAAAAAAAAADDDDDDDDDEEEEEEEERRRRRRRRRRR*/
	
	#burger	{
		display: block;
		position: relative;
		top: 45px;
		left: 50px;
		z-index: 1;
		height: 100%;
	}
	#burger input {
		width: 40px;
		height: 32px;
		position: absolute;
		cursor: pointer;
		opacity: 0;
		z-index: 2;
	}
	#burger input:checked ~ ul {
		transform:none;
	}
	.burgLine {
		display: block;
		width: 33px;
		height: 4px;
		margin-bottom: 5px;
		position: relative;
		background: black;
		border-radius: 3px;
		z-index: 1;
	}
	#menu {
		position: absolute;
		height:100vh;
        top:155px;
		width: 180px;
		margin: -100px 0 0 -50px;
		padding: 30px;
		background: #000133;
		list-style-type: none;
		transform: translate(-100%, 0);
		transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0);
        text-align: left;
	}
	#menu img {
		vertical-align: middle;
		height: 50px;
		width: 50px;
		position: relative;
		top: 5px;
        padding-right: 20px;
        margin-left: 10px;
	}
	#menu li {
		margin: 47px 0;
		transition: .3s;
		&:hover {
			color: rgb(27, 164, 206);
			transform: scale(1.1);
		}
	}
	#menu li span {
		font-size: 11px;
		font-weight: bold;
		font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		transition: .2s;
	}
	#menu a {
		text-decoration: none;
		color: white;
		&:hover{
			color:grey;
		}
	}
	
	/*MMMMMMEEEEEEEEEEEEEEEEEEEENNNNNNNNNNNNUUUUUUUUUU*/
	nav {
		display: flex;
		background-color: white;
		height: 100px;
	}
	#settings {
		position: absolute;
		right: 40px;
		top: 35px;
	}
	#settings img{
        filter:invert(20%);
		transition-duration: .3s;
		&:hover {
			filter: invert(0%);
		}
	}
	
	/* For Logout */
	.dropdown-content {
        display: none;
        position: absolute;
		right: -20px;
        background-color: #f9f9f9;
		border-radius: 10%;
        width: 80px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.8);
    	z-index: 1;
    }

    .dropdown-content a {
        display: block;
        padding: 10px;
        text-decoration: none;
		font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
		letter-spacing: 2px;
        color: #333;
		border-radius: 10%;
    }

    .dropdown-content a:hover {
        background-color: #aa780c;
		color:antiquewhite;
    }

    #settings:hover .dropdown-content {
        display: block;
    }
	/*MAAAAAAAAAAAAAAAAAAAIIIIIIIIIIIIINNNNNNNNNNNNNN*/
	/* Profile Style */
	.profile_content {
		margin: 10px;
		background-image:linear-gradient(rgba(172, 215, 255, 0.6), rgba(0, 0, 0, 0.60)); 
		border: .2px solid wheat;
		border-radius: 10%;
	}
	.profile_content p {
		padding:10px 0;
		margin:0;
	}
	/* profile form */
	.doctor_informations_container{
		margin: 20px;
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
		text-align: center;
		width:100%;
		background-image: linear-gradient(rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.6));
		border-radius: 2%;
	}
	.doctor_informations {
		padding: 50px;
	}
	.doctor_informations label{
		display: inline-flex;
		
		color: black;
		font-weight: bold;
		font-family: Verdana, Geneva, Tahoma, sans-serif;
	}
	.doctor_informations input {
		background-color: transparent;
		outline: none;
		color: black;
		border:none;
		border-bottom: .5px solid #333;
	}
	.doctor_informations input::oncl {
		background-color: transparent;
		outline: none;
		color: black;
		border:none;
	}

	/* Patient Style */
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
</head>
<body>
	<!-- Header -->
	<header style="position:fixed; width:100%;">
		<nav>
			<div id="burger">
				<input type="checkbox" style="margin: -5px 0 0 -3px; "/>
				<li class="burgLine"></li>
				<li class="burgLine"></li>
				<li class="burgLine"></li>
				<ul id="menu">
				<hr>
					<a href="#profile"><li><img src="../Pics/dashboard-icon/doctor.png"/><span>PROFILE</span></li></a>
					<hr>
					<a href="#appointment"><li><img src="../Pics/dashboard-icon/appointment.png"/><span>APPOINTMENT</span></li></a>
                    <a href="#patient"><li><img src="../Pics/dashboard-icon/patient.png"/><span>PATIENT</span></li></a>
                    <hr>
                </ul>
			</div>
			<div style="width:100%; overflow:hidden; padding:10px; position: relative; align-items: center; justify-content: center; text-align:center;">
				<h1 style="font-size: 40px; font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
					<img style="position: relative; top: -20px; width: 70px; border-radius: 100%;" src="../Pics/logo.png"/>
					<span style="position: relative; bottom: 40px;">
						<span style="color:rgb(63, 207, 218)"> Clinic</span>
						<span style="color: rgb(4, 1, 43);">System</span>
					</span>
				</h1>
			</div>
			<div id="settings">
				<a href="#"><img width=40px height=40px src="../Pics/settings.png"/></a>
				<div class="dropdown-content">
        			<a href="Home.html">Logout</a>
   				</div>
			</div>
		</nav>
	</header>
    <main style="background: #2D4354;">
        <div id="profile" style="background-color: rgba(11, 0, 73, 0.918); display:flex; padding: 130px 20px 50px 20px;">
			<div>
			<div class="profile_content">
				<img src="../Pics/doctor1.jpeg" style="width:200px; border-radius:10%;"/>
			</div>
			<div class="profile_content" style="border-radius: 0%; padding: 10px; color:#ddd; text-align:center;">
				<p>Dr. <?php echo $user_info['doctor_Name']; ?></p><br>
				<p><?php echo $user_info['doctor_Email']; ?></p><br>
				<p><?php echo $user_info['doctor_Address']; ?></p><br>
				<p><?php echo $user_info['doctor_Contact']; ?></p>
			</div>
			</div>
			<div class="profile_content" style="width: 100%; height:450px; background-color:rgba(9, 10, 49, 0.788); padding:20px; border-radius:5%;">
				<form action="dashboard.php" method="post" style="display: flex;">
                <?php
                if ($user_info) {
                    ?>
					<div class="doctor_informations_container">
						<div class="doctor_informations">
							<label for="doctor_Email">Email: </label>
							<input id="doctor_Email" placeholder="Email" type="email" value="<?php echo $user_info['doctor_Email']; ?>"/>
							<button type="button">Change</button>
						</div>
                    	<div class="doctor_informations">
							<label for="doctor_Username">Username: </label>
							<input id="doctor_Username" placeholder="Username" type="text" value="<?php echo $user_info['doctor_Username']; ?> "/> 
							<button type="button">Change</button>      		
						</div>
						<div class="doctor_informations">
							<label for="doctor_Address">Address: </label>                  		
							<input id="doctor_Address" placeholder="Address" type="text" value="<?php echo $user_info['doctor_Address']; ?>"/>
							<button type="button">Change</button>
						</div>
						<div class="doctor_informations">
							<label for="doctor_Contact">Contact: </label>
							<input id="doctor_Contact" placeholder="Contact No." type="tel" pattern="[0-9]{11}" value="<?php echo $user_info['doctor_Contact']; ?>"/>
							<button type="button">Change</button>
						</div>
						<div class="doctor_informations">
							<label for="doctor_Password">Password: </label>
							<input id="doctor_Password" placeholder="Password" type="password" value="<?php echo $user_info['doctor_Password']; ?>"/>
							<button type="button">Change</button>
						</div>
					</div>
                    <?php
                } else {
                    echo "User not found.";
                }
                ?>
            </form>
			</div>
        </div>
        <div id="patient" style="height:100vh; padding-top: 70px;">
            <div style="font-family: Century Gothic; background-color: #F5F5F5; padding:20px;">
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
            <?php $conn->close(); ?>
            </div>
        </div>
    </main>
</body>
</html>