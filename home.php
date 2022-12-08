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
    <div class="row mx-auto shop">
      <div class="col-3 bg-light kategorie">
        <form method="post">
          <b><p class="mt-3 fs-5">Kategorie</p></b>
            <?php
                $filtry = $connection->query("SELECT DISTINCT category.category_name, products.category_id FROM products INNER JOIN category ON products.category_id = category.category_id");
                while($row = $filtry->fetch_assoc()){
                    echo '<div class="form-check">';
                    echo '<input type="checkbox" class="form-check-input" value="' . $row['category_id'] . '" name="kategoria[]">'.$row['category_name'];
                    echo '</div>';
                }
            ?>
          <b><p class="mt-3 fs-5">Marka</p></b>
            <?php
                $filtry = $connection->query("SELECT DISTINCT brand FROM products");
                while($row = $filtry->fetch_assoc()){
                    echo '<div class="form-check">';
                    echo '<input type="checkbox" class="form-check-input" value="' . $row['brand'] . '" name="marka[]">'.$row['brand'];
                    echo '</div>';
                }
            ?>
          <b><p class="mt-3 fs-5">Pojemność</p></b>
            <?php
                $filtry = $connection->query("SELECT DISTINCT capacity FROM products");
                while($row = $filtry->fetch_assoc()){
                    echo '<div class="form-check">';
                    echo '<input type="checkbox" class="form-check-input" value="' . $row['capacity'] . '" name="pojemnosc[]">'.$row['capacity'];
                    echo '</div>';
                }
            ?>
          <div class="form-group mt-4">
            <label for="formControlRange">Cena</label>
            <input type="range"
              class="form-control-range"
              id="formControlRange"
              onChange="document.getElementById('rangeval').innerText = document.getElementById('formControlRange').value">
            <span id="rangeval">0</span>
          </div>
          <?php
          extract($_POST);
          if(isset($kategoria) || isset($marka) || isset($pojemnosc)){
              echo '<input type="submit" name="submit" class="btn btn-warning mt-4" value="Usuń filtry" class="mt-3"/>';
          }else{
            echo '<input type="submit" name="submit" class="btn btn-danger mt-4" value="Filtruj" class="mt-3"/>';
          }
          ?>
        </form>
      </div>
      <div class="col-9 products">
        <div class="row">
          <?php
          $query="SELECT * FROM products WHERE price > 0";
           extract($_POST);
           if(isset($kategoria)){
               $query.=" AND category_id IN (".implode(',', $kategoria).")";
           }
           if(isset($marka)){
               $query.=" AND brand IN ('".implode("','", $marka)."')";
           }
           if(isset($pojemnosc)){
               $query.=" AND capacity IN ('".implode("','", $pojemnosc)."')";
           }
            $sql = $connection->query($query);
            while($row = $sql->fetch_assoc()){
              echo '<div class="card col-3">';
              echo  '<a href="single_product.php?id='.$row['product_id'].'" style="text-decoration: none" class="row col-12"><img src="'.$row['image_url'].'" style="padding-bottom: 20px; padding-top: 20px;"/>';
              echo  '<div class="data">';
              echo    '<h6 class="d-flex text-secondary">'.$row['brand'].'</h6>';
              echo    '<div class="d-flex" style="color: black !important;"><h5>'.$row['productname'].'<h6 class="text-secondary" style="margin-left: 5px;">'.$row['capacity'].'</h6></h5></div>';
              echo    '<h6 style="color: black !important;">'.$row['price'].'zł</h6>';
              echo    '<div class="addToCart mt-3 btn-danger"><a href="cart_update.php?id='.$row['product_id'].'" style="text-decoration: none; color: white;"><img src="koszyk.png" style="margin-right: 10px; width: 15px; height=15px;"/>Dodaj do koszyka</a></div>';
              echo  '</div>';
              echo '</div></a>';
            }
          ?>
        </div>
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
