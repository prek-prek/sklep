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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" href="style.css">
    <title>Projekt</title>
</head>
<body>
  <div class="container-fluid">
    <div class="header d-flex justify-content-between row align-items-center">
      <div class="logo col-6">
        <img src="logo.png" style="width: 350px; height: 150px; float: left;">
      </div>
      <div class="buttons col-6 d-flex justify-content-end align-items-center">
        <?php
          session_start();
          if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
              echo '<a class="btn btn-danger logowanie" href="login.php">Zaloguj się</a>';
          }else{
              echo '<div class="UserIcon d-flex text-center flex-column me-5 fs-5"><img src="user.png" style="margin-left: auto; margin-right: auto; margin-bottom: 5px; width: 40px; height: 40px;"/>'.$_SESSION["username"].'</div>';
              echo '<a class="btn btn-danger logowanie" href="logout.php">Panel klienta</a>';
              echo '<a class="btn btn-danger logowanie" href="logout.php">Wyloguj się</a>';
          }
        ?>
      </div>
    </div>
    <div class="row">
      <p class="text-center bg-danger fs-6 text-white" style="padding-top: 5px; padding-bottom: 5px;">Najwiekszy wybór energoli pod słońcem!! Cerwony pierun, corny sex i łoscypki z koziej ino dupy!</p>
    </div>
    <div class="row mx-auto shop">
      <div class="col-3 bg-light kategorie">
        Kategorie
      </div>
      <div class="col-9 products">
        <div class="row">
          <?php
            $sql = $connection->query("SELECT * FROM products");
            while($row = $sql->fetch_assoc()){
              echo '<div class="card col-3">';
              echo  '<img src="'.$row['image_url'].'" style="padding-bottom: 20px; padding-top: 20px;"/>';
              echo  '<div class="data">';
              echo    '<h6 class="text-secondary">'.$row['brand'].'</h1>';
              echo    '<h5>'.$row['productname'].'</h2>';
              echo    '<h6>'.$row['price'].'zł</h3>';
              echo    '<div class="addToCart btn-danger"><a href="#" style="text-decoration: none; color: white;"><img src="koszyk.png" style="margin-right: 10px; width: 15px; height=15px;"/>Dodaj do koszyka</a></div>';
              echo  '</div>';
              echo '</div>';
            }
          ?>
        </div>
      </div>
    </div>
    <div class="footer row">
      <div class="col-12 bg-light">
      </div>
    </div>
  </div>
</body>
</html>
