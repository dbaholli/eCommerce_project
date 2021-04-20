<?php
    session_start();
    include 'autoload.php';

    $errors = [];

    if(isset($_POST['login_btn'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user_obj = new Auth($username, $password);

        if($user = $user_obj->login()) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_logged_in'] = true;

            if(isset($_POST['remember_me'])) {
                if($_POST['remember_me'] ==1) {
                    setcookie("username", $_SESSION['username'], time()+3600);                    
                    setcookie("is_logged_in", $_SESSION['is_logged_in'], time()+3600);
                }
            }

            if($user['is_admin'] ==1)
                header("Location: admin-panel.php");
            else 
            header("Location: profile.php");
        } else {
            $errors[] = "Username or/and password is incorrect";
        }
    }
    
    echo $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
            <?php
                if(count($errors)) {
            ?>
                <div class="alert alert-danger">
                    <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            <?php
                }
            ?>

            <form method="POST">
            <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember_me" value="1" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Remember me</label>
                </div>
                <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
            </form>
            </div>
        </div>
    </div>

</body>
</html>