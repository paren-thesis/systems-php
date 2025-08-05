
</html>
<!DOCTYPE html>
<html>

<head>
    <title>Tasker</title>
</head>

<body>
    <div class="container">
        <h2>Tasker</h2>
        <form action="process.php" method="POST">
            <input type="text" name="title" placeholder="Title" required><br>
            <textarea name="description" placeholder="Description" required></textarea><br>
            <button type="submit" name="submit">Add Task</button>
        </form>
        <br>
        <a href="view.php">View Tasks</a>
    </div>
</body>

</html>