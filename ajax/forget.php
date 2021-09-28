<?php
include '../config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/OAuth.php';
require '../PHPMailer/src/POP3.php';

// get post data
foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}

if (empty($phone) && empty($email)) {
    echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Vui lòng nhập giá trị!'));
    exit();
}
$model_dropship = new Models_Dropshipers();
//CHECK GỬI OTP
if (!empty($phone)) {
    // check vailid phone
    if(!Library_Validation::isPhoneNumber($phone)) {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'SDT không hợp lệ!'));
        exit();
    }
    if ($_POST['g-recaptcha-response'] == '') {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Chưa xác nhận captcha!'));
        exit;
    }
    // get user by username   
    $dropshiper = $model_dropship->getObjectByCondition('', array('phone' => $phone));

    if(is_object($dropshiper) && $dropshiper->status == 1) {
        echo json_encode(array('code' => 0, 'status' => true, 'msg' => 'SĐT đúng!'));
        exit;
    }
    else {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'SĐT không tồn tại!'));
        exit;
    }
}
//CHECK GỬI EMAIL
if (!empty($email)) {
    if (!Library_Validation::isEmailValid($email)) {
        echo json_encode(array('code' => 1,'msg' => 'Định dạng email không đúng!'));
        exit();
    }
    $dropshiper = $model_dropship->getObjectByCondition('', array('email' => $email));
    if(is_object($dropshiper) && $dropshiper->status == 1) {
        $mail = new PHPMailer(true);
        $code = uniqid(true).$dropshiper->getId();

        $dropshiper->code_reset_pass = $code;
        $model_dropship->setPersistents($dropshiper);
        $model_dropship->edit(array('code_reset_pass'), 1);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'fchadong2@gmail.com';                     // SMTP username
            $mail->Password   = 'fpmcjargsarvtdft';                               // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587 ;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('tunguyenksoft@gmail.com', 'Dropship247');
            $mail->addAddress($email);     // Add a recipient
            $mail->addReplyTo('no-reply@gmail.com', 'No reply');

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "Reset Password Dropship247";
            // $mail->Body    = "<h1>Bấm vào link dưới để sang trang đổi mật khẩu</h1>
            //                     Click <a href='https://topmove.vn/ResetPasswords.php?code=$code'>This Link</a>";
            $mail->Body    = 
                '
                <!doctype html>
                <html lang="en-US">
                
                <head>
                    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
                    <title>Reset Password Email Template</title>
                    <meta name="description" content="Reset Password Email Template.">
                    <style type="text/css">
                        a:hover {text-decoration: underline !important;}
                    </style>
                </head>
                
                <body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
                    <!--100% body table-->
                    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
                        style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: "Open Sans", sans-serif;">
                        <tr>
                            <td>
                                <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
                                    align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="height:80px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;">
                                          <a href="'.$base_url.'" title="logo" target="_blank">
                                            <img src="https://lh3.googleusercontent.com/y7gq-3NY02tLCRebBhy6ukun1rBYiYyJeVUnZ0WtKz1AsfCb00qbtb8ZqWwX8fhtaehJN9_wZ5_QaAR21bvw4WJVS0vg6eIwW7BwgzroO_BRGR-eRHNZrW-kwD7ip-8pJEZFMBl3MKwhKLDaYBFgXLEhKHJBqSh6dlvXOndCsUInowimLQPkj9PGLwGc1osTcIGyQPJS1iD43KBuhgI7Am9liQOsg-TP3F5IwDK1sJxA_dCZa5Cb2_PwmbusWoHv6VfodMJjoK2pmHR9w0cBqApcR4EAr-RjBuBg4Tt1gjNzXvA3468Bm6_CF7i_b-rjbY3-s5RsEtoywTUJLiaAt-v8l-fww8ZiFHa5xMgzvB28_bV6CGOwBZ6pRpruZmMy1FGRXNemIIIHlvB_CsLOf-TfBMtHl8wHSyaa2m0mHumR-ae2oezi1gaStzOj-T62OyjNhQaCzreBQJsCusqpNbi0PdKhNJ5GSy6s49_rF-gwWbKzFL-znHxY0lCJozZXFSRpDqsBQpS5xXG5mzEUPqoSDKq5f7tkAG-ru_CXTDrEn1a6tMmJxMvRwvlZ7yQmHGVpBOcZxrVBLRisPDgvjsVb4JvH0-GQQJnqKBPxMU6hfeCH1glWtzRIeOPgtoG4_egm3M_5fEvYG8ptIkMe5XIemUBkSTaDIQnirKFTvH9QX6p6oErSO4pPyInFh76Y8f2D-8XH1n9t4iVcX4-nEAY=w376-h100-no?authuser=2" title="logo" alt="logo">
                                          </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height:20px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                                style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                                <tr>
                                                    <td style="height:40px;">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:0 35px;">
                                                        <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:"Rubik",sans-serif;">Bạn đã yêu cầu đổi mật khẩu của mình qua quên mật khẩu bằng email</h1>
                                                        <span
                                                            style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                                            Chúng tôi không thể gửi cho bạn mật khẩu cũ của bạn. Một liên kết duy nhất để đặt lại mật khẩu của bạn đã được tạo cho bạn. Để đặt lại mật khẩu của bạn, hãy nhấp vào liên kết sau và làm theo hướng dẫn.
                                                        </p>
                                                        <a href="'.$base_url.Commons_WebConst::HTACCESS_CHANGE_PASS_EMAIL.'?code='.$code.'"
                                                            style="background:#016a29;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Đặt lại mật khẩu</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="height:40px;">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    <tr>
                                        <td style="height:20px;">&nbsp;</td>
                                    </tr>
                                    <!-- <tr>
                                        <td style="text-align:center;">
                                            <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; <strong>www.rakeshmandal.com</strong></p>
                                        </td>
                                    </tr> -->
                                    <tr>
                                        <td style="height:80px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <!--/100% body table-->
                </body>
                
                </html>
                ';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            // echo 'Message has been sent';
            echo json_encode(array('code' => 2, 'msg' => 'Link đặt lại mật khẩu đã được gửi đến Email!'));
            exit;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            exit;
        }    
    }
    else {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Email nhập không tồn tại!'));
        exit;
    }
    
}
