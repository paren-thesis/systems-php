<?php

session_start();
require_once("database.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION["errors"] = [];
    $_SESSION["old"] = $_POST;

    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $check_in_date = $_POST['check_in_date'] ?? '';
    $check_out_date = $_POST['check_out_date'] ?? '';
    $room_type = $_POST['room_type'] ?? '';
    $num_guests = $_POST['num_guests'] ?? '';
    $special_requests = trim($_POST['special_requests'] ?? '');

    // Validation
    if (empty($full_name)) {
        $_SESSION["errors"]["full_name"] = "Full name is required";
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $full_name)) {
        $_SESSION["errors"]["full_name"] = "Name must contain only letters and spaces";
    }

    if (empty($email)) {
        $_SESSION["errors"]["email"] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["errors"]["email"] = "Please enter a valid email address";
    }

    if (empty($phone)) {
        $_SESSION["errors"]["phone"] = "Phone number is required";
    } elseif (!preg_match('/^\d{10,15}$/', $phone)) {
        $_SESSION["errors"]["phone"] = "Phone must contain 10-15 digits";
    }

    if (empty($address)) {
        $_SESSION["errors"]["address"] = "Address is required";
    } elseif (strlen($address) < 10) {
        $_SESSION["errors"]["address"] = "Please provide a complete address";
    }

    if (empty($check_in_date)) {
        $_SESSION["errors"]["check_in_date"] = "Check-in date is required";
    }
    if (empty($check_out_date)) {
        $_SESSION["errors"]["check_out_date"] = "Check-out date is required";
    }
    if (!empty($check_in_date) && !empty($check_out_date)) {
        if (strtotime($check_out_date) <= strtotime($check_in_date)) {
            $_SESSION["errors"]["check_out_date"] = "Check-out must be after check-in date";
        }
    }

    if (empty($room_type)) {
        $_SESSION["errors"]["room_type"] = "Please select a room type";
    }

    if (empty($num_guests)) {
        $_SESSION["errors"]["num_guests"] = "Number of guests is required";
    } elseif (!is_numeric($num_guests) || $num_guests < 1) {
        $_SESSION["errors"]["num_guests"] = "Guests must be a positive number";
    }

    // If no errors, store data and redirect
    if (empty($_SESSION["errors"])) {
        $db = new Database("localhost", "root", "", "hotel_registration");
        $result = $db->createRegistration($full_name, $email, $phone, $address, $check_in_date, $check_out_date, $room_type, $num_guests, $special_requests);
        if ($result === true) {
            unset($_SESSION["errors"]);
            unset($_SESSION["old"]);
            $_SESSION["success"] = "Registration successful!";
            header("Location: index.php");
            exit;
        } else {
            $_SESSION["errors"]["general"] = "Failed to register: $result";
            header("Location: index.php");
            exit;
        }
    } else {
        header("Location: index.php");
        exit;
    }
}