<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Bus Tickets - Admin View</title>
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
                    <li><a href="index.php">Back to Booking Form</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div id="main">
        <div class="inner">
            <h1>Bus Tickets</h1>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success'] ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            <section>
                <h2>All Tickets</h2>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Travel Date</th>
                                <th>Payment Method</th>
                                <th>Departure</th>
                                <th>Destination</th>
                                <th>Tickets</th>
                                <th>Departure Time</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        require_once 'database.php';
                        $db = new Database('localhost', 'root', '', 'bus_ticket_booking');
                        $tickets = $db->getAllTickets();
                        if ($tickets && count($tickets) > 0):
                            foreach ($tickets as $ticket): ?>
                                <tr>
                                    <td><?= htmlspecialchars($ticket['id']) ?></td>
                                    <td><?= htmlspecialchars($ticket['name']) ?></td>
                                    <td><?= htmlspecialchars($ticket['email']) ?></td>
                                    <td><?= htmlspecialchars($ticket['age']) ?></td>
                                    <td><?= htmlspecialchars($ticket['gender']) ?></td>
                                    <td><?= htmlspecialchars($ticket['travel_date']) ?></td>
                                    <td><?= htmlspecialchars($ticket['payment_method']) ?></td>
                                    <td><?= htmlspecialchars($ticket['departure_location']) ?></td>
                                    <td><?= htmlspecialchars($ticket['destination_location']) ?></td>
                                    <td><?= htmlspecialchars($ticket['number_of_tickets']) ?></td>
                                    <td><?= htmlspecialchars($ticket['departure_time']) ?></td>
                                    <td><?= htmlspecialchars($ticket['created_at']) ?></td>
                                    <td>
                                        <a href="update.php?id=<?= $ticket['id'] ?>" class="btn btn-edit">Edit</a>
                                        <form method="post" action="delete.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                                            <input type="hidden" name="id" value="<?= $ticket['id'] ?>">
                                            <button type="submit" class="btn btn-delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr><td colspan="13">No tickets found.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
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