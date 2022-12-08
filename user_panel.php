<?php
    require_once 'config.php';
    $connection_data = connection_data("m32187_root");
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
        <h3 style="margin-bottom: 35px;">Twoje zamówienia: </h3>
        <?php
        $query="SELECT products.productname, products.product_id, products.capacity, products.image_url, products.price, orders.quantity FROM products INNER JOIN orders ON products.product_id = orders.product_id WHERE orders.user_id = ".$id;
        $sql = $connection->query($query);
        if($result = $connection->query($query)){
          while ($row = $sql->fetch_assoc()) {
            echo '<div class="row col-12 d-flex justify-content-between align-items-center mt-4">';
            echo   '<img class="col-2" src="'.$row['image_url'] .'" style="width: 10%; height: 10%;">';
            echo   '<div class="col-5"><p class="mb-0"><a href="single_product.php?id='.$row['product_id'].'"><b>'.$row['productname'] .'</b></a></p><small class="text-muted">'.$row['capacity'] .'</small></div>';
            echo   '<div class="col-1"><p class="mb-0 fs-5">x '.$row['quantity'].'</p></div>';
            echo   '<div class="col-1"><p class="mb-0 fs-5">'.floatval($row['price'])*floatval($row['quantity']).'zł</p></div>';
            echo   '<div class="col-2"><p class="mb-0 fs-5"><a download="'.substr($row['image_url'],7).'" href="'.$row['image_url'].'">>Pobierz obraz<</a></p></div>';
            echo  '</div>';
          }
        }else{
          echo "<p>Brak zamówień</p>";
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
