<?php
require("DBconnect.php");
?>

<form action="" method="post">
請輸入您的email: <input type="text" name="email"><br/>
<input type="submit" value="訂閱">
</form>

<?php
if(isset($_POST["email"])){
    $email=$_POST["email"];
   
    $SQL="SELECT * from mail";
    $SQLadd="INSERT INTO mail(email) VALUES ('$email')";
    if($result=mysqli_query($link,$SQL)){
        echo 'connect success';
        if(mysqli_num_rows($result)==0){     //資料庫尚無紀錄時
            $resultadd=mysqli_query($link,$SQLadd);
            header('Location: success.php');        
        }
        else{       //資料庫已有紀錄，檢查email是否已存在
            while($row=mysqli_fetch_assoc($result)){
                echo $row['eNo'];
                if($row['email']==$email){    //有相同email時+1
                    $count+=1;
                }
                
            }
            if($count>0){   //email已有紀錄
                $count=0;   //歸零計算此email的紀錄
                header('Location: done.php');  
            }else{  //無此email紀錄
                $count=0;
                $resultadd=mysqli_query($link,$SQLadd);
                header('Location: success.php');
            }
            
        }
}
}
?>
