<?php
require_once('database.php');

// Create database connection
$db = new Database('localhost', 'root', '', 'myapp');

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Adding a new task
    if (isset($_POST['submit'])) {
        $title = trim($_POST['title']) ?? '';
        $description = trim($_POST['description']) ?? '';

        if (!empty($title) && !empty($description)) {
            $db->storeTask($title, $description);
        }

        // Redirect back to form
        header('Location: index.php');
        exit;
    }

    // Deleting a task
    if (isset($_POST['delete'], $_POST['delete_id'])) {
        $db->deleteTask($_POST['delete_id']);

        // Redirect back to task list
        header('Location: view.php');
        exit;
    }
}
