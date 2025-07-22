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
    public function createRegistration($full_name, $email, $phone, $address, $check_in_date, $check_out_date, $room_type, $num_guests, $special_requests)
    {
        try {
            $query = $this->db->prepare("INSERT INTO hotel_registrations (full_name, email, phone, address, check_in_date, check_out_date, room_type, num_guests, special_requests) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $query->execute([$full_name, $email, $phone, $address, $check_in_date, $check_out_date, $room_type, $num_guests, $special_requests]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // READ ALL
    public function getAllRegistrations()
    {
        try {
            $query = $this->db->query("SELECT * FROM hotel_registrations ORDER BY created_at DESC");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // READ ONE
    public function getRegistration($id)
    {
        try {
            $query = $this->db->prepare("SELECT * FROM hotel_registrations WHERE id = ?");
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    // UPDATE
    public function updateRegistration($id, $full_name, $email, $phone, $address, $check_in_date, $check_out_date, $room_type, $num_guests, $special_requests)
    {
        try {
            $query = $this->db->prepare("UPDATE hotel_registrations SET full_name=?, email=?, phone=?, address=?, check_in_date=?, check_out_date=?, room_type=?, num_guests=?, special_requests=? WHERE id=?");
            $query->execute([$full_name, $email, $phone, $address, $check_in_date, $check_out_date, $room_type, $num_guests, $special_requests, $id]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // DELETE
    public function deleteRegistration($id)
    {
        try {
            $query = $this->db->prepare("DELETE FROM hotel_registrations WHERE id = ?");
            $query->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
