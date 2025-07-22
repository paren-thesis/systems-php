<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Class Attendance - Admin View</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="custom-style.css">
</head>
<body>
    <div id="wrapper">
        <header id="header">
            <div class="inner">
                <a href="index.php" class="logo">
                    <span class="fa fa-leaf"></span> <span class="title">CLASS ATTENDANCE</span>
                </a>
            </div>
        </header>
        <div id="main">
            <div class="inner">
                <h1>Class Attendance Records</h1>
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['success'] ?>
                        <?php unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>
                <section>
                    <h2>All Attendance Records</h2>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student Name</th>
                                    <th>Student ID</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Teacher</th>
                                    <th>Period</th>
                                    <th>Recorded At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require_once 'database.php';
                                $db = new Database('localhost', 'root', '', 'class_attendance');
                                $records = $db->getAllAttendance();
                                if ($records && count($records) > 0):
                                    foreach ($records as $rec): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($rec['id']) ?></td>
                                            <td><?= htmlspecialchars($rec['student_name']) ?></td>
                                            <td><?= htmlspecialchars($rec['student_id']) ?></td>
                                            <td><?= htmlspecialchars($rec['class']) ?></td>
                                            <td><?= htmlspecialchars($rec['subject']) ?></td>
                                            <td><?= htmlspecialchars($rec['date']) ?></td>
                                            <td><?= htmlspecialchars($rec['status']) ?></td>
                                            <td><?= htmlspecialchars($rec['remarks']) ?></td>
                                            <td><?= htmlspecialchars($rec['teacher_name']) ?></td>
                                            <td><?= htmlspecialchars($rec['period']) ?></td>
                                            <td><?= htmlspecialchars($rec['recorded_at']) ?></td>
                                            <td>
                                                <a href="update.php?id=<?= $rec['id'] ?>" class="btn btn-sm btn-primary">Update</a>
                                                <a href="process.php?delete=<?= $rec['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                else: ?>
                                    <tr><td colspan="12">No attendance records found.</td></tr>
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
                    <li></li>
                </ul>
            </div>
        </footer>
    </div>
</body>
</html>