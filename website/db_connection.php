<?php
  
  include 'https.php';
  function db_open(){
    // connection information
    $host = '/zstorage/home/ictest00760/mysql/run/mysql.sock';
    $dbname = 'traffic_monitoring_system';
    $user = 'root';
    $pass = 'akrivi123$#';
    // connect to database or return error
    try{
       $pdo = new PDO("mysql:unix_socket=$host;dbname=$dbname;charset=utf8", $user, $pass);
       $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
       $pdo->query('set character_set_client=utf8');
       $pdo->query('set character_set_connection=utf8');
       $pdo->query('set character_set_results=utf8');
       $pdo->query('set character_set_server=utf8');
    }
    catch(PDOException $e){
      die('Connection error:' . $pe->getmessage()); 
    }
    
  return $pdo;
  }
  
  function db_update(){
  
    $host = '/zstorage/home/ictest00760/mysql/run/mysql.sock';
    $dbname = 'traffic_monitoring_system';
    $user = 'root';
    $pass = 'akrivi123$#';
    // connect to database or return error
    try{
       $pdo = new PDO("mysql:unix_socket=$host;dbname=$dbname;charset=utf8", $user, $pass);
       $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    }
    catch(PDOException $e){
      die('Connection error:' . $pe->getmessage()); 
    }
  return $pdo;
  }

?>
