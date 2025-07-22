<?php

session_start();
require_once("database.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION["errors"] = [];
    $_SESSION["old"] = $_POST;

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $travel_date = $_POST['travel_date'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';
    $departure_location = trim($_POST['departure_location'] ?? '');
    $destination_location = trim($_POST['destination_location'] ?? '');
    $number_of_tickets = trim($_POST['number_of_tickets'] ?? '');
    $departure_time = $_POST['departure_time'] ?? '';

    // Validation
    if (empty($name)) {
        $_SESSION["errors"]["name"] = "Name is required";
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        $_SESSION["errors"]["name"] = "Name must contain only letters and spaces";
    }

    if (empty($email)) {
        $_SESSION["errors"]["email"] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["errors"]["email"] = "Please enter a valid email address";
    }

    if (empty($age)) {
        $_SESSION["errors"]["age"] = "Age is required";
    } elseif (!is_numeric($age) || $age < 1 || $age > 120) {
        $_SESSION["errors"]["age"] = "Please enter a valid age (1-120)";
    }

    if (empty($gender)) {
        $_SESSION["errors"]["gender"] = "Please select a gender";
    } elseif (!in_array($gender, ['Male', 'Female', 'Other'])) {
        $_SESSION["errors"]["gender"] = "Invalid gender selected";
    }

    if (empty($travel_date)) {
        $_SESSION["errors"]["travel_date"] = "Travel date is required";
    } elseif (strtotime($travel_date) < strtotime('today')) {
        $_SESSION["errors"]["travel_date"] = "Travel date cannot be in the past";
    }

    if (empty($payment_method)) {
        $_SESSION["errors"]["payment_method"] = "Please select a payment method";
    } elseif (!in_array($payment_method, ['Cash', 'Card', 'Mobile Money'])) {
        $_SESSION["errors"]["payment_method"] = "Invalid payment method selected";
    }

    if (empty($departure_location)) {
        $_SESSION["errors"]["departure_location"] = "Departure location is required";
    }

    if (empty($destination_location)) {
        $_SESSION["errors"]["destination_location"] = "Destination location is required";
    }

    if (empty($number_of_tickets)) {
        $_SESSION["errors"]["number_of_tickets"] = "Number of tickets is required";
    } elseif (!is_numeric($number_of_tickets) || $number_of_tickets < 1) {
        $_SESSION["errors"]["number_of_tickets"] = "Tickets must be a positive number";
    }

    if (empty($departure_time)) {
        $_SESSION["errors"]["departure_time"] = "Departure time is required";
    }

    // If no errors, store data and redirect
    if (empty($_SESSION["errors"])) {
        $db = new Database("localhost", "root", "", "bus_ticket_booking");
        $result = $db->createTicket($name, $email, $age, $gender, $travel_date, $payment_method, $departure_location, $destination_location, $number_of_tickets, $departure_time);
        if ($result === true) {
            unset($_SESSION["errors"]);
            unset($_SESSION["old"]);
            $_SESSION["success"] = "Ticket booked successfully!";
            header("Location: index.php");
            exit;
        } else {
            $_SESSION["errors"]["general"] = "Failed to book ticket: $result";
            header("Location: index.php");
            exit;
        }
    } else {
        header("Location: index.php");
        exit;
    }
}