<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "functions.php";

$message = "";
$defaultEmail = "navinavaneetha538@gmail.com";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['subscribe_email'])) {
        $email = trim($_POST['subscribe_email']);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $token = subscribeEmail($email);
            $message = "✅ Subscribed <b>$email</b>. Verification code sent!";
        } else {
            $message = "❌ Invalid email address!";
        }
    }

    if (isset($_POST['verify_token'])) {
        $token = trim($_POST['verify_token']);
        $verifiedEmail = verifyEmail($token);
        if ($verifiedEmail) {
            $message = "✅ Verified email: <b>$verifiedEmail</b>";
        } else {
            $message = "❌ Verification failed: Invalid code.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>GitHub TimeLine Email Registration</title>
</head>
<body>
    <h1>GitHub TimeLine Email Registration</h1>

    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <h2>Subscribe</h2>
    <form method="post">
        <input type="email" name="subscribe_email" value="<?php echo $defaultEmail; ?>" required />
        <button type="submit">Subscribe</button>
    </form>

    <h2>Verify Email</h2>
    <form method="post">
        <input type="text" name="verify_token" placeholder="Enter verification code" required />
        <button type="submit">Verify</button>
    </form>
</body>
</html>
