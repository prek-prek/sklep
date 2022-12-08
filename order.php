<?php
    require_once 'config.php';
    $connection_data = connection_data("root");
    $connection = @new mysqli($connection_data[0], $connection_data[1], $connection_data[2], $connection_data[3]);
    if($connection->connect_errno!=0){
        echo "Błąd! " . $connection->connect_errno;
    }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projekt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" href="style.css">

</head>
<body>
  <div class="container-fluid">
    <div class="header d-flex justify-content-between row align-items-center">
      <div class="logo col-6">
        <a href="home.php"><img src="logo.png" style="width: 300px; height: 150px; padding-top: 20px; padding-bottom: 20px; float: left;">
        </a>
      </div>
      <div class="buttons col-6 d-flex justify-content-end align-items-center">
        <?php
          session_start();
          if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
              header("location: login.php");
              echo '<a class="btn btn-danger logowanie" href="login.php">Zaloguj się</a>';
          }else{
            if($_SESSION["is_admin"]==1){
              echo '<a class="btn btn-danger logowanie" href="admin_panel.php">Panel klienta</a>';
              echo '<a class="btn btn-danger logowanie" href="logout.php">Wyloguj się</a>';
              echo '<div class="UserIcon d-flex text-center flex-column me-5 fs-5" style="color:red;"><img src="user.png" style="margin-left: auto; margin-right: auto; margin-bottom: 5px; width: 30px; height: 30px;"/>'.$_SESSION["username"].'</div>';
            }else{
              echo '<a class="btn btn-danger logowanie" href="user_panel.php">Panel klienta</a>';
              echo '<a class="btn btn-danger logowanie" href="logout.php">Wyloguj się</a>';
              echo '<div class="UserIcon d-flex text-center flex-column me-5 fs-5"><img src="user.png" style="margin-left: auto; margin-right: auto; margin-bottom: 5px; width: 30px; height: 30px;"/>'.$_SESSION["username"].'</div>';
            }
          }
        ?>
        <a href="view_cart.php" style="text-decoration: none; color: black;">
          <div class="d-flex text-center flex-column me-5 fs-5">
            <img src="cart.png" style="margin-left: auto; margin-right: auto; margin-top: 5px; width: 30px; height: 30px;"/>Koszyk (
            <?php
            if(!isset($_SESSION)) {
              session_start();
            }
            if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
              echo '0 ';
            }else{
              if(isset($_SESSION['cart'])){
                echo count($_SESSION['cart']).' ';
              }else{
                echo '0 ';
              }
            };?>)
          </div>
      </a>
      </div>
    </div>
    <div class="row">
      <p class="text-center bg-danger fs-6 text-white" style="padding-top: 7px; padding-bottom: 7px;">Najwiekszy wybór energoli pod słońcem!!</p>
    </div>
    <div class="shop mt-4 d-flex justify-content-center align-items-center">
      <div class="col-3 mt-4" style="height: 50vh;">
          <h2 style="text-align: center;">Dziękujemy za złożenie zamówienia!</h2>
      </div>
    </div>
    <div class="footer row">
      <div class="col-12 d-flex justify-content-between align-items-center bg-light">
        <div class="col-4">
          <a href="home.php"><img src="logo.png" style="width: 300px; height: 150px; padding-top: 20px; padding-bottom: 20px; float: left;"></a>
        </div>
        <div class="col-6">
          <p class="fs-5 me-3" style="color: black; text-align: right;">Sportowe emocje napędza <b><i>Pikawa.pl!</b></i> Pamiętaj - serce nie sługa </p>
        </div>
      </div>
    </div>
</body>
</html>
