<?php
    session_start();
    include 'autoload.php';

    $errors = [];

    if(isset($_POST['register_btn'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = new Auth($username, $password);

        if($user->register()) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_logged_in'] = true;
            
            header("Location: profile.php");
        } else {
            $errors[] = "Please enter valid username(email) and password (5 or more chars)!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            <button type="submit" name="register_btn" class="btn btn-primary">Register</button>
            </form>
            </div>
        </div>
    </div>

</body>
</html>