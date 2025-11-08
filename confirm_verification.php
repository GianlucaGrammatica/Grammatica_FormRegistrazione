<?php
require_once "Database.php";

$title = "Sign Up";
//$errors = [];

if(!empty($_GET)){
  $token = $_GET["token"];
  
   $pdo = Database::getInstance()->getConnection();


    // Controlo se l'username esiste
    $stmt = $pdo->prepare("SELECT * FROM utenti WHERE verification_token = :token");
    $stmt->execute(['token' => $token]);
    $utente = $stmt->fetch();

  if($utente){
    $stmt = $pdo->prepare("UPDATE utenti SET email_verified = true WHERE id = ?");
    $stmt->execute([$utente["id]]);
  }
}
