<?php
require 'PHPMailer/PHPMailerAutoload.php';

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])){
    //echo "{$_POST['name']}<br>";
    //echo "{$_POST['email']}<br>";
    //echo "{$_POST['message']}<br>";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
}

//echo "tel = $tel<br>";
//echo "text = $text<br>";

echo "Сообщение успешно отправлено <br><a href=\"http://hotel-na-tverskoy.ru/\">Вернуться на главную страницу сайта</a>
<script language=\"JavaScript\"> 
  window.location.href = \"http://hotel-na-tverskoy.ru/\"
</script>

<br>";



$m_to   = "zero50x@yandex.ru"; // кому - ящик

$subj = 'Сообщение с сайта';
$tmsg = "$name \n$email \n$message";
$m_nameto="Test mail";
$m_namefrom = "Test mail";
$m_from ='mihomusic@yandex.ru';
$m_reply ='mihomusic@yandex.ru';
$m_hostmail = "smtp.yandex.ru";
$m_port= 587;
$m_password="cxzaqwe";  //465  587
$m_SMTPAuth=false;
$m_debug = false;
$m_secure = 'tls';



//вот здесь отправляем
phpmailer(translit($subj), translit($tmsg),$m_to,$m_nameto,$m_namefrom,$m_from,$m_reply,$m_hostmail,$m_port,$m_password,$m_secure);


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

 function mail_utf8($to, $from_user, $from_email, $subject = '(No subject)', $message = '') {
  //sendmail_path = "/usr/sbin/sendmail -t -i"
      $from_user = "=?UTF-8?B?".base64_encode($from_user)."?="; //  $from_user = "=?utf-8?Q?".($from_user)."=";
      //$from_user = "=?UTF-8?Q?".($from_user)."?=";
      //$from_user = "=?utf-8?Q?=D0=A4=D0=BE=D0=BD=D0=B4?=";


      $subject = "=?UTF-8?B?".base64_encode($subject)."?=";  //Content-type: text/html; multipart/alternative
       $mime = "\r\nMIME-Version: 1.0"  .                "Content-type: text/html; charset=UTF-8";
       //$mime = "\r\nMIME-Version: 1.0"  .                "Content-type: text/html; charset=UTF-8  \r\nContent-Transfer-Encoding: 7bit";

           $headers = "From: $from_user <$from_email> $mime"; //$headers = "From: <$from_email>"; // . "\r\n"

     return mail($to, $subject, $message, $headers);
   }

function mail_utf82($to, $from_user, $from_email, $subject = '(No subject)', $message = '') {
  //sendmail_path = "/usr/sbin/sendmail -t -i"
      $from_user = "=?UTF-8?B?".base64_encode($from_user)."?="; //  $from_user = "=?utf-8?Q?".($from_user)."=";
      //$from_user = "=?UTF-8?Q?".($from_user)."?=";
      //$from_user = "=?utf-8?Q?=D0=A4=D0=BE=D0=BD=D0=B4?=";


      $subject = "=?UTF-8?B?".base64_encode($subject)."?=";  //Content-type: text/html;
       $mime = "\r\nMIME-Version: 1.0"  .                "Content-type: multipart/alternative; charset=UTF-8";
        $mime = "\r\nMIME-Version: 1.0"  .                "Content-type: text/html; charset=UTF-8  \r\nContent-Transfer-Encoding: 7bit";

           $headers = "From: $from_user <$from_email> $mime"; $headers = "From: <$from_email>"; // . "\r\n"

     return mail($to, $subject, $message, $headers);
   }

 function translit($input){
$bulk = array(
/*
   'Є'=>'YE','І'=>'I','Ѓ'=>'G','і'=>'i','№'=>'-','є'=>'ye','ѓ'=>'g',
   'А'=>'A','Б'=>'B','В'=>'V','Г'=>'G','Д'=>'D',
   'Е'=>'E','Ё'=>'YO','Ж'=>'ZH',
   'З'=>'Z','И'=>'I','Й'=>'J','К'=>'K','Л'=>'L',
   'М'=>'M','Н'=>'N','О'=>'O','П'=>'P','Р'=>'R',
   'С'=>'S','Т'=>'T','У'=>'U','Ф'=>'F','Х'=>'X',
   'Ц'=>'C','Ч'=>'CH','Ш'=>'SH','Щ'=>'SHH','Ъ'=>'\'',
   'Ы'=>'Y','Ь'=>'','Э'=>'E','Ю'=>'YU','Я'=>'YA',
   'а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d',
   'е'=>'e','ё'=>'yo','ж'=>'zh',
   'з'=>'z','и'=>'i','й'=>'j','к'=>'k','л'=>'l',
   'м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r',
   'с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'x',
   'ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shh','ъ'=>'',
   'ы'=>'y','ь'=>'','э'=>'e','ю'=>'yu','я'=>'ya'
   
   
   , ' '=>'_','—'=>'_',','=>'_','!'=>'_','@'=>'_'
   ,'#'=>'-','$'=>'','%'=>'','^'=>'','&'=>'','*'=>''
   ,'('=>'',')'=>'','+'=>'','='=>'',';'=>'',':'=>'',
   '''=>'','''=>'','~'=>'','`'=>'','?'=>'','/'=>''
  ,'['=>'',']'=>'','{'=>'','}'=>'','|'=>'' ,'\\'=>''*/
  );

return strtr($input, $bulk);
}

function filename($title,$name){
/*$tthis = explode('.',$name);
$res = $title.'.'.$tthis[1];*/
return $name;
}
function upload($tfile,$replace, $checksize,$piconly){
$imageFileType = pathinfo($tfile,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileup"]["tmp_name"]);
    if($check !== false ) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        //echo "File OK!";
        $uploadOk = 1;//0;
    }
}
// Check if file already exists
if (file_exists($tfile) && $replace==1) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileup"]["size"] > 5000000000 && $checksize==1) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif"  && $piconly==1) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileup"]["tmp_name"], $tfile)) {
//  echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
//echo "File ". basename( $_FILES["fileToUpload"]["name"]). "";
    } else {
        echo "Ошибка загрузки! Upload error!";
    }
}
}//upload()
?>