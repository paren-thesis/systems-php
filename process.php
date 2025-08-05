<?php
require_once('database.php');

$db = new Database('localhost', 'root', '', 'myapp');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['submit'])) {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        if ($title && $description) {
            $db->storeTask($title, $description);
        }
        header('Location: index.php');
        exit;
    }

    if (isset($_POST['delete']) && isset($_POST['delete_id'])) {
        $db->deleteTask($_POST['delete_id']);
        header('Location: view.php');
        exit;
    }
}
