<?php 


  include 'db_connection.php';
  session_start();
  $db = db_open();
  
  
   if($_SERVER["REQUEST_METHOD"] == "POST") {
       
      $myu = $_POST["email"];
      //$myp = $_POST["password"];  

      // username and password sent from form 
      $myusername = mysqli_real_escape_string($db,$myu);
   
    
	 
      $sql = "SELECT * FROM users WHERE email = '$myusername'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	  $count = mysqli_num_rows($result);
      
      

		
		
      if ($count == 1) {
		$password = rand(999, 99999);
		//This string tells crypt to use blowfish for 5 rounds.
		$Blowfish_Pre = '$2a$05$';
		$Blowfish_End = '$';
		// PHP code you need to register a user
		// Blowfish accepts these characters for salts.
		$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
		$Chars_Len = 63;
		// 18 would be secure as well.
		$Salt_Length = 21;
		$salt = "";
		for($i=0; $i<$Salt_Length; $i++)
		{
			$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
		}
		$bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;
		$hashed_password = crypt($password, $bcrypt_salt);

		
		$sql1 = "UPDATE users SET password='$hashed_password',salt='$salt' WHERE email='$myusername'";

		if ($db->query($sql1) === TRUE) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . $db->error;
		}		
		
		echo "enter";
		
		$password_mail = $password;
		$to = $myusername;
		$subject = "Your Recovered Password";
		$message = "Please use this password to login " . $password_mail;
		
		$headers = "From: chris.chaschatzis@gmail.com" . "\r\n" .
"CC: $myusername";

		if(mail($to, $subject, $message, $headers)){
			header("location: forgot-password.php?msg1=success_found_email");
		}else{
			header("location: forgot-password.php?msg2=not_success_found_email");
		}  
      } else {
	
			header("location: forgot-password.php?msg3=failed");		
      }
   }
   
  CloseCon($db);
?>