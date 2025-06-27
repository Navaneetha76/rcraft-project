<?php
require_once __DIR__ . '/functions.php';

$token = $_GET['token'] ?? '';
if ($token && unsubscribe($token)) {
    echo "You have been unsubscribed successfully.";
} else {
    echo "Invalid or expired unsubscribe token.";
}
