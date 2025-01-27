<?php
session_start();
include('conexao.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
    font-family: 'Poppins', sans-serif;
    background-color: var(--clr-color-background);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    max-width: 370px;
    width: 100%;
    padding: 20px;
    border-radius: var(--border-radius-2);
    background-color: var(--clr-white);
    box-shadow: var(--box-shadow);
    align-items: center;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: 600;
    margin-bottom: 5px;
}

input[type="text"],
input[type="password"] {
    width: 300px;
    padding: 10px;
    border: 1px solid var(--clr-info-dark);
    border-radius: var(--border-radius-1);
}

button {
    background-color: var(--clr-primary);
    color: var(--clr-white);
    padding: 10px 20px;
    border: none;
    border-radius: var(--border-radius-1);
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: background-color 0.3s ease;
}
button[type="submit"] {
    background-color: #666; 
    color: var(--clr-white);
}

button:hover {
    background-color: var(--clr-primary-variant);
}
.button-group {
    display: flex;
    justify-content: space-between; 
     align-items: center; 
     }


.create-account {
    display: block;
    margin-top: 10px; 
    text-align: center;
    font-size: 14px;
}

.create-account a {
    color: var(--clr-primary);
    text-decoration: underline;
}

.create-account a:hover {
    color: var(--clr-primary-variant);
}

</style>    

</head>
<body>
<div class="container">
    <form name="login" method="post" action="processalogin.php" class="login-form">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" required/>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required/>
        </div>
        <div class="button-group">
            <button type="submit">Login</button>
            <a href="criarutilizador.php" class="create-account">Não tenho conta</a>
        </div>
</body>
</html>

