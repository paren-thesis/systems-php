<?php
class Database
{
    private $db;
    private $hostname;
    private $username;
    private $password;
    private $database;

    public function __construct($hostname, $username, $password, $database)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->connect();
    }

    public function connect()
    {
        try {
            $dsn = "mysql:host={$this->hostname};dbname={$this->database};charset=utf8mb4";
            $this->db = new PDO($dsn, $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->db;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function storeTask($title, $description)
    {
        try {
            $query = $this->db->prepare("INSERT INTO tasks (title, description) VALUES (?, ?)");
            $query->execute([$title, $description]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAllTasks()
    {
        try {
            $query = $this->db->query("SELECT * FROM tasks ORDER BY created_at DESC");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function deleteTask($id)
    {
        try {
            $query = $this->db->prepare("DELETE FROM tasks WHERE id = ?");
            $query->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
