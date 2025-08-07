<?php
class Database
{
    private $connection;

    public function __construct($host, $username, $password, $dbname)
    {
        try {
            $this->connection = new PDO(
                "mysql:host=$host;dbname=$dbname",
                $username,
                $password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // Add a new task
    public function storeTask($title, $description)
    {
        $stmt = $this->connection->prepare("INSERT INTO tasks (title, description) VALUES (?, ?)");
        return $stmt->execute([$title, $description]);
    }

    // Get all tasks
    public function getAllTasks()
    {
        $sql = "SELECT * FROM tasks";
        return $this->connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete a task
    public function deleteTask($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM tasks WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
// Example usage
// $db = new Database();
// $db->addTask("Buy groceries", "Get milk and bread");
// $tasks = $db->getTasks();
// foreach ($tasks as $task) {
//     echo $task['title'] . "\n";
// }
// $db->removeTask(1);
// Uncomment the example usage to test the class
// Note: Ensure that the 'tasks' table exists in your 'myapp' database with appropriate columns.    