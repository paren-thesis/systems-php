<?php
require_once('database.php');
$db = new Database('localhost', 'root', '', 'myapp');
$tasks = $db->getAllTasks();
?>
<!DOCTYPE html>
<html>

<head>
    <title>My Tasks</title>
    <link rel="stylesheet" href="custom-style.css">
</head>

<body>
    <div class="container">
        <h2>Task List</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= htmlspecialchars($task['title']) ?></td>
                    <td><?= htmlspecialchars($task['description']) ?></td>
                    <td>
                        <form action="process.php" method="POST">
                            <input type="hidden" name="delete_id" value="<?= $task['id'] ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($tasks)): ?>
                <tr>
                    <td colspan="3">No tasks yet</td>
                </tr>
            <?php endif; ?>
        </table>
        <p><a href="index.php">Add New Task</a></p>
    </div>
</body>

</html>