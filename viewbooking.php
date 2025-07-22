<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Hotel Registrations - Admin View</title>
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
                    <li><a href="index.php">Back to Registration Form</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div id="main">
        <div class="inner">
            <h1>Hotel Registrations</h1>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success'] ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            <section>
                <h2>All Registrations</h2>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Room Type</th>
                                <th>Guests</th>
                                <th>Special Requests</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        require_once 'database.php';
                        $db = new Database('localhost', 'root', '', 'hotel_registration');
                        $registrations = $db->getAllRegistrations();
                        if ($registrations && count($registrations) > 0):
                            foreach ($registrations as $reg): ?>
                                <tr>
                                    <td><?= htmlspecialchars($reg['id']) ?></td>
                                    <td><?= htmlspecialchars($reg['full_name']) ?></td>
                                    <td><?= htmlspecialchars($reg['email']) ?></td>
                                    <td><?= htmlspecialchars($reg['phone']) ?></td>
                                    <td><?= htmlspecialchars($reg['address']) ?></td>
                                    <td><?= htmlspecialchars($reg['check_in_date']) ?></td>
                                    <td><?= htmlspecialchars($reg['check_out_date']) ?></td>
                                    <td><?= htmlspecialchars($reg['room_type']) ?></td>
                                    <td><?= htmlspecialchars($reg['num_guests']) ?></td>
                                    <td><?= htmlspecialchars($reg['special_requests'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($reg['created_at']) ?></td>
                                    <td>
                                        <a href="update.php?id=<?= $reg['id'] ?>" class="btn btn-edit">Edit</a>
                                        <form method="post" action="delete.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this registration?');">
                                            <input type="hidden" name="id" value="<?= $reg['id'] ?>">
                                            <button type="submit" class="btn btn-delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr><td colspan="12">No registrations found.</td></tr>
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
                <li>&copy; 2024 Hotel Registration</li>
                <li>All rights reserved</li>
            </ul>
        </div>
    </footer>
</div>
</body>
</html>