<?php 


  include 'db_connection.php';
  session_start();
  $db = db_open();
  
  
 /*// Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  else{echo "connected";}*/
  
   if($_SERVER["REQUEST_METHOD"] == "POST") {
       
      $myu = $_POST["email"];
      $myp = $_POST["password"];  
      $rem = $_POST["remember"];
      
      if(!empty($rem)) {
      	setcookie ("email",$myu,time()+ 3600);
      	setcookie ("password",$myp,time()+ 3600);
      	echo "Cookies Set Successfuly";
      } else {
      	setcookie("email","");
      	setcookie("password","");
      	echo "Cookies Not Set";
      }

      // username and password sent from form 
      $myusername = mysqli_real_escape_string($db,$myu);
      $mypassword = mysqli_real_escape_string($db,$myp); 
   
      //This string tells crypt to use blowfish for 5 rounds.
      $Blowfish_Pre = '$2a$05$';
      $Blowfish_End = '$';
      
      $sql = "SELECT salt, password FROM users WHERE email = '$myusername'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
      
      $hashed_pass = crypt($mypassword, $Blowfish_Pre . $row['salt'] . $Blowfish_End);
      //$count = mysqli_num_rows($result);
      
      if ($hashed_pass == $row['password']) {
          $_SESSION['login_user'] = $myusername;
          header("location: charts.html");
      } else {
      header("location: index.php?msg=failed");
          
      }
      
      // If result matched $myusername and $mypassword, table row must be 1 row
      /*echo $count;
      if($count == 1) {
         //session_register("myusername");
         $_SESSION['login_user'] = $myusername;
         header("location: charts.html");
      }else {
         $error = "Your Login Name or Password is invalid";
         echo $error;
         header("location: index.html");
      }*/
      
   }
   
  CloseCon($db);
?>