<?php
    $page = substr(basename($_SERVER['PHP_SELF']), 0, strpos(basename($_SERVER['PHP_SELF']), '.'));
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
        <a class="navbar-brand" href="/mi0/">User System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo $page == 'index' ? 'active' : '' ?>" href="/mi0/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $page == 'users' ? 'active' : '' ?>" href="users.php">Users</a>
                </li>
            </ul>
            <?php
                if(!isset($_SESSION['logged'])) {
            ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo $page == 'login' ? 'active' : '' ?>" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $page == 'register' ? 'active' : '' ?>" href="register.php">Register</a>
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
                        <a class="dropdown-item" href="settings.php">Settings</a>
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
