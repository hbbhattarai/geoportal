<?php include "./init.php"; ?>
<?php
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $username=$_POST['username'];
        if (count_field_val($pdo, "users", "username", $username)>0) {
            $row=return_field_data($pdo, "users", "username", $username);
            $body = "Please go to http://{$_SERVER['SERVER_NAME']}/reset_2.php?user={$username}&code={$row['validationcode']} in order to reset your password";
            send_mail($row['email'], "Reset Password", $body, $from_email, $reply_email);
        } else {
            set_msg("User '{$username}' was not found in the database");
        }
    } 
    elseif ($_GET['user']) {
        if ($_GET['code']) {
            $username=$_GET['user'];
            $vcode=$_GET['code'];
            if (count_field_val($pdo, "users", "username", $username)>0) {
                $row=return_field_data($pdo, "users", "username", $username);
                if ($vcode!=$row['validationcode']) {
                    set_msg("Validation code does not match database");
                    redirect("index.php");
                }
            } else {
                set_msg("User '{$username}' not found in database");
                redirect("index.php");
            }
        } else {
            set_msg("No validation code included with reset request");
            redirect("index.php");
        }
    } else {
        set_msg("No user included with reset request");
        redirect("index.php");
    }
    if ($_SERVER['REQUEST_METHOD']=="POST") {
        try {
            $password=$_POST['password'];
            $pword_confirm=$_POST['password_confirm'];
            if ($password==$pword_confirm) {
                $stmnt=$pdo->prepare("UPDATE users SET password=:password WHERE username=:username");
                $user_data=[':password'=>password_hash($password, PASSWORD_BCRYPT), ':username'=>$username];
                $stmnt->execute($user_data);
                set_msg("Password successfully updated. Please log in");
                redirect("login.php");
            } else {
                set_msg("Passwords don't match");
            }
        } catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php include "./header.php" ?>
    <body>
        <?php include "./nav.php" ?>

        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    <?php 
                        show_msg();
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-login">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="register-form" method="post" role="form" >
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" tabindex="5" class="form-control" placeholder="Password"  required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_confirm" id="confirm-password" tabindex="6" class="form-control" placeholder="Confirm Password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="reset-submit" id="reset-submit" tabindex="4" class="form-control btn btn-custom" value="Reset Password">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
?>
<!DOCTYPE html>
<html lang="en">
    <?php include "./header.php" ?>
    <body>
        <?php include "./nav.php" ?>
        <div class="container">
    	    <div class="row">
			    <div class="col-md-6 col-md-offset-3">
                    <?php 
                        show_msg();
                    ?>
				    <div class="panel panel-login">
					    <div class="panel-body">
						    <div class="row">
							    <div class="col-lg-12">
							        <h3 class="text-center">Reset Password</h3>
								    <form id="login-form"  method="post" role="form" style="display: block;">
									    <div class="form-group">
										    <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username"  required>
									    </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="reset-submit" id="reset-submit" tabindex="4" class="form-control btn btn-custom" value="Reset password">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include "./footer.php" ?>
    </body>
</html>