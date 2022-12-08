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
            }; ?> )
          </div>
      </a>
      </div>
    </div>
    <div class="row">
      <p class="text-center bg-danger fs-6 text-white" style="padding-top: 7px; padding-bottom: 7px;">Najwiekszy wybór energoli pod słońcem!!</p>
    </div>
    <div class=" container-fluid my-5 ">
        <div class="row justify-content-center ">
            <div class="col-xl-10">
                    <div class="row justify-content-around">
                        <div class="col-md-5">
                            <div class="card border-0">
                                <div class="card-header pb-0">
                                    <h2 class="card-title space ">Zamówienie</h2>
                                    <p class="card-text text-muted mt-4  space">Dane dotyczące dostawy:</p>
                                    <hr class="my-0">
                                </div>
                                <div class="card-body">
                                    <div class="row mt-4">
                                        <div class="col"><p class="text-muted mb-2">Twój adres do wysyłki:</p><hr class="mt-0"></div>
                                    </div>
                                    <form name="details" action="" method="post"><div class="row no-gutters">
                                        <div class="col-sm-6 pr-sm-2">
                                            <div class="form-group">
                                                <label for="NAME" class="small text-muted mb-1">Imie</label>
                                                <input type="text" class="form-control form-control-sm" name="imie" id="imie">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="NAME" class="small text-muted mb-1">Nazwisko</label>
                                                <input type="text" class="form-control form-control-sm" name="nazwisko" id="nazwisko">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="NAME" class="small text-muted mb-1">Numer Telefonu</label>
                                        <input type="text" class="form-control form-control-sm" name="numer_telefonu" id="numer_telefonu">
                                    </div>
                                    <div class="form-group">
                                        <label for="NAME" class="small text-muted mb-1">Ulica i nr Domu</label>
                                        <input type="text" class="form-control form-control-sm" name="ulica" id="ulica">
                                    </div>
                                    <div class="row no-gutters">
                                        <div class="col-sm-6 pr-sm-2">
                                            <div class="form-group">
                                                <label for="NAME" class="small text-muted mb-1">Miasto</label>
                                                <input type="text" class="form-control form-control-sm" name="miasto" id="miasto">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="NAME" class="small text-muted mb-1">Kod pocztowy</label>
                                                <input type="text" class="form-control form-control-sm" name="kod_pocztowy" id="kod_pocztowy">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card border-0 ">
                                <div class="card-header card-2">
                                    <p class="card-text mt-4 fs-5">Twoje zamówienie: </p><p style="margin-top: -40px; font-style: italic;"><br>Zmień ilośc na 0 aby usunąć produkt z koszyka</p>
                                    <hr class="my-2">
                                </div>
                                <div class="mt-2 card-body pt-0">
                                  <?php
                                  require_once 'config.php';
                                  $connection_data = connection_data("m32187_root");
                                  $connection = @new mysqli($connection_data[0], $connection_data[1], $connection_data[2], $connection_data[3]);
                                  if($connection->connect_errno!=0){
                                      echo "Błąd! " . $connection->connect_errno;
                                  }
                                  if(!isset($_SESSION)) {
                                    session_start();
                                  }
                                  if(isset($_POST['submit'])){
                                      foreach($_POST['quantity'] as $key => $val) {
                                          if($val==0) {
                                              unset($_SESSION['cart'][$key]);
                                          }else{
                                              $_SESSION['cart'][$key]['quantity']=$val;
                                          }
                                      }

                                  }
                                  if(isset($_POST['order'])){
                                      $arrProductIds=array();
                                      foreach ($_SESSION['cart'] as $id => $value) {
                                        $arrProductIds[] = $id;
                                      }
                                      $strIds=implode(",", $arrProductIds);
                                      $query="SELECT * FROM products WHERE product_id IN (".$strIds.")";
                                      $orderQuery = "INSERT INTO orders (order_id, user_id, product_id, quantity) VALUES ";
                                      $lastOrderID = $connection->query("SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1")->fetch_row();
                                      $sql = $connection->query($query);
                                      $customer_id = $_SESSION["id"];
                                      $lastOrderID[0] = $lastOrderID[0] + 1;
                                      $addCustomer = "INSERT INTO customers (user_id,imie,nazwisko,numer_telefonu,ulica_dom,miasto,kod_pocztowy,order_id)
                                      VALUES (".$_SESSION["id"].",'".$_POST['imie']."','".$_POST['nazwisko']."','".$_POST['numer_telefonu']."','".$_POST['ulica']."','".$_POST['miasto']."','".$_POST['kod_pocztowy']."',".$lastOrderID[0].");";
                                      $connection->query($addCustomer);
                                      if($result = $connection->query($query)){
                                        while ($row = $sql->fetch_assoc()) {
                                          $orderQuery2 = $orderQuery.'('.$lastOrderID[0].','.$customer_id.','.$row['product_id'].','.$_SESSION['cart'][$row['product_id']]['quantity'].');';
                                          $connection->multi_query($orderQuery2);
                                        }
                                      }
                                      unset($_SESSION['cart']);
                                      ?>
                                      <script type="text/javascript">
                                      window.location.href = 'order.php';
                                      </script>
                                      <?php
                                  }

                                  if(isset($_SESSION['cart'])){
                                    $arrProductIds=array();
                                    foreach ($_SESSION['cart'] as $id => $value) {
                                      $arrProductIds[] = $id;
                                    }
                                    $customer_id = $_SESSION["id"];
                                    $strIds=implode(",", $arrProductIds);
                                    $query="SELECT * FROM products WHERE product_id IN (".$strIds.")";
                                    $sql = $connection->query($query);
                                    $subtotal = 0;
                                    if($result = $connection->query($query)){
                                      while ($row = $sql->fetch_assoc()) {
                                        $subtotal = $subtotal + $row['price'];
                                        echo '<div class="row  justify-content-between mt-3">';
                                        echo    '<div class="col-auto col-md-7">';
                                        echo        '<div class="media flex-column flex-sm-row">';
                                        echo            '<img class=" img-fluid" src="'.$row['image_url'] .'" width="62" height="62">';
                                        echo            '<div class="media-body  my-auto">';
                                        echo                '<div class="row">';
                                        echo                    '<div class="col-auto"><p class="mb-0"><b>'.$row['productname'] .'</b></p><small class="text-muted">'.$row['capacity'] .'</small></div>';
                                        echo                '</div>';
                                        echo            '</div>';
                                        echo        '</div>';
                                        echo    '</div>';
                                        echo    '<div class=" pl-0 flex-sm-col col-auto  my-auto"><input type="text" style="width: 50px;" name="quantity['.$row['product_id'] .']" value="'.$_SESSION['cart'][$row['product_id']]['quantity'].'" /></div>';
                                        echo    '<div class=" pl-0 flex-sm-col col-auto  my-auto "><p><b>'.$row['price'].'zł</b></p></div>';
                                        echo  '</div>';
                                      }
                                      echo  '<hr class="my-2 mt-3">';
                                      echo  '<div class="row ">';
                                      echo      '<div class="col">';
                                      echo          '<div class="row justify-content-between">';
                                      echo              '<div class="col-6"><p class="mb-1 fs-5"><b>Podsumowanie:</b></p></div>';
                                      echo              '<div class="flex-sm-col col-auto"><p class="mb-1 fs-5"><b>'.$subtotal.'zł</b></p></div>';
                                      echo          '</div>';
                                      echo     ' </div>';
                                      echo  '</div>';
                                      echo '<div class="d-flex justify-content-between"><button type="submit" class="btn btn-danger mt-3" name="submit">Zaktualizuj koszyk</button>';
                                      echo '<button type="submit" class="btn btn-danger mt-3" name="order">Złóż zamówienie</button></div>';
                                    }else{
                                      echo "<p>Twój koszyk jest pusty! Dodaj do niego produkty</p>";
                                    }
                                  } else {
                                    echo "<p>Twój koszyk jest pusty! Dodaj do niego produkty</p>";
                                  }?>
                                  </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
