<?php
//if(isset($_post['subject'])){

require("DBconnect.php");

$subject=$_POST["subject"];
$content=$_POST["content"];
$content=nl2br($content);

echo $subject."<br/>";
echo $content;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                  //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'penny8098@gmail.com';                     //SMTP username
    $mail->Password   = '9753189914';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;   
    $mail->SMTPSecure="ssl";                                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->Charset='utf-8';

    //Recipients
    $SQL="SELECT * FROM mail";
    if($result=mysqli_query($link,$SQL)){
        $count=mysqli_num_rows($result);
        $num=0;
        //while($row=mysqli_fetch_assoc($result)){
        for($i=0;$i<$count;$i++){
            mysqli_data_seek($result,$i);  //將記錄指標移動到第$i筆資料
            $row=mysqli_fetch_row($result);
            $mail->setFrom('penny8098@gmail.com', 'XUAN');
            $mail->addAddress($row[1], '第'.$row[0].'號會員');
           // $content='第'.$row[0].'號會員您好，'."本次的電子報訊息如下:<br>".$content."<br><br>感謝您的訂閱!<br>您的訂閱是支持我們前進的動力!";
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "=?utf-8?B?".base64_encode($subject)."?=";
            
            $mail->Body    = $content;
            echo 'Message has been sent';     //Add a recipient
        }
        
        $mail->send();  //記錄完一次寄送，不須在迴圈內
    }else{
        echo '連線錯誤';
    }

    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

//}else{
  //  echo '尚未填寫主題及內容';
//}
?>