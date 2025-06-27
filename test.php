<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "functions.php";

$email = "Navaneetha@gmail.com";

// 1. Subscribe email
subscribeEmail($email);
echo "Subscribed $email\n";

// 2. Read the last token from verification requests
$lines = readFromFile("verification_requests.txt");
if (!empty($lines)) {
    $lastLine = trim($lines[count($lines) - 1]);
    list($token, $storedEmail) = explode(",", $lastLine);

    // 3. Verify email using token
    if (verifyEmail(trim($token))) {
        echo "Verified email: $storedEmail\n";
    } else {
        echo "Verification failed for $storedEmail\n";
    }

    // 4. Unsubscribe email
    if (unsubscribeEmail(trim($storedEmail))) {
        echo "Unsubscribed $storedEmail\n";
    } else {
        echo "Unsubscribe failed\n";
    }
} else {
    echo "No verification requests found.\n";
}
