<?php
    require_once 'config/database.php';
    require_once 'includes/session.php';

    if(isset($_SESSION['logged'])) {
        header('Location: index.php');
    }

    if(isset($_POST['register'])) {
        $errors = [];
        $success = '';

        $authkey            = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
        $password           = htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8');

        if(strlen($authkey) < 3 or strlen($authkey) > 32) {
            $errors[] .= "The Username or Email must be between 3 and 16 characters!";
        }

        $rowcheckquery = "SELECT * FROM users WHERE email LIKE '{$authkey}' OR username LIKE '{$authkey}';";
        $rowstmt = $handler->prepare($rowcheckquery);
        $rowstmt->execute();
        
        $result = $rowstmt->fetch(PDO::FETCH_OBJ);
        $rowexists = $rowstmt->rowCount();
        
        if($rowexists == 0) {
            $errors[] .= 'The Username and the Password do not match!';
        } else if(!password_verify($password, $result->PASSWORD)) {
            $errors[] .= 'The Username and the Password do not match!';
        }

        if(empty($errors)) {
            $success = 'You have logged successfully!';

            $_SESSION['logged']     = true;
            $_SESSION['user_id']    = $result->id;
            $_SESSION['username']   = $result->username;
            $_SESSION['email']      = $result->email;

            header('Location: index.php?success=true');
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
                        Login
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
                                <label for="username">Username or Email</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Enter username or email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
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
