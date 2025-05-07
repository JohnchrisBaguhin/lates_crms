<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Only verify and redirect if a user was found
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;

        if ($user['role'] === 'administrator') {
            header('Location: home.html');
            exit;
        } else {
            header('Location: user_d.html');
            exit;
        }
    } else {
        // Delay output until after checking redirection
        $error = "Invalid username or password.";
    }

    $stmt->close();
}
?>

<!-- Optional HTML output after login logic -->
<?php if (isset($error)): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
