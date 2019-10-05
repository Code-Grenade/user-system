<?php
    require_once 'config/database.php';
    require_once 'includes/session.php';

    if(isset($_POST['register'])) {
        $errors = [];
        $success = '';

        $username           = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
        $password           = password_hash(htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8'), PASSWORD_DEFAULT);
        $confirmPassword    = htmlentities($_POST['confirmPassword'], ENT_QUOTES, 'UTF-8');
        $email              = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');

        if(strlen($username) < 3 or strlen($username) > 16) {
            $errors[] .= "The username is must be between 3 and 16 characters!";
        }

        // var_dump(htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8'));
        // var_dump($confirmPassword);
        // var_dump(password_verify($confirmPassword, $password));
        // var_dump(password_hash($confirmPassword, PASSWORD_ARGON2I));
        // var_dump($password);
        if((strlen($confirmPassword) < 6 or strlen($confirmPassword) > 32)) {
            $errors[] .= "The password must be between 6 and 32 characters!";
        } else if(!password_verify($confirmPassword, $password)) {
            $errors[] .= 'The passwords do not match!';
        }

        $rowcheckquery = "SELECT * FROM `users` WHERE `email`='{$email}' OR `username` LIKE '{$username}'";
        $rowstmt = $handler->prepare($rowcheckquery);
        $rowstmt->execute();
        $rowexists = $rowstmt->fetch(PDO::FETCH_OBJ);
        
        if(!empty($rowexists)) {
            $errors[] .= 'The e-mail or username is already taken!';
        }

        if(empty($errors)) {
            $success = 'You have registered successfully!';

            $sql = "INSERT INTO `users` (`username`, `email`, `password`) VALUES ('{$username}', '{$email}', '{$password}');";
            $stmt = $handler->prepare($sql);
            $result = $stmt->execute();
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>User System</title>
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="/mi0/">User Form</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="/mi0/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users.php">Users <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <?php
                if(!isset($_SESSION['logged'])) {
            ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
            </ul>
            <?php
                } else {
            ?>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="user.php"></a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                        <?php echo $_SESSION['username']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
            <?php 
                }
            ?>
            
        </div>
    </nav>

    <!-- Content -->
    <div class="container py-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <?php 
                    if(isset($_SESSION['logged'])) {
                ?>

                <div class="alert alert-success">
                    You have logged in successfully
                </div>

                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Footer -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>
</html>
