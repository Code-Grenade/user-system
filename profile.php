<?php
    require_once 'config/database.php';
    require_once 'includes/session.php';

    // /mi0/profile.php?id=31
    $result = null;

    if(isset($_GET['id'])) {
        
        $errors = [];

        $id = intval(htmlentities($_GET['id'], ENT_QUOTES, 'UTF-8'));
        
        $rowcheckquery = "SELECT * FROM `users` WHERE id = {$id};";
        $rowstmt = $handler->prepare($rowcheckquery);
        $rowstmt->execute();
        
        $result = $rowstmt->fetch(PDO::FETCH_OBJ);
        $count = $rowstmt->rowCOunt();

        if ($count == 0)
        {
            $errors .= "There is no such User";
        }
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
                ?>

                    <div class="card mx-auto" style="width: 15rem">
                        <?php
                            $avatar = $result->avatar ?: 'http://s3.amazonaws.com/37assets/svn/765-default-avatar.png';
                        ?>
                        <a href="<?php echo $avatar; ?>"><img src="<?php echo $avatar; ?>" class="card-img-top" alt="<?php echo $avatar; ?>"></a>
                        
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $result->username; ?></h5>
                            <p class="card-text"><a href="mailto:<?php echo $result->email; ?>"><?php echo $result->email; ?></a></p>
                        </div>
                    </div>

                <?php } else { ?>
                    <div class="alert alert-danger">
                        You cannot view this page without logging in!
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once 'footer.php'; ?>
