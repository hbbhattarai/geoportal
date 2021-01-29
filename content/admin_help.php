<?php include "./init.php" ?>
<?php 
    if (logged_in()) {
        $username=$_SESSION['username'];
        if (!verify_user_group($pdo, $username, "Admin")) {
            set_msg("User '{$username}' does not have permission to view this page");
            redirect('./index.php');
        }
    } else {
        set_msg("Please log-in and try again");
        redirect('./index.php');
    } 
?>
<!DOCTYPE html>
<html lang="en">
    <?php include "./header.php" ?>
    <body>
        <?php include "./nav.php" ?>

        <div class="container">
            <?php 
                show_msg();
            ?>
            <h1 class="text-center">Contact</h1>
                <p><strong>Email: </strong> geospatialbhutan@gmail.com</p>
                <p><strong>Address: </strong> Thimphu:Bhutan</p>
        </div> <!--Container-->
    
        <?php include "./footer.php" ?>
    </body>
</html>