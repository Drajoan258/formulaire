<?php

session_start();

$error = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ??''
];
$activeForm = $_SESSION['active_form'] ?? 'login'; //Détermine quelles sessions est active : la session d'inscription ou celle de la connexion

session_unset(); // <== La variable "session_unset()" est utilisée pour supprimer toutes les variables des sessions existantes. Cependant, la sessions elle-même reste active.

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
} //Toute la fonction "function showError" est pour montrer un message d'erreur sur le formulaire.

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full-Stack Login & Register Form With User & Admin Page | Codehal</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Page de connexion -->

    <div class="container">
        <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
            <form action="login_resgister.php" method="post">
                <h2>Login</h2>
                <?= showError($error['login']); ?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
                <p>Don't have an account ? <a href="#" onclick="showForm('register-form')">Register</a></p>
            </form>
        </div>
    </div>

     <!-- Page de connexion -->

<!-- Page d'inscription -->

    <div class="container">
        <div class="form-box" <?= isActiveForm('register', $activeForm); ?>  id="register-form">
            <form action="login_resgister.php" method="post">
                <h2>Register</h2>
                <?= showError($error['register']); ?>
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="">--Select Role--</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" name="register">Register</button>
                <p>Already have an account ? <a href="#" onclick="showForm('login-form')">Login</a></p>
            </form>
        </div>
    </div>

<!-- Page de d'inscription -->

<script src="script.js"></script>
</body>

</html>