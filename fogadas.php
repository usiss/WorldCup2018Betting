
   <?php
      include('config.php');

   session_start();
   
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysqli_query($db,"select username,id,rendesnev from felhasznalok where username = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['username'];
   $rend = $row['rendesnev'];
   $login_id = $row['id'];
   $login_name = $row['username'];
   
   
   if(!isset($_SESSION['login_user'])){
      header("location:index.php");
   }
   

?>


<!DOCTYPE html>
<html lang="en">

  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Házifogadás VB 2018 - <?php echo $login_session; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>


    <!-- Custom styles for this template -->
    <link href="css/scrolling-nav.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Házifogadás - <?php echo $rend ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#tippeles">Tippelés</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#eddigi">Eddigi tippjeim</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#ranglista">Ranglista</a>
            </li>
			<li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="szabalyok.php" target="_blank">Szabályok</a>
            </li>
			<li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="logout.php"><font style="color:red">Kilépés</font></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>


    <section id="tippeles">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
			
            <h2>Jelenlegi meccs: <br> <font style="color: blue"> <?php 
			// Create connection
$conn = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

 

			$sql = "SELECT id,hazainev,vendegnev,szakasz,datum,datumszam,lezart FROM meccs WHERE lezart=0  ORDER BY id DESC LIMIT 1 ";
			$result = $conn->query($sql);


			if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		if($row["szakasz"]==1){ ?><font color="black" size="5px"> <?php echo "Csoportkör"  ?></font> <?php }
		else if($row["szakasz"]==2){ ?><font color="black" size="5px"> <?php echo "Nyolcaddöntő"  ?></font> <?php }
		else if($row["szakasz"]==3){ ?><font color="black" size="5px"> <?php echo "Negyeddöntő"  ?></font> <?php }
		else if($row["szakasz"]==4){ ?><font color="black" size="5px"> <?php echo "Elődöntő"  ?></font> <?php }
		else if($row["szakasz"]==5){ ?><font color="black" size="5px"> <?php echo "Bronzmérkőzés"  ?></font> <?php }
		else if($row["szakasz"]==6){ ?><font color="black" size="5px"> <?php echo "Döntő"  ?></font> <?php }
        echo  " <br>". $row["hazainev"]. " - " . $row["vendegnev"]. "  <br> " . $row["datum"]. "<br>";
    }
} else {
    echo "Nincs fogadható meccs!";
} 

 
?> </font>
			
			</h2>
            <p class="lead">
			</p>

			
			
<script type="text/javascript">
    function validateForm()
    {
        var a=document.forms["Form"]["hazai"].value;
        var b=document.forms["Form"]["vendeg"].value;
        if (a==null || a=="",b==null || b=="")
        {
            alert("Tippelj valamilyen eredményt!");
            return false;
        }
    }
</script>
			
 <?php
 
 $sqll = "SELECT id FROM meccs WHERE lezart=0 ORDER BY id DESC LIMIT 1";
			$resultt = $conn->query($sqll);
			
			
	
 	
			
    if(isset($_POST['tipp'])){
		
		
		
        $sql = "INSERT INTO tippek (meccsid, userid, username, hazai, vendeg, datum, datumszam)
        VALUES ('".$_POST["meccsidd"]."','".$_POST["useridd"]."','".$_POST["username"]."','".$_POST["hazai"]."','".$_POST["vendeg"]."', '".$_POST["datum"]."','".$_POST["datumszam"]."')";
		
		 $result = mysqli_query($conn,$sql);
		 
		 $meccsidje = $_POST["meccsidd"];
		 $felhidje = $_POST ["useridd"];
		 $fogdatum = $_POST ["datum"];
		 $szamdatum = $_POST ["datumszam"];
		
		$torles = "DELETE FROM tippek WHERE meccsid=$meccsidje AND userid=$felhidje AND datumszam<$szamdatum";
		if(mysqli_query($conn, $torles)){
    echo "";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
		
		echo "<meta http-equiv='refresh' content='0'>";
		 
    }
	$count = mysqli_num_rows($resultt);
	
	
	if($count == 1){
        ?>
   
		   <form class="form-inline" action="" name="Form" method="post" onsubmit="return validateForm()">
		   <div class="form-group">
    <input type="hidden" class="form-control" id="meccsidd" name="meccsidd" value="<?php while($row = $resultt->fetch_assoc()) {
        echo  "  " . $row["id"]. "";
    } ?>">
  </div>
  <div class="form-group">
    <input type="hidden" class="form-control" id="useridd" name="useridd" value="<?php echo $login_id ?>">
  </div>
  <div class="form-group">
    <input type="hidden" class="form-control" id="username" name="username" value="<?php echo $login_session;?>">
  </div>
  <div class="form-group">
    <input type="text" size="3" class="form-control" id="a" name="hazai">
  </div>
  <b> &nbsp:&nbsp</b>
  <div class="form-group">
    <input type="text" size="3" class="form-control" id="b" name="vendeg">
  </div>
  <div class="form-group">
    <input type="hidden" class="form-control" id="datum" name="datum" value="<?php echo date("Y-m-d G:i:s"); ?>">
  </div>
  <div class="form-group">
    <input type="hidden" class="form-control" id="datumszam" name="datumszam" value="<?php echo $datetime = strtotime(date("Y-m-d G:i:s")); ?>">
  </div>
  &nbsp
  <button type="submit" name="tipp" class="btn btn-dark">Tipp!</button>
  
  
</form>
		 
		   
	<?php } ?>   
		   
		   
		   
		   
		   
		   
          </div>
        </div>
      </div>
    </section>
	

	<section id="tippeles">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
			
            <h2>Végső győztes megtippelése <br> 
			
			</h2>
            <p class="lead">
			</p>

			
			
<script type="text/javascript">
    function validateForm()
    {
        var a=document.forms["Formvegso"]["csapat"].value;
        if (csapat==null || csapat=="")
        {
            alert("Tippelj valamelyik csapatra!");
            return false;
        }
    }
</script>
			
 <?php
 
 $sqll = "SELECT * FROM felhasznalok;";
			$resultt = $conn->query($sqll);
			
			
	
 	
			
    if(isset($_POST['vegsotipp'])){
		
			
	$felhid = $_POST['felhid'];
    $csapat = $_POST['csapat'];
		
	$vegso = "UPDATE felhasznalok SET vegsogyoztes=$csapat WHERE id=$felhid";

if ($conn->query($vegso) === TRUE) {
    		echo "<meta http-equiv='refresh' content='0'>";

} else {
    echo "Error updating record: " . $conn->error;
}
		 
	
	
	
	
	
	}
	
	

        ?>
   
		   <form class="form-inline" action="" name="Formvegso" method="post" onsubmit="return validateForm()">
		
  <div class="form-group">
    <input type="hidden" class="form-control" id="felhid" name="felhid" value="<?php echo $login_id ?>">
  </div>
  <div class="form-group">
  <select style="width: 250px;" name="csapat" id="csapat">
  <option value="1">Anglia</option>
  <option value="2">Argentína</option>
  <option value="3">Ausztrália</option>
  <option value="4">Belgium</option>
  <option value="5">Brazília</option>
  <option value="6">Costa Rica</option>
  <option value="7">Dánia</option>
  <option value="8">Dél-Korea</option>
  <option value="9">Egyiptom</option>
  <option value="10">Franciaország</option>
  <option value="11">Horvátország</option>
  <option value="12">Irán</option>
  <option value="13">Izland</option>
  <option value="14">Japán</option>
  <option value="15">Kolumbia</option>
  <option value="16">Lengyelország</option>
  <option value="17">Marokkó</option>
  <option value="18">Mexikó</option>
  <option value="19">Németország</option>
  <option value="20">Nigéria</option>
  <option value="21">Oroszország</option>
  <option value="22">Panama</option>
  <option value="23">Peru</option>
  <option value="24">Portugália</option>
  <option value="25">Spanyolország</option>
  <option value="26">Svájc</option>
  <option value="27">Svédország</option>
  <option value="28">Szaúd-Arábia</option>
  <option value="29">Szenegál</option>
  <option value="30">Szerbia</option>
  <option value="31">Tunézia</option>
  <option value="32">Uruguay</option>
  </select>
  </div>
  
  &nbsp
  <button type="submit" name="vegsotipp" class="btn btn-dark">Tipp!</button>
  
  
</form>
  
<?php 
			// Create connection
$conn = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

 

			$sql = "SELECT * FROM felhasznalok WHERE vegsogyoztes>0 AND id=$login_id";
			$result = $conn->query($sql);


			if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		if($row["vegsogyoztes"]==1){echo " <b>Tipped:</b> Anglia";}
		else if($row["vegsogyoztes"]==2){echo " <b>Tipped:</b> Argentína";}
		else if($row["vegsogyoztes"]==3){echo " <b>Tipped:</b> Ausztrália";}
		else if($row["vegsogyoztes"]==4){echo " <b>Tipped:</b> Belgium";}
		else if($row["vegsogyoztes"]==5){echo " <b>Tipped:</b> Brazília";}
		else if($row["vegsogyoztes"]==6){echo " <b>Tipped:</b> Costa Rica";}
		else if($row["vegsogyoztes"]==7){echo " <b>Tipped:</b> Dánia";}
		else if($row["vegsogyoztes"]==8){echo " <b>Tipped:</b> Dél-Korea";}
		else if($row["vegsogyoztes"]==9){echo " <b>Tipped:</b> Egyiptom";}
		else if($row["vegsogyoztes"]==10){echo " <b>Tipped:</b> Franciaország";}
		else if($row["vegsogyoztes"]==11){echo " <b>Tipped:</b> Horvátország";}
		else if($row["vegsogyoztes"]==12){echo " <b>Tipped:</b> Irán";}
		else if($row["vegsogyoztes"]==13){echo " <b>Tipped:</b> Izland";}
		else if($row["vegsogyoztes"]==14){echo " <b>Tipped:</b> Japán";}
		else if($row["vegsogyoztes"]==15){echo " <b>Tipped:</b> Kolumbia";}
		else if($row["vegsogyoztes"]==16){echo " <b>Tipped:</b> Lengyelország";}
		else if($row["vegsogyoztes"]==17){echo " <b>Tipped:</b> Marokkó";}
		else if($row["vegsogyoztes"]==18){echo " <b>Tipped:</b> Mexikó";}
		else if($row["vegsogyoztes"]==19){echo " <b>Tipped:</b> Németország";}
		else if($row["vegsogyoztes"]==20){echo " <b>Tipped:</b> Nigéria";}
		else if($row["vegsogyoztes"]==21){echo " <b>Tipped:</b> Oroszország";}
		else if($row["vegsogyoztes"]==22){echo " <b>Tipped:</b> Panama";}
		else if($row["vegsogyoztes"]==23){echo " <b>Tipped:</b> Peru";}
		else if($row["vegsogyoztes"]==24){echo " <b>Tipped:</b> Portugália";}
		else if($row["vegsogyoztes"]==25){echo " <b>Tipped:</b> Spanyolország";}
		else if($row["vegsogyoztes"]==26){echo " <b>Tipped:</b> Svájc";}
		else if($row["vegsogyoztes"]==27){echo " <b>Tipped:</b> Svédország";}
		else if($row["vegsogyoztes"]==28){echo " <b>Tipped:</b> Szaúd-Arábia";}
		else if($row["vegsogyoztes"]==29){echo " <b>Tipped:</b> Szenegál";}
		else if($row["vegsogyoztes"]==30){echo " <b>Tipped:</b> Szerbia";}
		else if($row["vegsogyoztes"]==31){echo " <b>Tipped:</b> Tunézia";}
		else if($row["vegsogyoztes"]==32){echo " <b>Tipped:</b> Uruguay";}
    }
} else {
    echo "Nincs még tipped!";
} 

 
?>
		   <br>A VB kezdetéig változtatható!
          </div>
        </div>
      </div>
    </section>	
	

    <section id="eddigi" class="bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h2>Eddigi tippjeim</h2>
            
			
			
			
			<?php 
			
			
			// Create connection
$conn = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

			$sql = "SELECT meccs.id,meccs.hazainev,meccs.vendegnev, meccs.hazaipont, meccs.vendegpont, tippek.hazai, tippek.vendeg, tippek.datum FROM meccs INNER JOIN tippek ON meccs.id=tippek.meccsid WHERE tippek.userid=$login_id ORDER BY tippek.datum DESC ";
			$result = $conn->query($sql);


			if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo  " <b>Tipp: </b> " . $row["hazainev"]. " - " . $row["vendegnev"]. " <b>" . $row["hazai"]. " : " . $row["vendeg"]. "</b> - " . $row["datum"]. "<br>";
		if(($row["hazaipont"])>($row["vendegpont"]) && (($row["hazai"])>($row["vendeg"]))){?> <font color="green"> <?php }else if(($row["hazaipont"])<($row["vendegpont"]) && (($row["hazai"])<($row["vendeg"]))){ ?><font color="green">
		<?php }else if(($row["hazaipont"])<($row["vendegpont"]) && (($row["hazai"])>($row["vendeg"]))){ ?><font color="red"> <?php }else if(($row["hazaipont"])>($row["vendegpont"]) && 
		(($row["hazai"])<($row["vendeg"]))){ ?><font color="red"> <?php };if(($row["hazaipont"])!=99){ echo " <b> Végeredmény:   ".$row["hazaipont"]. " - ".$row["vendegpont"]."</font></b><br>";}else{echo "<b>Még nincs végeredmény!</b> <br>";}; 
    }
} else {
    echo "Még nincs tipped!";
} 


?>
			
			
			
			
			
			
			
			</p>
			
			
			
          </div>
        </div>
      </div>
    </section>
	
	

    <section id="ranglista">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h2>Ranglista</h2>
            
			
			<p>Szabályok: <a href="szabalyok.php" target="_blank">Link</a></p>
			<?php 
			
			
			// Create connection
$conn = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

			$sql = "SELECT felhrendes, pont FROM ranglista ORDER BY pont DESC";
			$result = $conn->query($sql);

?><ul><?php
			if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo  " <table width='100%'><tr><td width='50%'><b> " . $row["felhrendes"]. " </b></td><td> Pont: " . $row["pont"]. " </td></tr></table>";
    }
} 
?></ul><?php

?>
			
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">VB 2018 - <a href="admin.php">Admin</a></p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom JavaScript for this theme -->
    <script src="js/scrolling-nav.js"></script>

  </body>

</html>
