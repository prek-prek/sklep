<?php
    require_once 'config.php';
    $connection_data = connection_data("m32187_prek");
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
    <div class="shop mt-4 d-flex justify-content-start flex-column align-items-center" style="min-height: 60vh;">
      <div class="col-3 mt-4">
          <h2 style="text-align: center;">Witaj, <?php
          $id = $_SESSION["id"];
          $name = $connection->query("SELECT login FROM users WHERE user_id=".$id)->fetch_row();
          echo $name[0];
           ?>!</h2>
      </div>
      <div class="col-9 mt-5">
        <h3 style="margin-bottom: 35px;">Wszystkie zamówienia: </h3>
        <?php
        $query="SELECT products.productname, products.product_id, products.capacity, products.image_url, products.price, orders.quantity FROM products INNER JOIN orders ON products.product_id = orders.product_id";
        $sql = $connection->query($query);
        if($result = $connection->query($query)){
          while ($row = $sql->fetch_assoc()) {
            echo '<div class="row col-12 d-flex justify-content-between align-items-center mt-4">';
            echo   '<img class="col-2" src="'.$row['image_url'] .'" style="width: 10%; height: 10%;">';
            echo   '<div class="col-5"><p class="mb-0"><b>Produkt:<br></b> <a href="single_product.php?id='.$row['product_id'].'"><b>'.$row['productname'] .'</b></a></p><small class="text-muted">'.$row['capacity'] .'</small></div>';
            echo   '<div class="col-1"><p class="mb-0 fs-5"><b class="fs-6">Ilośc:<br></b> x '.$row['quantity'].'</p></div>';
            echo   '<div class="col-1"><p class="mb-0 fs-5"><b class="fs-6">Suma:<br></b> '.floatval($row['price'])*floatval($row['quantity']).'zł</p></div>';
            echo   '<div class="col-2"><p class="mb-0 fs-5"><a href="#">Edytuj zamówienie</a></p></div>';
            echo  '</div>';
          }
        }else{
          echo "<p>Brak zamówień</p>";
        }
      ?>
      <h3 style="margin-bottom: 35px; margin-top: 100px;">Wszyscy uzytkownicy: </h3>
      <?php
      $query="SELECT * FROM users";
      $sql = $connection->query($query);
      if($result = $connection->query($query)){
        while ($row = $sql->fetch_assoc()) {
          echo '<div class="row text-center col-12 d-flex justify-content-between align-items-center mt-5">';
          echo   '<div class="col-2 d-flex justify-content-center"><img src="https://www.glamour.pl/media/cache/gallery_small/uploads/media/default/0005/72/fda9c7c32c7ed88d9a70538a42808c734df98cae.jpg" style="width: 50%; height: 50%;"><p class="mb-0">Id: '.$row['user_id'].'</p></div>';
          echo   '<div class="col-2 text-start"><p class="mb-0 fs-5"><b  class="fs-6">Login:<br></b> '.$row['login'].'</p></div>';
          echo   '<div class="col-2 text-start"><p class="mb-0 fs-5"><b  class="fs-6">Hasło:<br></b>  '.$row['haslo'].'</p></div>';
          echo   '<div class="col-3 text-start"><p class="mb-0 fs-5"><b  class="fs-6">Email:<br></b>  '.$row['email'].'</p></div>';
          echo   '<div class="col-1"><p class="mb-0 fs-5"><b  class="fs-6">Admin:<br></b>  '.$row['is_admin'].'</p></div>';
          echo   '<div class="col-2 text-end"><p class="mb-0 fs-5"><a href="#">Edytuj uzytkownika</a></p></div>';
          echo  '</div>';
        }
      }?>
      <h3 style="margin-bottom: 35px; margin-top: 100px;">Wszystkie produkty: </h3>
      <?php
      $query="SELECT products.product_id, products.brand, products.image_url, products.productname, products.stock, products.price, category.category_name FROM products,category WHERE products.category_id = category.category_id";
      $sql = $connection->query($query);
      if($result = $connection->query($query)){
        while ($row = $sql->fetch_assoc()) {
          echo '<div class="row text-center col-12 d-flex justify-content-between align-items-center mt-5">';
          echo   '<div class="col-2 d-flex justify-content-center"><img class="col-2" src="'.$row['image_url'] .'" style="width: 50%; height: 50%;"><p class="mb-0" style="text-decoration: underline;">Id: '.$row['product_id'].'</p></div>';
          echo   '<div class="col-1 text-start"><p class="mb-0 fs-5"><b class="fs-6">Marka:<br></b> '.$row['brand'].'</p></div>';
          echo   '<div class="col-4 text-start"><p class="mb-0 fs-5"><b class="fs-6">Nazwa:<br></b> '.$row['productname'].'</p></div>';
          echo   '<div class="col-1 text-start"><p class="mb-0 fs-5"><b class="fs-6">Stan:<br></b> '.$row['stock'].'</p></div>';
          echo   '<div class="col-1 text-start"><p class="mb-0 fs-5"><b class="fs-6">Cena:<br></b> '.$row['price'].'zł</p></div>';
          echo   '<div class="col-1 text-start"><p class="mb-0 fs-5"><b class="fs-6">Kategoria:<br></b> '.$row['category_name'].'</p></div>';
          echo   '<div class="col-2 text-end"><p class="mb-0 fs-5"><a href="#">Edytuj produkt</a></p></div>';
          echo  '</div>';
        }
      }
    ?>
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
