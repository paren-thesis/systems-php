<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Bus Ticket Booking System</title>
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
                    <li><a href="viewbooking.php">View Tickets</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div id="main">
        <div class="inner">
            <h1>Bus Ticket Booking Form</h1>
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
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="<?= $_SESSION['old']['name'] ?? '' ?>">
                            <p style="color:red;"> <?= $_SESSION['errors']['name'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="<?= $_SESSION['old']['email'] ?? '' ?>">
                            <p style="color:red;"> <?= $_SESSION['errors']['email'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="age">Age</label>
                            <input type="number" name="age" id="age" min="1" value="<?= $_SESSION['old']['age'] ?? '' ?>">
                            <p style="color:red;"> <?= $_SESSION['errors']['age'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender">
                                <option value="">---Select Gender---</option>
                                <option value="Male" <?= (($_SESSION['old']['gender'] ?? '') === 'Male') ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= (($_SESSION['old']['gender'] ?? '') === 'Female') ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= (($_SESSION['old']['gender'] ?? '') === 'Other') ? 'selected' : '' ?>>Other</option>
                            </select>
                            <p style="color:red;"> <?= $_SESSION['errors']['gender'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="travel_date">Travel Date</label>
                            <input type="date" name="travel_date" id="travel_date" value="<?= $_SESSION['old']['travel_date'] ?? '' ?>">
                            <p style="color:red;"> <?= $_SESSION['errors']['travel_date'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="payment_method">Payment Method</label>
                            <select name="payment_method" id="payment_method">
                                <option value="">---Select Payment Method---</option>
                                <option value="Cash" <?= (($_SESSION['old']['payment_method'] ?? '') === 'Cash') ? 'selected' : '' ?>>Cash</option>
                                <option value="Card" <?= (($_SESSION['old']['payment_method'] ?? '') === 'Card') ? 'selected' : '' ?>>Card</option>
                                <option value="Mobile Money" <?= (($_SESSION['old']['payment_method'] ?? '') === 'Mobile Money') ? 'selected' : '' ?>>Mobile Money</option>
                            </select>
                            <p style="color:red;"> <?= $_SESSION['errors']['payment_method'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="departure_location">Departure Location</label>
                            <input type="text" name="departure_location" id="departure_location" value="<?= $_SESSION['old']['departure_location'] ?? '' ?>">
                            <p style="color:red;"> <?= $_SESSION['errors']['departure_location'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="destination_location">Destination Location</label>
                            <input type="text" name="destination_location" id="destination_location" value="<?= $_SESSION['old']['destination_location'] ?? '' ?>">
                            <p style="color:red;"> <?= $_SESSION['errors']['destination_location'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="number_of_tickets">Number of Tickets</label>
                            <input type="number" name="number_of_tickets" id="number_of_tickets" min="1" value="<?= $_SESSION['old']['number_of_tickets'] ?? '' ?>">
                            <p style="color:red;"> <?= $_SESSION['errors']['number_of_tickets'] ?? '' ?> </p>
                        </div>
                        <div class="field">
                            <label for="departure_time">Departure Time</label>
                            <input type="time" name="departure_time" id="departure_time" value="<?= $_SESSION['old']['departure_time'] ?? '' ?>">
                            <p style="color:red;"> <?= $_SESSION['errors']['departure_time'] ?? '' ?> </p>
                        </div>
                    </div>
                    <div class="field text-right">
                        <ul class="actions">
                            <li><input type="submit" value="Book Ticket" class="primary"></li>
                        </ul>
                    </div>
                </form>
                <?php if (isset($_SESSION['errors'])) unset($_SESSION['errors']); ?>
                <?php if (isset($_SESSION['old'])) unset($_SESSION['old']); ?>
            </section>
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