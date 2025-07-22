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

    // CREATE
    public function createTicket($name, $email, $age, $gender, $travel_date, $payment_method, $departure_location, $destination_location, $number_of_tickets, $departure_time)
    {
        try {
            $query = $this->db->prepare("INSERT INTO bus_tickets (name, email, age, gender, travel_date, payment_method, departure_location, destination_location, number_of_tickets, departure_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $query->execute([$name, $email, $age, $gender, $travel_date, $payment_method, $departure_location, $destination_location, $number_of_tickets, $departure_time]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // READ ALL
    public function getAllTickets()
    {
        try {
            $query = $this->db->query("SELECT * FROM bus_tickets ORDER BY created_at DESC");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // READ ONE
    public function getTicket($id)
    {
        try {
            $query = $this->db->prepare("SELECT * FROM bus_tickets WHERE id = ?");
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    // UPDATE
    public function updateTicket($id, $name, $email, $age, $gender, $travel_date, $payment_method, $departure_location, $destination_location, $number_of_tickets, $departure_time)
    {
        try {
            $query = $this->db->prepare("UPDATE bus_tickets SET name=?, email=?, age=?, gender=?, travel_date=?, payment_method=?, departure_location=?, destination_location=?, number_of_tickets=?, departure_time=? WHERE id=?");
            $query->execute([$name, $email, $age, $gender, $travel_date, $payment_method, $departure_location, $destination_location, $number_of_tickets, $departure_time, $id]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // DELETE
    public function deleteTicket($id)
    {
        try {
            $query = $this->db->prepare("DELETE FROM bus_tickets WHERE id = ?");
            $query->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
