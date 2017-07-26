<?php
require 'PHPMailerAutoload.php';
include_once "connect_db.php";
$ini = parse_ini_file('config.ini');

$fullname = $jobtitle = $email = $cname = $phone = "";
$errname = $errjb = $erremail = $errcname = $errphone = "";
$counter= 0;

$mail = new PHPMailer;

if (isset($_POST['submit'])) {
    if (empty($_POST['fullname'])) {
        $errname = "name is required";
        $counter++;
    } else {
        $fullname = $_POST['fullname'];
    }

    if (empty($_POST['email'])) {
        $erremail = "email is required";
        $counter++;
    } else {
        $email = $_POST['email'];
    }

    if (empty($_POST['cname'])) {
        $errcname = "company name is required";
        $counter++;
    } else {
        $cname = $_POST['cname'];
    }

    if (empty($_POST['telp'])) {
        $errphone = "phone number is required";
        $counter++;
    } else {
        $phone = $_POST['telp'];
    }

    if (!empty($_POST['jobtitle'])) {
        $jobtitle = $_POST['jobtitle'];
    }

    if($counter==0) {
        mysqli_query($conn, "INSERT INTO contact(fullname, jobtitle, email, cname, phone) VALUES ('$fullname', '$jobtitle', '$email', '$cname', '$phone')");

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $ini['host'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = $ini['smtp_auth'];                               // Enable SMTP authentication
        $mail->Username = $ini['email'];                 // SMTP username
        $mail->Password = $ini['password'];                           // SMTP password
        $mail->SMTPSecure = $ini['smtp_secure'];                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $ini['port'];                                    // TCP port to connect to

        $mail->setFrom($ini['email'], 'LightStream Analytics Asia');
        $mail->addAddress($email, $fullname);     // Add a recipient

        $mail->addReplyTo('lsa.autoreply@lightstream.asia', 'Please do not reply to this auto generated message');
        $mail->addCC('fransiskarin.tobing@lightstream.asia', 'Fransiskarin Tobing');
        $mail->addCC('nicholas.cheong@lightstream.asia', 'Nicholas Cheong');

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $ini['subject'];
        $mail->Body = 'Hi '.$fullname. ',<br/>'.$ini['message'].'<br/>'.'Please <a href='.$ini['url_attachment'].'>download this file</a> now.<br/>'.'Thank You,<br/> LSA noreply';

        $mail->AltBody = 'Auto Mail Reply';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
        mysqli_close($conn);
        header("Location: https://chriswhitaker8.wixsite.com/lightstream");
    }
}
?>
<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<div id="container">

    <form action="#" method="POST">
        <div class="form-style-2-heading">Register to access your download</div>
        <div>
            <div>
                <label>Fullname <span class="required">*</span>: </label>
            </div>
            <div>
                <input class="fieldFullname" type="text" id="fullname" name="fullname" maxlength="22"  />
                <div id="username_error" class="val_error"><?php echo $errname; ?></div>
            </div>
        </div>

        <div>
            <div>
                <label>Job Title : </label>
            </div>
            <div>
                <input class="fieldJobtitle" type="text" id="jobtitle" name="jobtitle"  />
            </div>
        </div>

        <div>
            <div>
                <label>Email <span class="required">*</span>: </label>
            </div>
            <div>
                <input class="fieldEmail" type="email" id="email" name="email"  />
                <div id="email_error" class="val_error"><?php echo $erremail; ?></div>
            </div>
        </div>

        <div >
            <div>
                <label>Company Name <span class="required">*</span>: </label>
            </div>
            <div>
                <input class="fieldCname" type="text" id="cname" name="cname"  />
                <div id="cname_error" class="val_error"><?php echo $errcname; ?></div>
            </div>
        </div>

        <div>
            <div>
                <label>Phone <span class="required">*</span>:</label>
            </div>
            <div>
                <input class="fieldTelpNum" type="number" name="telp" id="telp" maxlength="13" />
                <div id="phone_error" class="val_error"><?php echo $errphone; ?></div>
            </div>
        </div>

        <div class="spaceTop">
            <button type="submit" class="btn-primary" name="submit" onclick="">Submit</button>
            <button type="reset" class="btn-reset">Reset</button>
        </div>
    </form>
</div>
</body>
</html>