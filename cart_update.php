<?php
require_once 'config.php';
$connection_data = connection_data("root");
$connection = @new mysqli($connection_data[0], $connection_data[1], $connection_data[2], $connection_data[3]);
if($connection->connect_errno!=0){
    echo "Błąd! " . $connection->connect_errno;
}
session_start();
$id=intval($_GET['id']);
if(isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
        header("location: view_cart.php");
} else {
        $stmt = $connection->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if(isset($result['product_id']) && $result['product_id']) {
            $_SESSION['cart'][$result['product_id']] = array(
                "quantity" => 1,
                "price" => $result['price']
            );
            header("location: view_cart.php");
        } else {
            $message="Błąd.";
        }
    }
?>
