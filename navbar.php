<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AHP Kelompok 5</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Montserrat:wght@500&family=PT+Sans&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style1.css" type="text/css">
</head>
<?php 
  session_start();
	$role = isset($_SESSION['role']) ? $_SESSION['role'] : "user";
  $isLogin = isset($_SESSION['isLogin']) ?  $_SESSION['isLogin'] : false;
  $uri = $_SERVER['PHP_SELF'];

  // redirect kondisi login
  if($isLogin){
    $listBlockInLogin = array(
      'navbar.php',
      'login.php',
      'register.php',
    );
    
    foreach ($listBlockInLogin as $value) {
      if (strpos($uri, $value) !== false) {
          header('Location: index.php');
          break;
      }
    }
  }else{
    $listBlockNotLogin = array(
      'navbar.php',
      'index.php',
    );

    foreach ($listBlockNotLogin as $value) {
      if (strpos($uri, $value) !== false) {
          header('Location: login.php');
          break;
      }
    }
  }

  if(isset($_POST['logout'])){
    session_destroy();
    header('Location: login.php');
  }
?>
<body>
  <?php if ($isLogin): ?>
  <nav>
    <div class="title">Kelompok 5</div>
      <ul class="menu">
        <li><a href="index.php">Home</a><i class="bi bi-chevron-right panah"></i></li>
        <li><a href="kriteria.php">Kriteria</a><i class="bi bi-chevron-right panah"></i></li>
        <li><a href="alternatif.php">Alternatif</a><i class="bi bi-chevron-right panah"></i></li>
        <li><a href="bobot_kriteria.php">Perbandingan Kriteria</a><i class="bi bi-chevron-right panah"></i></li>
        <li onClick="drpdn()"><a href="#">Perbandingan Alternatif</a><i class="bi bi-chevron-right panah"></i>
          <ul class="custom-dd" id="custom">
            <?php
              if (getJumlahKriteria() > 0) {
                for ($i=0; $i <= (getJumlahKriteria()-1); $i++) { 
                  echo "<a class='item' href='bobot.php?c=".($i+1)."'><li>".getKriteriaNama($i)."<hr></li></a>";
                }
              }
            ?>
          </ul>
        </li>
        <li><a href="hasil.php">Ranking</a></li>
      </ul>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input class="mt-2 btn btn-warning" type="submit" name="logout" value="Logout">
      </form>
    </nav>
    <?php endif; ?>
  <script>
      function drpdn(){
        document.getElementById("custom").classList.toggle('custom-dd-show');
      }
    </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>