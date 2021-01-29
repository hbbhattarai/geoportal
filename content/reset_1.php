<?php include "./init.php"; ?>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require '../vendor/autoload.php';

    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $username=$_POST['username'];
        if (count_field_val($pdo, "users", "username", $username)>0) {
            $row=return_field_data($pdo, "users", "username", $username);
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->SMTPAuth = true;
            $mail->isHTML(true);
            $mail->Username = 'geospatialbhutan@gmail.com';
            $mail->Password = 'kali@339456';
            $mail->setFrom('geospatialbhutan@gmail.com');
            $mail->addAddress($row['email']);
            $mail->Subject = 'Account Activation';
            $mail->msgHTML("Please go to http://{$_SERVER['SERVER_NAME']}/reset_2.php?user={$username}&code={$row['validationcode']} in order to reset your password");
            $mail-> body = "Please go to http://{$_SERVER['SERVER_NAME']}/reset_2.php?user={$username}&code={$row['validationcode']} in order to reset your password";
            $mail->send();
        } else {
            set_msg("User '{$username}' was not found in the database");
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