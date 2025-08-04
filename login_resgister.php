<?php

session_start(); //<== permet de démarrer une session PHP pour stocker les informations des utilisateurs
require_once 'config.php'; //<== Contient la configuration pour la connexion à la BDD

// Nous vérigions sur le bouton "register" a été cliqué. La fonction isset vérifie si les varaibles ont été définies ou pas.
if (isset($_POST['register'])) {
  $name= $_POST['name'];
  $email= $_POST['email'];
  $password= password_hash($_POST['password'], PASSWORD_DEFAULT); // la fonction "password_hash" crypte le MDP dans la BDD, assurant qu'il ne sera pas visible dans la BDD.
  $role= $_POST['role'];
}

    $stmt = $conn->prepare("SELECT email FROM users WHERE email = $email");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['register_error'] = 'Email is already registered!';
        $_SESSION['active_form'] = 'register';
    } else {
        // Insertion de l'utilisateur
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        $stmt->execute();
        $_SESSION['register_success'] = 'Registration successful!';
    }

$checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'");
  if ($checkEmail->num_rows > 0) {
    $_SESSION['register_error'] = 'Email is already registered!';
    $_SESSION['active_form'] = 'register';
  } else {
    $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");
  }

    header("Location: index.php");
    exit();

// Véirifie si le bouton "login" a été cliqué. Vérifie également si les variables sont définies ou pas.
if (isset($_POST['login'])) {
  $email = $_POST['email']; //<== Cet variable va stocker l'email dans la DBB
  $password = $_POST['password']; //<== Cet variable va stocker le MDP dans la DBB

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

  $result = $conn->query("SELECT * FROM users WHERE email ='$email'");
    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      if (password_verify($password, $user['password'])) { // Le "password_verify" va vérifier si le MDP crypté dans la BDD correspond au MDP que l'utilisateur a écrit dans le champ du MDP
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
      //Si le MDP est bon, avec le superglobal "$_SESSION", il va stocker les données de l'utilisateur dans la BDD.

        if ($user['role'] === 'admin') {
          header("Location:admin_page.php");
        } else {
          header("Location:user_page.php");
        }
        exit();
      }
    }

    $_SESSION['login_error'] = 'Incorrect email or password';
    $_SESSION['active_form'] = 'login';
    header("Location: index.php");
    exit();

}
?>