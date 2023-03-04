<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require "vendor/autoload.php"; //Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
try {
  if (isset($_POST["submit"])) {
    $to = "ibrahimhussien227@gmail.com";
    $subject = escape(wordwrap($_POST["subject"]));
    $body = escape($_POST["body"]);
    $header = "From: " . $_POST["email"];
    //Enable verbose debug output
    $mail->isSMTP(); //Send using SMTP
    $mail->Host = "smtp.gmail.com"; //Set the SMTP server to send through
    $mail->SMTPAuth = true;
    //Enable SMTP authentication
    $mail->Username = "sonofgogo11@gmail.com"; //SMTP username
    $mail->Password = "krrwvxdfysvgznht"; //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
    $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS` //Recipients
    $mail->setFrom("sonfgogo11@gmail.com", "Blog Site");
    $mail->addAddress($to); //Name is optional
    $mail->addReplyTo($_POST["email"], "From: ");
    $mail->isHTML(true);
    //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = "This is the body in plain text for non-HTML mail clients";
    $mail->send();
    echo "Message has been sent";
  }
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>


    <!-- Navigation -->
    
    <?php include "includes/nav.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="registration">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">

                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email">
                        </div>

                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your Subject">
                        </div>

                         <div class="form-group">
                            <textarea class="form-control" name="body" id="body" cols="50" rows="10"></textarea>
                        </div>
                
                        <button type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block">Submit</button>
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php"; ?>
