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
            $dsn = "mysql:host={$this->hostname};dbname={$this->database};";
            $this->db = new PDO($dsn, $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->db;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function storeAttendance($student_name, $student_id, $class, $subject, $date, $status, $remarks, $teacher_name, $period)
    {
        try {
            $query = $this->db->prepare("INSERT INTO attendance (student_name, student_id, class, subject, date, status, remarks, teacher_name, period) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $query->bindParam(1, $student_name);
            $query->bindParam(2, $student_id);
            $query->bindParam(3, $class);
            $query->bindParam(4, $subject);
            $query->bindParam(5, $date);
            $query->bindParam(6, $status);
            $query->bindParam(7, $remarks);
            $query->bindParam(8, $teacher_name);
            $query->bindParam(9, $period);
            $query->execute();
            return true;
        } catch (PDOException $e) {
            echo "Failed to insert attendance: " . $e->getMessage();
            return false;
        }
    }

    public function getAllAttendance()
    {
        try {
            $query = $this->db->query("SELECT * FROM attendance ORDER BY recorded_at DESC");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Failed to fetch attendance: " . $e->getMessage();
            return [];
        }
    }

    public function updateAttendance($id, $student_name, $student_id, $class, $subject, $date, $status, $remarks, $teacher_name, $period)
    {
        try {
            $query = $this->db->prepare("UPDATE attendance SET student_name=?, student_id=?, class=?, subject=?, date=?, status=?, remarks=?, teacher_name=?, period=? WHERE id=?");
            $query->bindParam(1, $student_name);
            $query->bindParam(2, $student_id);
            $query->bindParam(3, $class);
            $query->bindParam(4, $subject);
            $query->bindParam(5, $date);
            $query->bindParam(6, $status);
            $query->bindParam(7, $remarks);
            $query->bindParam(8, $teacher_name);
            $query->bindParam(9, $period);
            $query->bindParam(10, $id);
            $query->execute();
            return true;
        } catch (PDOException $e) {
            echo "Failed to update attendance: " . $e->getMessage();
            return false;
        }
    }

    public function deleteAttendance($id)
    {
        try {
            $query = $this->db->prepare("DELETE FROM attendance WHERE id=?");
            $query->bindParam(1, $id);
            $query->execute();
            return true;
        } catch (PDOException $e) {
            echo "Failed to delete attendance: " . $e->getMessage();
            return false;
        }
    }

    public function getAttendanceById($id)
    {
        try {
            $query = $this->db->prepare("SELECT * FROM attendance WHERE id=?");
            $query->bindParam(1, $id);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Failed to fetch attendance: " . $e->getMessage();
            return null;
        }
    }
}
