
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
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Szabályok</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#nyeremeny">Beugró/Nyeremény</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#pontozas">Pontozás</a>
            </li>
			<li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="logout.php"><font style="color:red">Kilépés</font></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>


    <section id="nyeremeny">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
			
            <h2>Beugró/Nyeremény eloszlás<br>
			
			</h2>
            <p class="lead">
			</p>
			<b>Beugró:</b>
			<ul>
			<li>1000 FT</li>
			</ul>
			<b>Nyeremény eloszlás</b> (a beugrók összegétől függően):
			<ul>
			<li>1. hely: A beugrók összegének 50%-a</li>
			<li>2. hely: A beugrók összegének 30%-a</li>
			<li>3. hely: A beugrók összegének 20%-a</li>
			</ul>
			
			<h2 id="pontozas">Pontozás<br>
			
			</h2>
            <p class="lead">
			</p>
			<b>Meccsek pontozása:</b> 
			<ul>
			
			<li>ha a játékos eltalálta az eredményt (ki győzött, ill. döntetlen), 1 pontot kap</li>
			<li>ha eltalálta az egyik csapat góljainak számát, azért 1 pontot kap</li>
			<li>ha eltalálta a másik csapat góljainak számát, azért is 1 pontot kap</li>
			<li>ha eltalálta a gólkülönbséget, 2 pont jár</li>
			</ul>
			<b>Pontok szorzói (a VB szakaszától függően változnak):</b>
			<ul>
			<li>Csoportkör:  1x</li>
			<li>Nyolcaddöntő: 2x</li>
			<li>Negyeddöntő: 3x</li>
			<li>Elődöntő: 4x</li>
			<li>Bronzmérkőzés: 4x</li>
			<li>Döntő: 5x</li>
			</ul>
			<b>Végső győztes pontozása:</b>
			<ul>
			<li>Ha sikerült eltalálni a végső győztest, 25 pont</li>
			</ul>
			<b>Ranglista:</b><br>
			A pontok alapján ha döntetlen alakul ki a végén:
			<ul>
			<li>1. Telitalálatos tippek száma dönt</li>
			<li>2. Eltalált végkimenetelű meccsek száma dönt</li> 
			</ul>
		   
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
