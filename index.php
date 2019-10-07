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

    // WARNING: Never do that
    if(isset($_GET['success'])) {
        echo '<script>
            window.setTimeout(function() {
                window.location = \'index.php\';
            }, 3000);
            </script>';
    }
?>
    <!-- Header -->
    <?php require_once 'header.php'; ?>

    <!-- Content -->
    <div class="container py-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <?php 
                    if(isset($_SESSION['logged'])) {
                        if(isset($_GET['success'])) {
                ?>

                <div class="alert alert-success text-center">
                    You have logged in successfully
                </div>

                <?php 
                        }
                    } else { 
                ?>
                <div class="alert alert-warning text-center">
                    You have to log in order to see the full information in the site!
                </div>
                <?php }?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once 'footer.php'; ?>