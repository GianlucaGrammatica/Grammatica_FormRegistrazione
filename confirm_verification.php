<?php
require_once "Database.php";

$title = "Email Verification";
$errorString = "";

if(!empty($_GET["token"])){
  $token = $_GET["token"];
  
   $pdo = Database::getInstance()->getConnection();


    // Controlo se l'username esiste
    $stmt = $pdo->prepare("SELECT * FROM utenti WHERE verification_token = :token");
    $stmt->execute(['token' => $token]);
    $utente = $stmt->fetch();

  if($utente){
    $stmt = $pdo->prepare("UPDATE utenti SET email_verified = true WHERE id = ? AND verification_expires > NOW()");
    $stmt->execute([$utente["id"]]);

    if($stmt->rowCount() > 0){
        header("Location: index");
    }

      header("Location: confirm_verification.php?error=". urlencode("Verification token expired"));
  }
  else {
      header("Location: confirm_verification.php?error=". urlencode("Invalid token"));
  }
}
else if(!empty($_GET["error"])){
    if($_GET["error"] == "Verification token expired" || $_GET["error"] == "Invalid token") {
        $errorString = $_GET["error"];
    }
    else {
        header("Location: registrazione.php");
    }

}
else {
    header("Location: registrazione.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="FormCon">
    <h1 class="Error"><?= $errorString ?></h1>
</div>
</body>
</html>