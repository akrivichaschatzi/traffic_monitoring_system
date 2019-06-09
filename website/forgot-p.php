<?php 

  session_start();
  include 'https.php';
  include 'db_connection.php';
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
       
      $pdo = db_open();
      $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
      $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
      $stmt->execute([$email]); 
      $user = $stmt->fetch();
        
  		$url = "http://zafora.icte.uowm.gr/~ictest00760/traffic_monitoring_system/website/recovery.php";
  		$to = $email;
  		$subject = "Your Recovered Password";
  		$message = "Please click this link to restore your password " . $url;
  		$headers = "From: st0760@icte.uowm.gr" . "\r\n" ."CC: $myu";
  
      if($user){
        $_SESSION['found_email'] = "true";
    		if(mail($to, $subject, $message, $headers)){
          $_SESSION['send_recovery'] = "true";
          $_SESSION['recovery'] = "true";
          $_SESSION['email_recovery'] = $email;
    			header("location: index.php");
    		}
        else{
          $_SESSION['send_recovery'] = "false";
    			header("location: forgot-password.php");
    		}  
      }
      else {
  	    $_SESSION['found_email'] = "false";
  			header("location: forgot-password.php");		
      }
  }
?>