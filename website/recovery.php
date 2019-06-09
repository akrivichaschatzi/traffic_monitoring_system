<?php
    session_start();
    include 'https.php';
    include 'db_connection.php';
    //print_r($_SESSION);
    
    if (isset($_SESSION['recovery']) && $_SESSION['recovery'] == "true"){
        
        $pdo = db_update();
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
      
        $email = $_SESSION['email_recovery'];
        $_SESSION['send_recovery'] = "false";
        
        $sql = "UPDATE users SET password=?, salt=? WHERE email=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$hashed_password, $salt, $email]);
        
        if($stmt->rowCount() > 0){
          $_SESSION['recovery_success'] = "true";
          $_SESSION['user'] = $_SESSION['email_recovery'];
          $_SESSION['login'] = "success";
          unset($_SESSION['email_recovery']);
          unset($_SESSION['recovery']);
          header("location: charts.php");
        }else{
          $_SESSION['recovery_false'] = "true";
          unset($_SESSION['email_recovery']);
          unset($_SESSION['recovery']);
          header("location: index.php");
        }
    }
?>