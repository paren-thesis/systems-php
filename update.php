<?php
session_start();
require_once 'database.php';
$db = new Database('localhost', 'root', '', 'hotel_registration');

// Fetch record
if (!isset($_GET['id'])) {
    header('Location: viewbooking.php');
    exit;
}
$id = intval($_GET['id']);
$reg = $db->getRegistration($id);
if (!$reg) {
    $_SESSION['success'] = 'Registration not found.';
    header('Location: viewbooking.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $check_in_date = $_POST['check_in_date'] ?? '';
    $check_out_date = $_POST['check_out_date'] ?? '';
    $room_type = $_POST['room_type'] ?? '';
    $num_guests = $_POST['num_guests'] ?? '';
    $special_requests = trim($_POST['special_requests'] ?? '');

    // Validation (same as process.php)
    if (empty($full_name)) {
        $errors['full_name'] = 'Full name is required';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $full_name)) {
        $errors['full_name'] = 'Name must contain only letters and spaces';
    }
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }
    if (empty($phone)) {
        $errors['phone'] = 'Phone number is required';
    } elseif (!preg_match('/^\d{10,15}$/', $phone)) {
        $errors['phone'] = 'Phone must contain 10-15 digits';
    }
    if (empty($address)) {
        $errors['address'] = 'Address is required';
    } elseif (strlen($address) < 10) {
        $errors['address'] = 'Please provide a complete address';
    }
    if (empty($check_in_date)) {
        $errors['check_in_date'] = 'Check-in date is required';
    }
    if (empty($check_out_date)) {
        $errors['check_out_date'] = 'Check-out date is required';
    }
    if (!empty($check_in_date) && !empty($check_out_date)) {
        if (strtotime($check_out_date) <= strtotime($check_in_date)) {
            $errors['check_out_date'] = 'Check-out must be after check-in date';
        }
    }
    if (empty($room_type)) {
        $errors['room_type'] = 'Please select a room type';
    }
    if (empty($num_guests)) {
        $errors['num_guests'] = 'Number of guests is required';
    } elseif (!is_numeric($num_guests) || $num_guests < 1) {
        $errors['num_guests'] = 'Guests must be a positive number';
    }

    if (empty($errors)) {
        $result = $db->updateRegistration($id, $full_name, $email, $phone, $address, $check_in_date, $check_out_date, $room_type, $num_guests, $special_requests);
        if ($result === true) {
            $_SESSION['success'] = 'Registration updated successfully!';
            header('Location: viewbooking.php');
            exit;
        } else {
            $errors['general'] = 'Failed to update: ' . $result;
        }
    }
    // If errors, keep form filled
    $reg = array_merge($reg, $_POST);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Edit Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="wrapper">
    <header id="header">
        <div class="inner">
            <a href="index.php" class="logo">
                <span class="fa fa-hotel"></span> <span class="title">HOTEL REGISTRATION</span>
            </a>
            <nav>
                <ul>
                    <li><a href="viewbooking.php">Back to Registrations</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div id="main">
        <div class="inner">
            <h1>Edit Registration</h1>
            <?php if (!empty($errors['general'])): ?>
                <div class="alert alert-error"> <?= $errors['general'] ?> </div>
            <?php endif; ?>
            <form method="post">
                <div class="fields">
                    <div class="field">
                        <label for="full_name">Full Name</label>
                        <input type="text" name="full_name" id="full_name" value="<?= htmlspecialchars($reg['full_name']) ?>">
                        <p style="color:red;"> <?= $errors['full_name'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= htmlspecialchars($reg['email']) ?>">
                        <p style="color:red;"> <?= $errors['email'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($reg['phone']) ?>">
                        <p style="color:red;"> <?= $errors['phone'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" value="<?= htmlspecialchars($reg['address']) ?>">
                        <p style="color:red;"> <?= $errors['address'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="check_in_date">Check-in Date</label>
                        <input type="date" name="check_in_date" id="check_in_date" value="<?= htmlspecialchars($reg['check_in_date']) ?>">
                        <p style="color:red;"> <?= $errors['check_in_date'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="check_out_date">Check-out Date</label>
                        <input type="date" name="check_out_date" id="check_out_date" value="<?= htmlspecialchars($reg['check_out_date']) ?>">
                        <p style="color:red;"> <?= $errors['check_out_date'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="room_type">Room Type</label>
                        <select name="room_type" id="room_type">
                            <option value="">---Select Room Type---</option>
                            <option value="Single" <?= ($reg['room_type'] === 'Single') ? 'selected' : '' ?>>Single</option>
                            <option value="Double" <?= ($reg['room_type'] === 'Double') ? 'selected' : '' ?>>Double</option>
                            <option value="Suite" <?= ($reg['room_type'] === 'Suite') ? 'selected' : '' ?>>Suite</option>
                            <option value="Family" <?= ($reg['room_type'] === 'Family') ? 'selected' : '' ?>>Family</option>
                        </select>
                        <p style="color:red;"> <?= $errors['room_type'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="num_guests">Number of Guests</label>
                        <input type="number" name="num_guests" id="num_guests" min="1" value="<?= htmlspecialchars($reg['num_guests']) ?>">
                        <p style="color:red;"> <?= $errors['num_guests'] ?? '' ?> </p>
                    </div>
                    <div class="field">
                        <label for="special_requests">Special Requests</label>
                        <textarea name="special_requests" id="special_requests" rows="2"><?= htmlspecialchars($reg['special_requests']) ?></textarea>
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
                <li>&copy; 2024 Hotel Registration</li>
                <li>All rights reserved</li>
            </ul>
        </div>
    </footer>
</div>
</body>
</html> 