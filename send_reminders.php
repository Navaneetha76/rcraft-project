<?php
require_once __DIR__ . '/src/functions.php';

$subscribers = getSubscribers();
$tasks = getTasks();

if (empty($tasks)) return;

$body = "Here are your current tasks:\n\n";
foreach ($tasks as $task) {
    $body .= "- {$task['task']} ({$task['timestamp']})\n";
}

foreach ($subscribers as $subscriber) {
    $email = $subscriber['email'];
    $token = $subscriber['token'];
    $unsubscribeLink = "http://yourdomain.com/src/unsubscribe.php?token=$token";

    $fullBody = $body . "\n\nTo unsubscribe, click here: $unsubscribeLink";

    mail($email, "Your Task Reminder", $fullBody);
}
