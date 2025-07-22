<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Hotel Registration System</title>
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
                    <li><a href="viewbooking.php">View Registrations</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div id="main">
        <div class="inner">
            <h1>Hotel Registration Form</h1>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success'] ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            <section>
                <form method="post" action="process.php">
                    <div class="fields">
                        <div class="field">
                            <label for="full_name">Full Name</label>
                            <input type="text" name="full_name" id="full_name" value="<?= $_SESSION['old']['full_name'] ?? '' ?>">
                            <p style="color:red;"> <?= $_SESSION['errors']['full_name'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="<?= $_SESSION['old']['email'] ?? '' ?>">
                            <p style="color:red;"> <?= $_SESSION['errors']['email'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" value="<?= $_SESSION['old']['phone'] ?? '' ?>">
                            <p style="color:red;"> <?= $_SESSION['errors']['phone'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" value="<?= $_SESSION['old']['address'] ?? '' ?>">
                            <p style="color:red;"> <?= $_SESSION['errors']['address'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="check_in_date">Check-in Date</label>
                            <input type="date" name="check_in_date" id="check_in_date" value="<?= $_SESSION['old']['check_in_date'] ?? '' ?>">
                            <p style="color:red;"> <?= $_SESSION['errors']['check_in_date'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="check_out_date">Check-out Date</label>
                            <input type="date" name="check_out_date" id="check_out_date" value="<?= $_SESSION['old']['check_out_date'] ?? '' ?>">
                            <p style="color:red;"> <?= $_SESSION['errors']['check_out_date'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="room_type">Room Type</label>
                            <select name="room_type" id="room_type">
                                <option value="">---Select Room Type---</option>
                                <option value="Single" <?= (($_SESSION['old']['room_type'] ?? '') === 'Single') ? 'selected' : '' ?>>Single</option>
                                <option value="Double" <?= (($_SESSION['old']['room_type'] ?? '') === 'Double') ? 'selected' : '' ?>>Double</option>
                                <option value="Suite" <?= (($_SESSION['old']['room_type'] ?? '') === 'Suite') ? 'selected' : '' ?>>Suite</option>
                                <option value="Family" <?= (($_SESSION['old']['room_type'] ?? '') === 'Family') ? 'selected' : '' ?>>Family</option>
                            </select>
                            <p style="color:red;"> <?= $_SESSION['errors']['room_type'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="num_guests">Number of Guests</label>
                            <input type="number" name="num_guests" id="num_guests" min="1" value="<?= $_SESSION['old']['num_guests'] ?? '' ?>">
                            <p style="color:red;"> <?= $_SESSION['errors']['num_guests'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="special_requests">Special Requests</label>
                            <textarea name="special_requests" id="special_requests" rows="2"><?= $_SESSION['old']['special_requests'] ?? '' ?></textarea>
                        </div>
                    </div>
                    <div class="field text-right">
                        <ul class="actions">
                            <li><input type="submit" value="Register" class="primary"></li>
                        </ul>
                    </div>
                </form>
                <?php if (isset($_SESSION['errors'])) unset($_SESSION['errors']); ?>
                <?php if (isset($_SESSION['old'])) unset($_SESSION['old']); ?>
            </section>
        </div>
    </div>
    <!-- <footer id="footer">
        <div class="inner">
            <ul class="copyright">
                <li>&copy; 2024 Hotel Registration</li>
                <li>All rights reserved</li>
            </ul>
        </div>
    </footer> -->
</div>
</body>
</html>