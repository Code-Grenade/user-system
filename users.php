<?php
    require_once 'config/database.php';
    require_once 'includes/session.php';

    $errors = [];

    $rowcheckquery = "SELECT * FROM `users`;";
    $rowstmt = $handler->prepare($rowcheckquery);
    $rowstmt->execute();
    $result = $rowstmt->fetchAll(PDO::FETCH_OBJ);
    
?>
    <!-- Header -->
    <?php require_once 'header.php'; ?>
        
    <!-- Content -->
    <div class="container py-4">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <?php 
                    if(isset($_SESSION['logged'])) {
                ?>
                            
                    <table class="table text-center">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result as $user) { ?>
                                <tr>
                                    <th scope="row" class="align-middle"><?php echo $user->id; ?></th>
                                    <td><span><img class="rounded-circle rounded-sm mx-auto" width="9%" src="<?php echo $user->avatar; ?>" /></span> <a href="profile.php?id=<?php echo $user->id;?>"><?php echo $user->username; ?></td>
                                    <td class="align-middle"><a href="mailto:<?php echo $user->email; ?>"> <?php echo $user->email; ?></a></td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>

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