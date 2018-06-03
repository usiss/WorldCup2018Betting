
   <?php
      include('config.php');

   session_start();
   
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysqli_query($db,"select username,id,rendesnev,admin from felhasznalok where username = '$user_check'");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['username'];
   $rend = $row['rendesnev'];
   
   
   if(($row['admin']==0)){
      header("location:index.php");
   }
?>


<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Házifogadás VB 2018 - Admin</title>

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
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Házifogadás - Admin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#eredmeny">Eredmény beírása</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#lezaras">Meccs lezárása</a>
            </li>			
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#kovetkezo">Következő kiírása</a>
            </li>	
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#ranglista">Ranglista</a>
            </li>
			<li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#eddigi">Összes tipp</a>
            </li>	
			<li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="logout.php"><font style="color:red">Kilépés</font></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

	    <section id="eredmeny">
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

			$sql = "SELECT id,hazainev,vendegnev,datum,hazaipont FROM meccs WHERE hazaipont=99 ORDER BY id DESC LIMIT 1";
			$result = $conn->query($sql);


			if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo  "  " . $row["hazainev"]. " - " . $row["vendegnev"]. " " . $row["datum"]. "<br>";
    }
} else {
    echo "Nincs meccs!";
} 

 
?> </font>
			
			</h2>
            <p class="lead">
			</p>

			
			
<script type="text/javascript">
    function validateFormm()
    {
        var a=document.forms["Form"]["h"].value;
        var b=document.forms["Form"]["v"].value;
        if (a==null || a=="",b==null || b=="")
        {
            alert("Írd be a végeredményt!");
            return false;
        }
    }
</script>
			
 <?php
 
 $sqll = "SELECT * FROM meccs ORDER BY id DESC LIMIT 1";
			$resultt = $conn->query($sqll);
			
			
	
 	
			
    if(isset($_POST['eredmeny'])){
		
	$id = $_POST['mid'];
    $hazai = $_POST['h'];
    $vendeg = $_POST['v'];
		
	$sql = "UPDATE meccs SET `hazaipont`='$hazai', `vendegpont` = '$vendeg' WHERE `id`='$id'";

if ($conn->query($sql) === TRUE) {
    		echo "<meta http-equiv='refresh' content='0'>";

} else {
    echo "Error updating record: " . $conn->error;
}
		 
	
	
	$sql2 = "SELECT hazai,hazaipont FROM meccsek ORDER BY id";
	$result2 = $conn->query($sql2);
	
		$szakasz = $_POST['sz'];

	if($szakasz==1){
		 
	$hazaitalalat = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1 WHERE g.hazai='$hazai' AND g.meccsid='$id'";	
	$vendegtalalat = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1 WHERE g.vendeg='$vendeg' AND g.meccsid='$id'";
	$golkulonbseg = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+2 WHERE ((g.hazai-g.vendeg)=('$hazai'-'$vendeg')) OR ((g.vendeg-g.hazai)=('$vendeg'-'$hazai')) AND g.meccsid='$id'";
	$hgyozelem = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1 WHERE g.hazai>g.vendeg AND '$hazai'>'$vendeg' AND g.meccsid='$id'";
	$vgyozelem = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1 WHERE g.hazai<g.vendeg AND '$hazai'<'$vendeg' AND g.meccsid='$id'";
	$dontetlen = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1 WHERE g.hazai=g.vendeg AND '$hazai'='$vendeg' AND g.meccsid='$id'";
	
	if ($conn->query($hazaitalalat) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}  
	if ($conn->query($vendegtalalat) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
} 
	if ($conn->query($golkulonbseg) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}		
if ($conn->query($hgyozelem) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}
if ($conn->query($vgyozelem) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}
if($conn->query($dontetlen) === TRUE){
    echo "Eredmény rögzítve!";
} else {
    echo "Error updating record: " . $conn->error;
}
	}else if($szakasz==2){
		 
	$hazaitalalat2 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*2 WHERE g.hazai='$hazai' AND g.meccsid='$id'";	
	$vendegtalalat2 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*2 WHERE g.vendeg='$vendeg' AND g.meccsid='$id'";
	$golkulonbseg2 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+2*2 WHERE ((g.hazai-g.vendeg)=('$hazai'-'$vendeg')) OR ((g.vendeg-g.hazai)=('$vendeg'-'$hazai')) AND g.meccsid='$id'";
	$hgyozelem2 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*2 WHERE g.hazai>g.vendeg AND '$hazai'>'$vendeg' AND g.meccsid='$id'";
	$vgyozelem2 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*2 WHERE g.hazai<g.vendeg AND '$hazai'<'$vendeg' AND g.meccsid='$id'";
	$dontetlen2 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*2 WHERE g.hazai=g.vendeg AND '$hazai'='$vendeg' AND g.meccsid='$id'";	 
	
if ($conn->query($hazaitalalat2) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}  
	if ($conn->query($vendegtalalat2) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
} 
	if ($conn->query($golkulonbseg2) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}		
if ($conn->query($hgyozelem2) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}
if ($conn->query($vgyozelem2) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}
if($conn->query($dontetlen2) === TRUE){
    echo "Eredmény rögzítve!";
} else {
    echo "Error updating record: " . $conn->error;
}
	
	}else if($szakasz==3){
	$hazaitalalat3 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*3 WHERE g.hazai='$hazai' AND g.meccsid='$id'";	
	$vendegtalalat3 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*3 WHERE g.vendeg='$vendeg' AND g.meccsid='$id'";
	$golkulonbseg3 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+2*3 WHERE ((g.hazai-g.vendeg)=('$hazai'-'$vendeg')) OR ((g.vendeg-g.hazai)=('$vendeg'-'$hazai')) AND g.meccsid='$id'";
	$hgyozelem3 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*3 WHERE g.hazai>g.vendeg AND '$hazai'>'$vendeg' AND g.meccsid='$id'";
	$vgyozelem3 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*3 WHERE g.hazai<g.vendeg AND '$hazai'<'$vendeg' AND g.meccsid='$id'";
	$dontetlen3 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*3 WHERE g.hazai=g.vendeg AND '$hazai'='$vendeg' AND g.meccsid='$id'";	
	
if ($conn->query($hazaitalalat3) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}  
	if ($conn->query($vendegtalalat3) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
} 
	if ($conn->query($golkulonbseg3) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}		
if ($conn->query($hgyozelem3) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}
if ($conn->query($vgyozelem3) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}
if($conn->query($dontetlen3) === TRUE){
    echo "Eredmény rögzítve!";
} else {
    echo "Error updating record: " . $conn->error;
}
	
	}else if($szakasz==4){
	$hazaitalalat4 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*4 WHERE g.hazai='$hazai' AND g.meccsid='$id'";	
	$vendegtalalat4 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*4 WHERE g.vendeg='$vendeg' AND g.meccsid='$id'";
	$golkulonbseg4 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+2*4 WHERE ((g.hazai-g.vendeg)=('$hazai'-'$vendeg')) OR ((g.vendeg-g.hazai)=('$vendeg'-'$hazai')) AND g.meccsid='$id'";
	$hgyozelem4 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*4 WHERE g.hazai>g.vendeg AND '$hazai'>'$vendeg' AND g.meccsid='$id'";
	$vgyozelem4 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*4 WHERE g.hazai<g.vendeg AND '$hazai'<'$vendeg' AND g.meccsid='$id'";
	$dontetlen4 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*4 WHERE g.hazai=g.vendeg AND '$hazai'='$vendeg' AND g.meccsid='$id'";	
	
	if ($conn->query($hazaitalalat4) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}  
	if ($conn->query($vendegtalalat4) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
} 
	if ($conn->query($golkulonbseg4) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}		
if ($conn->query($hgyozelem4) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}
if ($conn->query($vgyozelem4) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}
if($conn->query($dontetlen4) === TRUE){
    echo "Eredmény rögzítve!";
} else {
    echo "Error updating record: " . $conn->error;
}	
	
	}else if($szakasz==5){
	$hazaitalalat5 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*4 WHERE g.hazai='$hazai' AND g.meccsid='$id'";	
	$vendegtalalat5 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*4 WHERE g.vendeg='$vendeg' AND g.meccsid='$id'";
	$golkulonbseg5 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+2*4 WHERE ((g.hazai-g.vendeg)=('$hazai'-'$vendeg')) OR ((g.vendeg-g.hazai)=('$vendeg'-'$hazai')) AND g.meccsid='$id'";
	$hgyozelem5 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*4 WHERE g.hazai>g.vendeg AND '$hazai'>'$vendeg' AND g.meccsid='$id'";
	$vgyozelem5 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*4 WHERE g.hazai<g.vendeg AND '$hazai'<'$vendeg' AND g.meccsid='$id'";
	$dontetlen5 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*4 WHERE g.hazai=g.vendeg AND '$hazai'='$vendeg' AND g.meccsid='$id'";	
	
if ($conn->query($hazaitalalat5) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}  
	if ($conn->query($vendegtalalat5) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
} 
	if ($conn->query($golkulonbseg5) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}		
if ($conn->query($hgyozelem5) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}
if ($conn->query($vgyozelem5) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}
if($conn->query($dontetlen5) === TRUE){
    echo "Eredmény rögzítve!";
} else {
    echo "Error updating record: " . $conn->error;
}
	
	}else if($szakasz==6){
	$hazaitalalat6 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*5 WHERE g.hazai='$hazai' AND g.meccsid='$id'";	
	$vendegtalalat6 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*5 WHERE g.vendeg='$vendeg' AND g.meccsid='$id'";
	$golkulonbseg6 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+2*5 WHERE ((g.hazai-g.vendeg)=('$hazai'-'$vendeg')) OR ((g.vendeg-g.hazai)=('$vendeg'-'$hazai')) AND g.meccsid='$id'";
	$hgyozelem6 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*5 WHERE g.hazai>g.vendeg AND '$hazai'>'$vendeg' AND g.meccsid='$id'";
	$vgyozelem6 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*5 WHERE g.hazai<g.vendeg AND '$hazai'<'$vendeg' AND g.meccsid='$id'";
	$dontetlen6 = "UPDATE ranglista AS b INNER JOIN tippek AS g ON b.felhnev=g.username SET pont=pont+1*5 WHERE g.hazai=g.vendeg AND '$hazai'='$vendeg' AND g.meccsid='$id'";	
	
	if ($conn->query($hazaitalalat6) === TRUE) { 
} else {
    echo "Error updating record: " . $conn->error;
} 		 
	if ($conn->query($vendegtalalat6) === TRUE) {
   
} else {
    echo "Error updating record: " . $conn->error;
} 	
	if ($conn->query($golkulonbseg6) === TRUE) {   
} else {
    echo "Error updating record: " . $conn->error;
}		
if ($conn->query($hgyozelem6) === TRUE) {
   
} else {
    echo "Error updating record: " . $conn->error;
}
if ($conn->query($vgyozelem6) === TRUE) {   
} else {
    echo "Error updating record: " . $conn->error;
}
if($conn->query($dontetlen6) === TRUE){
    echo "Eredmény rögzítve!";
} else {
    echo "Error updating record: " . $conn->error;
}
	}
		 
    }
	
	
        ?>
    
		   <form class="form-inline" action="" name="Form" method="post" onsubmit="return validateFormm()">
		   <div class="form-group">
    <input type="hidden" class="form-control" id="mid" name="mid" value="<?php while($row = $resultt->fetch_assoc()) {
        echo  "  " . $row["id"]. "";
     ?>">
  </div>
  
  <div class="form-group">
    <input type="hidden" class="form-control" id="c" name="sz" value="<?php 
        echo  "  " . $row["szakasz"]. "";
	}?>">
  </div>
  <div class="form-group">
    <input type="text" class="form-control" id="a" name="h">
  </div>
  <b>:</b>
  <div class="form-group">
    <input type="text" class="form-control" id="b" name="v">
  </div>
   
  
  
  <button type="submit" name="eredmeny" class="btn btn-dark">Eredmeny beirasa</button>

  
</form>
	
	
		   
		   
          </div>
        </div>
      </div>
    </section>
	
	
	
	
<section id="lezaras">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
			
            <h2>Jelenlegi meccs lezárása:</h2> <?php $sql = "SELECT id,hazainev,vendegnev,lezart,datum FROM meccs ORDER BY id DESC LIMIT 1";
			$result = $conn->query($sql);


			if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo  "  " . $row["hazainev"]. " - " . $row["vendegnev"]. " <br>";
		if(($row["lezart"])==1){ echo "Lezárva!";}else{echo "Nincs lezárva!";};
    }
} else {
    echo "Nincs meccs!";
} 	?><font style="color: blue"> <?php 
			// Create connection
$conn = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


		

 
?> </font>
			
			
            <p class="lead">
			</p>

			
			

			
 <?php
 
 $sqll = "SELECT * FROM meccs ORDER BY id DESC LIMIT 1";
			$resultt = $conn->query($sqll);
			
			
	

	    if(isset($_POST['lezar'])){
		
	
	$id = $_POST['mid'];
	$sql22 = "UPDATE meccs SET `lezart`='1' WHERE `id`='$id'";

if ($conn->query($sql22) === TRUE) {
		
    		echo "<meta http-equiv='refresh' content='0'>";

} else {
    echo "Error updating record: " . $conn->error;
}
		 
	
	
	$sql2 = "SELECT hazai FROM meccsek ORDER BY id";
	$result2 = $conn->query($sql2);
	
		}
	
	

	
	
	
	
        ?>
    
		   <form class="form-inline" action="" name="Form" method="post" >
		   <div class="form-group">
    <input type="hidden" class="form-control" id="mid" name="mid" value="<?php while($row = $resultt->fetch_assoc()) {
        echo  "  " . $row["id"]. "";
    } ?>">
  </div>
  

  <button type="submit" name="lezar" class="btn btn-dark">Fogadhatóság lezárása</button>

  
</form>
	
		   
		   
		   
          </div>
        </div>
      </div>
    </section>	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	   <section id="kovetkezo">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
			
            <h2>Következő meccs kiírása: <br> <font style="color: blue"> <?php 
			// Create connection
$conn = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?> </font>
			
			</h2>
            <p class="lead">
			</p>

			
			
<script type="text/javascript">
    function validateForm()
    {
        var a=document.forms["Formm"]["hazainevv"].value;
        var b=document.forms["Formm"]["vendegnevv"].value;
		var c=document.forms["Formm"]["datumm"].value;
        if (a==null || a=="",b==null || b=="",c==null || c=="")
        {
            alert("Írd be a meccset!");
            return false;
        }
    }
</script>
			
 <?php
 
			
    if(isset($_POST['tipp'])){
		
		$meccsdatum = strtotime($_POST ["datumm"]);
		
        $sql = "INSERT INTO meccs (hazainev, vendegnev, hazaipont, vendegpont, szakasz, datum, datumszam)
        VALUES ('".$_POST["hazainevv"]."','".$_POST["vendegnevv"]."', 99, 99,'".$_POST["szakaszertek"]."','".$_POST["datumm"]."', $meccsdatum)";
		
	
		 $result = mysqli_query($conn,$sql);
		 

		echo "<meta http-equiv='refresh' content='0'>";
		
		 
    }
	$count = mysqli_num_rows($resultt);
	
        ?>
   
  <form class="form" action="" name="Formm" method="post" onsubmit="return validateForm()">
  
  Hazai: 
  <div class="form-group">
    <input type="text"  size="4" class="form-control" id="a" name="hazainevv">
  </div>
  Vendég: 
  
  <div class="form-group">
    <input type="text" size="4" class="form-control" id="b" name="vendegnevv">
  </div>
  Szakasz:
  <div class="form-group">
  <select name="szakaszertek">
  <option value="1">Csoportkör</option>
  <option value="2">Nyolcaddöntő</option>
  <option value="3">Negyeddöntő</option>
  <option value="4">Elődöntő</option>
  <option value="5">Bronzmérkőzés</option>
  <option value="6">Döntő</option>
  </select>
  </div>
  
  Dátum (Formátum: év-hónap-nap óra:perc):
  
  <div class="form-group">
    <input type="text"  size="4" class="form-control" id="c" name="datumm" id="datumm">
  </div>
	
 
  <button type="submit" name="tipp" class="btn btn-dark">Meccs kiírása</button>
  
  
</form>
		 
		   
 
		   
          </div>
        </div>
      </div>
    </section>
	
	
	
	<section id="vegsogyoztes">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
			
            <h2>Végső győztes beírása<br> 
			
			</h2>
            <p class="lead">
			</p>

	
			
 <?php
 
 $sqll = "SELECT * FROM felhasznalok;";
			$resultt = $conn->query($sqll);
			
			
	
 	
			
    if(isset($_POST['vegsotipp'])){
		
			
    $csapat = $_POST['csapat'];
		
	$vegsogyoztespont = "UPDATE ranglista AS b INNER JOIN felhasznalok AS g ON b.felhnev=g.username SET pont=pont+25 WHERE g.vegsogyoztes='$csapat'";

	if ($conn->query($vegsogyoztespont) === TRUE) {  echo "<meta http-equiv='refresh' content='0'>";

} else {
    echo "Error updating record: " . $conn->error;
}  
	
	}
	
	

        ?>
   
		   <form class="form-inline" action="" name="Formvegso" method="post"  onsubmit="return confirm('Biztos vagy benne?');">
		
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
  <button type="submit" name="vegsotipp" class="btn btn-dark">Beírás!</button>
  
  
</form>
  
          </div>
        </div>
      </div>
    </section>	
	

 

    <section id="ranglista">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h2>Ranglista</h2>
            <p class="lead">
			
			
			<?php 
				
			
			
			// Create connection
$conn = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

			$sql = "SELECT felhrendes, pont FROM ranglista ORDER BY pont DESC";
			$result = $conn->query($sql);


			if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo  " <table width='100%'><tr><td width='40%'><b> " . $row["felhrendes"]. " </b></td><td> Pont: " . $row["pont"]. " </td></tr></table>";
    }
} 


?>
			</p>
          </div>
        </div>
      </div>
    </section>

	
	<section id="eddigi" class="bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h2>Összes eddigi tipp</h2>
            
			
			
			
			<?php 
			
	

			
			                  
			// Create connection
$conn = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

			$sql = "SELECT felhasznalok.rendesnev, meccs.id,meccs.hazainev,meccs.vendegnev, tippek.hazai, tippek.vendeg, tippek.datum, tippek.userid 
			FROM meccs INNER JOIN tippek ON meccs.id=tippek.meccsid INNER JOIN felhasznalok ON felhasznalok.id = tippek.userid ORDER BY tippek.datum DESC";
			$result = $conn->query($sql);
			
			
			

			if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo  " <b> " . $row["rendesnev"]. " | </b>" . $row["hazainev"]. " - " . $row["vendegnev"]. " <b>" . $row["hazai"]. " : " . $row["vendeg"]. "</b> - " . $row["datum"]. "<br>";
    }
} else {
    echo "Még nincs tipp rögzítve!";
} 


?>
			
			
			
			
			
			
			
			</p>
          </div>
        </div>
      </div>
    </section>
	
	
    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">VB 2018 - <a href="fogadas.php">Fogadás</a></p>
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
