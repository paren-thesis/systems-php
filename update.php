<?php
session_start();
require_once 'database.php';
$db = new Database('localhost', 'root', '', 'bus_ticket_booking');

// Fetch record
if (!isset($_GET['id'])) {
    header('Location: viewbooking.php');
    exit;
}
$id = intval($_GET['id']);
$ticket = $db->getTicket($id);
if (!$ticket) {
    $_SESSION['success'] = 'Ticket not found.';
    header('Location: viewbooking.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Validation (same as process.php)
    if (empty($name)) {
        $errors['name'] = 'Name is required';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        $errors['name'] = 'Name must contain only letters and spaces';
    }
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }
    if (empty($age)) {
        $errors['age'] = 'Age is required';
    } elseif (!is_numeric($age) || $age < 1 || $age > 120) {
        $errors['age'] = 'Please enter a valid age (1-120)';
    }
    if (empty($gender)) {
        $errors['gender'] = 'Please select a gender';
    } elseif (!in_array($gender, ['Male', 'Female', 'Other'])) {
        $errors['gender'] = 'Invalid gender selected';
    }
    if (empty($travel_date)) {
        $errors['travel_date'] = 'Travel date is required';
    } elseif (strtotime($travel_date) < strtotime('today')) {
        $errors['travel_date'] = 'Travel date cannot be in the past';
    }
    if (empty($payment_method)) {
        $errors['payment_method'] = 'Please select a payment method';
    } elseif (!in_array($payment_method, ['Cash', 'Card', 'Mobile Money'])) {
        $errors['payment_method'] = 'Invalid payment method selected';
    }
    if (empty($departure_location)) {
        $errors['departure_location'] = 'Departure location is required';
    }
    if (empty($destination_location)) {
        $errors['destination_location'] = 'Destination location is required';
    }
    if (empty($number_of_tickets)) {
        $errors['number_of_tickets'] = 'Number of tickets is required';
    } elseif (!is_numeric($number_of_tickets) || $number_of_tickets < 1) {
        $errors['number_of_tickets'] = 'Tickets must be a positive number';
    }
    if (empty($departure_time)) {
        $errors['departure_time'] = 'Departure time is required';
    }

    if (empty($errors)) {
        $result = $db->updateTicket($id, $name, $email, $age, $gender, $travel_date, $payment_method, $departure_location, $destination_location, $number_of_tickets, $departure_time);
        if ($result === true) {
            $_SESSION['success'] = 'Ticket updated successfully!';
            header('Location: viewbooking.php');
            exit;
        } else {
            $errors['general'] = 'Failed to update: ' . $result;
        }
    }
    // If errors, keep form filled
    $ticket = array_merge($ticket, $_POST);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Edit Ticket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="wrapper">
    <header id="header">
        <div class="inner">
            <a href="index.php" class="logo">
                <span class="fa fa-bus"></span> <span class="title">BUS TICKET BOOKING</span>
            </a>
            <nav>
                <ul>
                    <li><a href="viewbooking.php">Back to Tickets</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div id="main">
        <div class="inner">
            <h1>Edit Ticket</h1>
            <?php if (!empty($errors['general'])): ?>
                <div class="alert alert-error"> <?= $errors['general'] ?> </div>
            <?php endif; ?>
            <form method="post">
                <div class="fields">
                    <div class="field">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" value="<?= htmlspecialchars($ticket['name']) ?>">
                        <p style="color:red;"> <?= $errors['name'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= htmlspecialchars($ticket['email']) ?>">
                        <p style="color:red;"> <?= $errors['email'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age" min="1" value="<?= htmlspecialchars($ticket['age']) ?>">
                        <p style="color:red;"> <?= $errors['age'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender">
                            <option value="">---Select Gender---</option>
                            <option value="Male" <?= ($ticket['gender'] === 'Male') ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= ($ticket['gender'] === 'Female') ? 'selected' : '' ?>>Female</option>
                            <option value="Other" <?= ($ticket['gender'] === 'Other') ? 'selected' : '' ?>>Other</option>
                        </select>
                        <p style="color:red;"> <?= $errors['gender'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="travel_date">Travel Date</label>
                        <input type="date" name="travel_date" id="travel_date" value="<?= htmlspecialchars($ticket['travel_date']) ?>">
                        <p style="color:red;"> <?= $errors['travel_date'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="payment_method">Payment Method</label>
                        <select name="payment_method" id="payment_method">
                            <option value="">---Select Payment Method---</option>
                            <option value="Cash" <?= ($ticket['payment_method'] === 'Cash') ? 'selected' : '' ?>>Cash</option>
                            <option value="Card" <?= ($ticket['payment_method'] === 'Card') ? 'selected' : '' ?>>Card</option>
                            <option value="Mobile Money" <?= ($ticket['payment_method'] === 'Mobile Money') ? 'selected' : '' ?>>Mobile Money</option>
                        </select>
                        <p style="color:red;"> <?= $errors['payment_method'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="departure_location">Departure Location</label>
                        <input type="text" name="departure_location" id="departure_location" value="<?= htmlspecialchars($ticket['departure_location']) ?>">
                        <p style="color:red;"> <?= $errors['departure_location'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="destination_location">Destination Location</label>
                        <input type="text" name="destination_location" id="destination_location" value="<?= htmlspecialchars($ticket['destination_location']) ?>">
                        <p style="color:red;"> <?= $errors['destination_location'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="number_of_tickets">Number of Tickets</label>
                        <input type="number" name="number_of_tickets" id="number_of_tickets" min="1" value="<?= htmlspecialchars($ticket['number_of_tickets']) ?>">
                        <p style="color:red;"> <?= $errors['number_of_tickets'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="departure_time">Departure Time</label>
                        <input type="time" name="departure_time" id="departure_time" value="<?= htmlspecialchars($ticket['departure_time']) ?>">
                        <p style="color:red;"> <?= $errors['departure_time'] ?? '' ?> </p>
                    </div>
                </div>
                <div class="field text-right">
                    <ul class="actions">
                        <li><input type="submit" value="Update" class="primary"></li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
    <footer id="footer">
        <div class="inner">
            <ul class="copyright">
                <li>&copy; 2024 Bus Ticket Booking</li>
                <li>All rights reserved</li>
            </ul>
        </div>
    </footer>
</div>
</body>
</html> 