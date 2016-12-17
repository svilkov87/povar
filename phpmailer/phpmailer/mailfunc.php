<?php
require 'PHPMailer/PHPMailerAutoload.php';

//$m_from ='svilkov00@yandex.ru';
//$m_reply ='svilkov00@yandex.ru';
$m_hostmail = "smtp.yandex.ru";
$m_port= 587;
$m_password="vfvby1955";  //465  587
$m_SMTPAuth=false;
$m_debug = false;
$m_secure = 'tls';

// вот здесь отправляем
//phpmailer($subj, $tmsg, $m_to,$m_nameto,$m_namefrom,$m_from,$m_reply,$m_hostmail,$m_port,$m_password,$m_secure);

// тело функции отправки
function phpmailer($subj, $msg,$m_to,$m_nameto,$m_namefrom, $m_from,$m_reply,$m_hostmail,$m_port,$m_password, $m_secure=""){
    //https://github.com/PHPMailer/PHPMailer/issues/283
     //Create a new PHPMailer instance
    $mail = new PHPMailer;
    // Set PHPMailer to use the sendmail transport
    //$mail->isSendmail();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';
    //Set the hostname of the mail server
    $mail->Host = $m_hostmail;
    //Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port = $m_port;
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //Username to use for SMTP authentication
    $mail->Username = $m_from;
    //Password to use for SMTP authentication
    $mail->Password = $m_password;
    if ($m_secure!=''){$mail->SMTPSecure =$m_secure;}
    //Set who the message is to be sent from
    $mail->setFrom($m_from, $m_namefrom);
    //Set an alternative reply-to address
    $mail->addReplyTo($m_reply, $m_namefrom);
    //Set who the message is to be sent to
    $mail->addAddress($m_to, $m_nameto);
    //Set the subject line
    $mail->Subject = $subj;
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    
    //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
    //Replace the plain text body with one created manually
    $mail->Body = $msg;
    //Attach an image file
    //$mail->addAttachment('images/phpmailer_mini.png');
    
    //send the message, check for errors
    if (!$mail->send()) {
        //echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        //echo "Message sent!";
    }
}//phpmailer



?>