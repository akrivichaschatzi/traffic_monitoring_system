<?php 

  session_start();
  include 'db_connection.php';
  include 'https.php';
  
   if($_SERVER["REQUEST_METHOD"] == "POST") {
       
      $pdo = db_open();
      $myu = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
      $myp = filter_var($_POST["password"], FILTER_DEFAULT);  
      
      if (isset($_POST["remember"]))
        $rem = filter_var(isset($_POST["remember"]), FILTER_VALIDATE_BOOLEAN);
      else
        $rem = filter_var(0, FILTER_VALIDATE_BOOLEAN);
            
      
      //This string tells crypt to use blowfish for 5 rounds.
      $Blowfish_Pre = '$2a$05$';
      $Blowfish_End = '$'; 
      
      $stmt = $pdo->prepare("SELECT * FROM users WHERE email =?");
      $stmt->execute([$myu]);
      $user = $stmt->fetch();
   
      $hashed_pass = crypt($myp, $Blowfish_Pre . $user['salt'] . $Blowfish_End);
      
      if ($user && $hashed_pass == $user['password'])
      {
          if(!empty($rem)) {
          	setcookie ("email",$myu,time()+ 3600);
          	setcookie ("password",$myp,time()+ 3600);
          	echo "Cookies Set Successfuly";
          } else {
          	setcookie("email","");
          	setcookie("password","");
          	echo "Cookies Not Set";
          }
          $_SESSION['user'] = $myu;
          $_SESSION['login'] = "success";
          header("location: charts.php");
          
      } else {
          $_SESSION['login'] = "failed";
          header("location: index.php");
      }
   }
?>