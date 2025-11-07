<?php

require_once "Database.php";

$title = "Sign Up";
//$errors = [];

if(!empty($_POST)){
    // Errore password
    // Se password esiste usaimo passwod sennò vuoto
    if( ($_POST['password'] ?? '') !== $_POST['password2'] ){
        $errors["password"] = "Le password non corrispondono";
    }

    // Connessione database
    $pdo = Database::getInstance()->getConnection();


    // Controlo se l'username esiste
    $stmt = $pdo->prepare("SELECT * FROM utenti WHERE username = :username");
    $stmt->execute(['username' => $_POST['username']]);
    $utente = $stmt->fetch();
    if($utente){
        $errors["username"] = "Username already exists";
    }

    // Controlo se l'email esiste
    $stmt = $pdo->prepare("SELECT * FROM utenti WHERE email = :email");
    $stmt->execute(['email' => $_POST['email']]);
    $email = $stmt->fetch();
    if($email){
        $errors["email"] = "Email already exists";
    }

    if(empty($errors)){
        require "email_verification_service.php";

        $token_info = generateEmailVerificationToken();
        $stmt = $pdo->prepare("INSERT INTO utenti (username, password, nome, cognome, email, verification_token, verification_expires) VALUES (:username, :password, :nome, :cognome, :email, :verification_token, :verification_expires)");

        $stmt->execute([
             "username" => $_POST['username'],
            "password" => password_hash($_POST['password'], PASSWORD_DEFAULT),
            "nome" => $_POST['nome'],
            "cognome" => $_POST['cognome'],
            "email" => $_POST['email'],
            "verification_token" => $token_info[0],
            "verification_expires" => ($token_info[1] instanceof DateTimeInterface) ? $token_info[1]->format("Y-m-d H:i:s") : $token_info[1] //Se è un istnaza di datetimeinterface lo si formatta senno lo si mette crudo
        ]);
    }

    $url = urlencode("http://localhost/Grammatica_FormRegistrazione/confirm_verification.php?token=$token_info[0]");

    sendVerificationEmail($_POST['email'], $_POST["username"], $url);
}



//session_start();


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
<div class="FormCon">
    <h1><?= $title ?></h1>

    <form action="" method="POST" class="Form">
        <div class="FromRow">
            <label for="username">⪩ Username</label>
            <input type="text" name="username" id="username" required class="Input">
        </div>
        <div class="FromRow">
            <label for="email">⪩ E-Mail</label>
            <input type="email" name="email" id="email" required class="Input">
        </div>
        <div class="FromRow">
            <label for="nome">⪩ Name</label>
            <input type="text" name="nome" id="nome" required class="Input">
        </div>
        <div class="FromRow">
            <label for="cognome">⪩ Surname</label>
            <input type="text" name="cognome" id="cognome" required class="Input">
        </div>
        <div class="FromRow">
            <label for="password">⪩ Password</label>
            <input type="text" name="password" id="password" required class="Input">
        </div>
        <div class="FromRow">
            <label for="password2">⪩ Confirm Password</label>
            <input type="text" name="password2" id="password2" required class="Input">
        </div>
        <div class="FromRowSubmit">
            <input type="submit" value="▸ Sign Up ◂" class="Button">
        </div>
    </form>

    <p><?php if(!empty($errors)) print_r($errors) ?></p>
</div>
</body>
</html>
