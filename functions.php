<?php
// Helper functions to read and write text files

function writeToFile($filename, $data) {
    file_put_contents($filename, $data . PHP_EOL, FILE_APPEND);
}

function readFromFile($filename) {
    if (!file_exists($filename)) {
        return [];
    }
    return file($filename, FILE_IGNORE_NEW_LINES);
}

function sendVerificationEmail($email, $token) {
    // Simulate sending email (replace with mail() if configured)
    echo "<p>Email sent to <b>$email</b> with verification code: <b>$token</b></p>";
}

function verifyEmail($token) {
    $emails = readFromFile('verification_requests.txt');
    foreach ($emails as $line) {
        list($storedToken, $storedEmail) = explode(',', $line);
        if ($storedToken === $token) {
            // Mark as verified
            writeToFile('verified_emails.txt', $storedEmail);
            return $storedEmail;
        }
    }
    return false;
}

function subscribeEmail($email) {
    $token = bin2hex(random_bytes(8)); // shorter token for easier manual input
    writeToFile('verification_requests.txt', "$token,$email");
    sendVerificationEmail($email, $token);
    return $token;
}

function unsubscribeEmail($email) {
    $subscribedEmails = readFromFile('verified_emails.txt');
    if (in_array($email, $subscribedEmails)) {
        $subscribedEmails = array_diff($subscribedEmails, [$email]);
        file_put_contents('verified_emails.txt', implode(PHP_EOL, $subscribedEmails));
        writeToFile('unsubscribed_emails.txt', $email);
        return true;
    }
    return false;
}
?>
