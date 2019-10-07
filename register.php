<?php
    require_once 'config/database.php';
    require_once 'includes/session.php';

    if(isset($_SESSION['logged'])) {
        header('Location: index.php');
    }

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

    <!-- Header -->
    <?php require_once 'header.php'; ?>

    <!-- Content -->
    <div class="container py-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        Registration
                    </div>
                    <div class="card-body">

                        <?php  if(!empty($errors)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php foreach($errors as $error) {
                                    echo $error . '<br />';
                                } ?>
                            </div>
                        <?php } else if(isset($success)) { ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $success; ?>
                            </div>
                        <?php } ?>
                        
                        <form method="POST">
                            
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>

                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                            </div>
                            
                            <button type="submit" name="register" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once 'footer.php'; ?>