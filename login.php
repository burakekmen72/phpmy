<?php
require 'config.php';
require 'mail.php'; // SMTP mail fonksiyonları burada olacak

// Kayıt işlemi
if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $code = rand(100000, 999999);

    $stmt = $pdo->prepare("INSERT INTO users (email, password, verify_code) VALUES (?, ?, ?)");
    if ($stmt->execute([$email, $pass, $code])) {
        send_verification_mail($email, $code);
        echo "Mail adresinize doğrulama kodu gönderildi!";
    } else {
        echo "Kayıt başarısız!";
    }
}

// Giriş işlemi
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($pass, $user['password'])) {
        if (!$user['verified']) {
            echo "Mailinizi doğrulayın!";
            exit;
        }
        $_SESSION['user'] = $user;
        header("Location: ".($user['is_admin'] ? "admin.php" : "index.php"));
        exit;
    } else {
        echo "Hatalı giriş!";
    }
}

// Mail doğrulama
if (isset($_POST['verify'])) {
    $email = $_POST['email'];
    $code = $_POST['code'];
    $stmt = $pdo->prepare("UPDATE users SET verified=1 WHERE email=? AND verify_code=?");
    if ($stmt->execute([$email, $code])) {
        echo "Doğrulama başarılı, giriş yapabilirsiniz!";
    } else {
        echo "Kod yanlış!";
    }
}
?>

<!-- HTML kısmı -->
<form method="post">
    <input type="email" name="email" required placeholder="E-posta">
    <input type="password" name="password" required placeholder="Şifre">
    <button type="submit" name="login">Giriş Yap</button>
    <button type="submit" name="register">Kayıt Ol</button>
</form>
<!-- Doğrulama için ayrı form -->
<form method="post">
    <input type="email" name="email" required placeholder="E-posta">
    <input type="text" name="code" required placeholder="Doğrulama Kodu">
    <button type="submit" name="verify">Doğrula</button>
</form>