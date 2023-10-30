<?php
    require('connect.php');

    session_start();

    if (isset($_GET['exit'])) {
        session_unset();
        echo '<script>document.location.href="./"</script>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?
        $flag = true;

        if(isset($_POST['signin'])){
            $email = $_POST['email'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM users WHERE email=:email";
            $prepare = $link->prepare($sql);
            $prepare->execute(['email' => $email]);

            $user = $prepare->fetch();
        }
    ?>
    <?
        if(isset($_SESSION['user'])) {?>
            <h1><?=$_SESSION['user']['email']?> вошел в </h1>
            <a href="?exit">выйти из</a>
        <?} else {?>
            <form name="signin" method="post">
                <input type="text" name="email" placeholder="email" value="<? if(isset($email)) echo $email; ?>">
                <input type="password" name="password" placeholder="password">
                <?
                    if(isset($_POST['signin'])){
                        if(empty($password)){
                            echo '<p class="error">введите пароль</p>';
                            $flag = false;
                        } else if(!password_verify($password, $user['password'])) {
                            echo '<p class="error">неверный пароль</p>';
                            $flag = false;
                        }
                    }
                ?>
                <button type="submit" name="signin">Войти в </button>
                <?
                    if(isset($_POST['signin'])) {
                        if ($flag) {
                            $_SESSION['user'] = $user;
                            echo '<script>document.location.href="./"</script>';
                        }
                    }
                ?>
            </form>
        <?}
    ?>
</body>
</html>