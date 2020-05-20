<?php 
include("includes/classes/Chat.php");
unset($error);
$error=array();



if(isset($_POST['checkValidity'])){
    $email = filter_var($_POST['lemail'], FILTER_SANITIZE_EMAIL);
    $_SESSION['lemail'] = $email;
    $result = mysqli_query($con,"SELECT * FROM users WHERE email='$email'");
    $variable = mysqli_fetch_array($result);
    $c = mysqli_num_rows($result);
    $d = date("Y-m-d H:i:s");

    if($c==1){
        $otp = rand(100000,999999);
        

        $mail_status = sendOTP($_POST['lemail'],$otp);

        if($mail_status==1){
            $res = mysqli_query($con,"INSERT INTO otp(_id,otpNo,isExpired,date_created) VALUES('','$otp','0','$d')");

            $id = mysqli_insert_id($con);

            if(!empty($id)){
                
                array_push($error,'1');    
            }
            else{
                array_push($error,'0');   
            }

        }
    }
    else{
        array_push($error,"Invalid email");
    }
}
else if(isset($_POST['lgn'])){

   
    $otpp = $_POST['pass'];

    
    
    

    $validate = mysqli_query($con,"SELECT * FROM otp WHERE otpNo='$otpp' AND isExpired!=1 AND NOW() <= DATE_ADD(date_created, INTERVAL 1 MINUTE)");
    echo(mysqli_num_rows($validate));
    if(mysqli_num_rows($validate)==1){
        
       

        header('location:index.php'); 

        $validate = mysqli_query($con,"UPDATE otp SET isExpired = 1 WHERE otpNo='$otpp'");
        
        
    }
    else{

        array_push($error,"Invalid OTP.");

        
    }


}

?>