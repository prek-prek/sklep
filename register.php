<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
}
require_once "auth_config.php";
$username = $password = $confirm_password = $email = "";
$username_err = $email_err =  $password_err = $confirm_password_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Nazwa nie moze byc pusta";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Nazwa może zawierac tylko litery alfabetu, liczby i podkreslenia";
    } else{
        $sql = "SELECT user_id FROM users WHERE login = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Jest juz uzytkownik o takiej nazwie.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Błąd.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    if(empty(trim($_POST["password"]))){
        $password_err = "Proszę wprowadzic haslo";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Haslo musi zawierac conajmniej 6 znaków.";
    } else{
        $password = trim($_POST["password"]);
    }

    if(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
        $email_err = "Proszę podac prawidlowy email.";
    }elseif(empty(trim($_POST["email"]))) {
        $email_err = "Proszę podac prawidlowy email.";
    } else{
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Prosze potwierdzic haslo";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Hasla sie nie zgadzaja";
        }
    }
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        $sql = "INSERT INTO users (login, haslo, email) VALUES (?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $email);
            $param_username = $username;
            $param_password = $password;
            $param_email = $email;
            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
            } else{
                echo "Błąd";
            }
            mysqli_stmt_close($stmt);
        }else{
            echo 'gowno2';
        }
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper" style="margin-left: auto; margin-right: auto; margin-top: 20px;">
      <img src="logo.png" style="width: 350px; height: 150px; margin-left: -20px; float: left;">
        <h2>Zarejestruj sie</h2>
        <p>Zarejestruj się do serwisu pikawa.pl</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Nazwa</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>Hasło</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Potwierdź hasło</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-danger" value="Potwierdź">
            </div>
            <p>Masz już konto? <a href="login.php">Zaloguj się tutaj</a>.</p>
        </form>
    </div>
</body>
</html>
