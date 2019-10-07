<?php
    require_once 'config/database.php';
    require_once 'includes/session.php';

    $errors = [];

    if (!isset($_SESSION['logged']))
    {
        $errors[] .= "You are not logged in";
    }
    else
    {
        $rowcheckquery = "SELECT * FROM `users` WHERE id = {$_SESSION['user_id']};";
        $rowstmt = $handler->prepare($rowcheckquery);
        $rowstmt->execute();

        $result = $rowstmt->fetch(PDO::FETCH_OBJ);
        
        if(isset($_POST['saveSettings'])) {
            $success = '';

            $oldPassword            = htmlentities($_POST['oldPassword'], ENT_QUOTES, 'UTF-8');
            $newPassword            = password_hash(htmlentities($_POST['newPassword'], ENT_QUOTES, 'UTF-8'), PASSWORD_DEFAULT);
            $confirmNewPassword     = htmlentities($_POST['newPasswordConfirm'], ENT_QUOTES, 'UTF-8');
            
            if(!password_verify($confirmNewPassword, $newPassword)) {
                $errors[] .= 'The new passwords do not match!';
            }
            
            if(!password_verify($oldPassword, $result->PASSWORD)) {
                $errors[] .= 'The old password is not correct!';
            }

            if (password_verify($confirmNewPassword, $result->PASSWORD)) {
                $errors[] .= 'The old password cannot be your new password be maika ti prosta deba prosta !';
            }
            
            $sql = 'UPDATE users SET password = \''. $newPassword .'\' WHERE id = ' . $_SESSION['user_id'];
            $stmt = $handler->prepare($sql);
            $stmt->execute();

            $success = 'You have updated your Settings successfully!';
        }
        
        if (isset($_POST['changeAvatar']))
        {
            $newAvatar              = htmlentities($_POST['avatar']);

            if ($newAvatar === $result->avatar)
            {
                $errors[] .= "You typed the same link as your privious one";
            }
            else
            {
                $avatarChange_Query = "UPDATE `users` SET `avatar` = '{$newAvatar}' WHERE `id` = '{$_SESSION['user_id']}'";
                $avatarChange_Stmt = $handler->prepare($avatarChange_Query);
                $avatarChange_Stmt->execute();
                
                $success = 'You have updated your Avatar successfully!';
            }
        }
    }

?>

<!-- Header -->
<?php require_once 'header.php'; ?>
    
<!-- Content -->
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <?php  if(!empty($errors)) { ?>
                <div class="alert alert-danger text-center" role="alert">
                    
                    <?php foreach($errors as $error) {
                        echo $error . '<br />';
                        
                    } ?>
                </div>
            <?php } else if(isset($success)) { ?>
                <div class="text-center">
                    <div class="alert alert-success" role="alert">
                        <?php echo $success; ?>
                    </div>
                </div>
            <?php } else {?>

                <div class="card">
                    <div class="card-header">
                        Settings
                    </div>
                    <div class="card-body">

                        <form method="POST">
                            <div class="form-group">
                                <label for="avatar">Avatar</label>
                                <input type="text" class="form-control" id="avatar" name="avatar" placeholder="<?php echo $result->avatar; ?>">
                            </div>
                            
                            <button type="submit" name="changeAvatar" class="btn btn-primary">Change</button>
                        </form>

                        <hr class="separator">

                        <form method="POST">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo $_SESSION['email']; ?>" required disabled>
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>

                            <hr class="separator">
                            
                            <div class="form-group">
                                <label for="oldPassword">Old Password</label>
                                <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Old Password">
                            </div>

                            <div class="form-group">
                                <label for="newPassword">New Password</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password">
                            </div>

                            <div class="form-group">
                                <label for="newPasswordConfirm">New password confirmation</label>
                                <input type="password" class="form-control" id="newPasswordConfirm" name="newPasswordConfirm" placeholder="New Password confirmation">
                            </div>
                            
                            <button type="submit" name="saveSettings" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require_once 'footer.php'; ?>
