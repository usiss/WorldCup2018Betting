

<?php
   include("config.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      
      
      $sql = "INSERT INTO felhasznalok (username, rendesnev, password)
        VALUES ('".$_POST["username"]."','".$_POST["rendes"]."','".$_POST["password"]."')";
      $result = mysqli_query($db,$sql);
	  
	
	   $sqll = "INSERT INTO ranglista (felhnev, felhrendes)
        VALUES ('".$_POST["username"]."','".$_POST["rendes"]."')";
      $resultt = mysqli_query($db,$sqll);
      
      header("Location: index.php");
      // If result matched $myusername and $mypassword, table row must be 1 row
		
     
   }
?>

<html lang="en">
<head>
	<title>Házifogadás VB 2018</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body background="images/bg.jpg">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				<form accept-charset="utf-8" action="" method="post" class="login100-form validate-form flex-sb flex-w">
					<span class="login100-form-title p-b-32">
						Házifogadás VB 2018 REGISZTRÁCIÓ
					</span>

					<span class="txt1 p-b-11">
						Felhasználónév
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Adj meg felhasználónevet">
						<input class="input100" type="text" name="username" >
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Teljes név
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Adj meg nevet">
						
						<input class="input100" type="text" name="rendes" >
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Jelszó
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Adj meg jelszót">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="password" >
						<span class="focus-input100"></span>
					</div>
					

					
					<div class="container-login100-form-btn">
						<input type = "submit" value="Regisztráció" class="login100-form-btn" />

						
					</div>

				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>