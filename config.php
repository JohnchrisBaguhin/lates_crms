<?php
function get_env_var($key) {
    return getenv($key) ?: ($_ENV[$key] ?? ($_SERVER[$key] ?? null));
}

$servername = get_env_var('DB_HOST');
$username   = get_env_var('DB_USER');
$password   = get_env_var('DB_PASS');
$dbname     = get_env_var('DB_NAME');

if (!$servername || !$username || !$password || !$dbname) {
    die("❌ Missing one or more DB environment variables.");
}

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}
?>
