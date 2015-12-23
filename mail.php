<?php
  header('Content-Type: application/json');
  date_default_timezone_set('Europe/Paris');  

  $requestedWith = $_SERVER['HTTP_X_REQUESTED_WITH'];

  $name = $_POST["name"];
  $email = $_POST["email"];
  $message = $_POST["message"];

  $headers = "From: $email\r\n".
    "Reply-To: $email\r\n".
    'X-Mailer: PHP/'. phpversion();

  if( $requestedWith != "XMLHttpRequest") {
    print json_encode(array("status" => "ERROR", "message" => "not requested with Ajax"));
    return;
  }

  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    print json_encode(array("status" => "ERROR", "message" => "Email invalide:  $email"));
    return;
  }

  if($name == "") {
    print json_encode(array("status" => "ERROR", "message" => "Nom absent"));
    return;
  }

  if($message == "") {
    print json_encode(array("status" => "ERROR", "message" => "Message absent"));
    return;
  }

  $TO = "root@leligeour.net"; // FIXME: change
  $SUBJECT = "[Negitachi] Contact depuis le site web ($name)";

  if(!mail($TO , $SUBJECT, $message, $headers)) {
    print json_encode(array("status" => "ERROR", "message" => "echec du serveur"));
    return;
  }

  print json_encode(array("status" => "OK"));
  return;
?>
<!--
  PHP is not configured
-->
