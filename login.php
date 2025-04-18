<?php 
include 'includes/header.php'; 
include 'includes/db_connect.php'; 
session_start(); 
?>
<section class="form-section">
    <h2>Login</h2>
    <form method="POST">
        <label for="id_number">ID Number:</label>
        <input type="text" name="id_number" id="id_number" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit" name="login">Login</button>
    </form>
    <?php
    if (isset($_POST['login'])) {
        $id = $_POST['id_number'];
        $result = $conn_users->query("SELECT * FROM users WHERE id_number = '$id'");
        if ($result->num_rows) {
            $user = $result->fetch_assoc();
            if (password_verify($_POST['password'], $user['password_hash'])) {
                $_SESSION['id_number'] = $id;
                if ($user['face_verified'] === 'yes') {
                    header('Location: dashboard.php');
                } else {
                    header('Location: verify_face.php');
                }
            }
        }
    }
    ?>
</section>
<?php include 'includes/footer.php'; ?>