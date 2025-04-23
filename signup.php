<?php
session_start();
include 'includes/db_connect.php';
include 'includes/functions.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_number'];
    $pass1 = $_POST['password']; // First password input
    $pass2 = $_POST['confirm_password']; // Second password input

    // Check if passwords match
    if ($pass1 !== $pass2) {
        $error = "Passwords do not match.";
    } else {
        // Hash the password if they match
        $pass = password_hash($pass1, PASSWORD_BCRYPT);

        if (idExistsInGovDBs($id)) {
            $conn_users->query("INSERT INTO users (id_number, password_hash, is_verified, face_verified, created_at)
                               VALUES ('$id', '$pass', 'no', 'no', NOW())");
            header('Location: verify_face.php');
            exit();
        } else {
            $error = "ID not found in government records.";
        }
    }
}
?>
<section class="container">
    <h2>Sign Up</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <label for="id_number">ID Number:</label>
        <input type="text" name="id_number" id="id_number" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
        
        <button type="submit">Sign Up</button>
    </form>
</section>
<?php include 'includes/footer.php'; ?>

