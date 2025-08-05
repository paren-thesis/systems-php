<?php
require_once('database.php');
$db = new Database('localhost', 'root', '', 'myapp');
$tasks = $db->getAllTasks();
?>
<!DOCTYPE html>
<html>

<head>
    <title>View Tasks</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: auto;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #eee;
        }

        .container {
            width: 90%;
            margin: 30px auto;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>All Tasks</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            <?php if ($tasks): foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['id']); ?></td>
                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                        <td><?php echo htmlspecialchars($task['description']); ?></td>
                        <td><?php echo htmlspecialchars($task['created_at']); ?></td>
                        <td>
                            <form action="process.php" method="POST" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo $task['id']; ?>">
                                <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this task?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach;
            else: ?>
                <tr>
                    <td colspan="5">No tasks found.</td>
                </tr>
            <?php endif; ?>
        </table>
        <br>
        <a href="index.php">Back to Add Task</a>
    </div>
</body>

</html>