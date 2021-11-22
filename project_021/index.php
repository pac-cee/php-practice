<?php
$tasksFile = 'tasks.json';
if (!file_exists($tasksFile)) {
    file_put_contents($tasksFile, json_encode([]));
}
$tasks = json_decode(file_get_contents($tasksFile), true);
$command = $argv[1] ?? '';
switch ($command) {
    case 'add':
        $task = $argv[2] ?? '';
        if ($task) {
            $tasks[] = $task;
            file_put_contents($tasksFile, json_encode($tasks));
            echo "Added: $task\n";
        } else {
            echo "Usage: php index.php add \"Task\"\n";
        }
        break;
    case 'list':
