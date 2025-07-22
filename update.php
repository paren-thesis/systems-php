<?php
session_start();
require_once("database.php");
$db = new Database("localhost", "root", "", "class_attendance");

if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit;
}
$id = intval($_GET['id']);
$record = $db->getAttendanceById($id);
if (!$record) {
    $_SESSION['errors']['general'] = "Record not found.";
    header("Location: view.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_name = trim($_POST['student_name']);
    $student_id = trim($_POST['student_id']);
    $class = trim($_POST['class']);
    $subject = trim($_POST['subject']);
    $date = trim($_POST['date']);
    $status = trim($_POST['status']);
    $remarks = trim($_POST['remarks']);
    $teacher_name = trim($_POST['teacher_name']);
    $period = trim($_POST['period']);
    $_SESSION['errors'] = [];
    if (empty($student_name)) {
        $_SESSION["errors"]["student_name"] = "Student name is required";
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $student_name)) {
        $_SESSION["errors"]["student_name"] = "Name must contain only letters and spaces";
    }
    if (empty($student_id)) {
        $_SESSION["errors"]["student_id"] = "Student ID is required";
    } elseif (!preg_match('/^[A-Za-z0-9\-]+$/', $student_id)) {
        $_SESSION["errors"]["student_id"] = "Invalid Student ID format";
    }
    if (empty($class)) {
        $_SESSION["errors"]["class"] = "Class is required";
    }
    if (empty($subject)) {
        $_SESSION["errors"]["subject"] = "Subject is required";
    }
    if (empty($date)) {
        $_SESSION["errors"]["date"] = "Date is required";
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        $_SESSION["errors"]["date"] = "Invalid date format";
    }
    if (empty($status)) {
        $_SESSION["errors"]["status"] = "Status is required";
    } elseif (!in_array($status, ['Present', 'Absent', 'Late'])) {
        $_SESSION["errors"]["status"] = "Invalid status";
    }
    if (!empty($remarks) && strlen($remarks) > 255) {
        $_SESSION["errors"]["remarks"] = "Remarks too long";
    }
    if (empty($teacher_name)) {
        $_SESSION["errors"]["teacher_name"] = "Teacher name is required";
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $teacher_name)) {
        $_SESSION["errors"]["teacher_name"] = "Teacher name must contain only letters and spaces";
    }
    if (empty($period)) {
        $_SESSION["errors"]["period"] = "Period is required";
    }
    if (empty($_SESSION['errors'])) {
        if ($db->updateAttendance($id, $student_name, $student_id, $class, $subject, $date, $status, $remarks, $teacher_name, $period)) {
            $_SESSION['success'] = "Attendance record updated successfully!";
            header("Location: view.php");
            exit;
        } else {
            $_SESSION['errors']['general'] = "Failed to update attendance record.";
        }
    }
    $record = [
        'id' => $id,
        'student_name' => $student_name,
        'student_id' => $student_id,
        'class' => $class,
        'subject' => $subject,
        'date' => $date,
        'status' => $status,
        'remarks' => $remarks,
        'teacher_name' => $teacher_name,
        'period' => $period
    ];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Update Attendance Record</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="custom-style.css">
    <noscript><link rel="stylesheet" href="custom-style.css" /></noscript>
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
                <h1>Update Attendance Record</h1>
                <?php if (isset($_SESSION['errors']['general'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['errors']['general'] ?>
                        <?php unset($_SESSION['errors']['general']); ?>
                    </div>
                <?php endif; ?>
                <form method="post">
                    <div class="fields">
                        <div class="field half">
                            <input type="text" name="student_name" placeholder="Student Name" value="<?= htmlspecialchars($record['student_name']) ?>">
                            <p style="color:red;"><?= $_SESSION["errors"]["student_name"] ?? "" ?></p>
                        </div>
                        <div class="field half">
                            <input type="text" name="student_id" placeholder="Student ID" value="<?= htmlspecialchars($record['student_id']) ?>">
                            <p style="color:red;"><?= $_SESSION["errors"]["student_id"] ?? "" ?></p>
                        </div>
                        <div class="field half">
                            <input type="text" name="class" placeholder="Class" value="<?= htmlspecialchars($record['class']) ?>">
                            <p style="color:red;"><?= $_SESSION["errors"]["class"] ?? "" ?></p>
                        </div>
                        <div class="field half">
                            <input type="text" name="subject" placeholder="Subject" value="<?= htmlspecialchars($record['subject']) ?>">
                            <p style="color:red;"><?= $_SESSION["errors"]["subject"] ?? "" ?></p>
                        </div>
                        <div class="field half">
                            <input type="date" name="date" placeholder="Date" value="<?= htmlspecialchars($record['date']) ?>">
                            <p style="color:red;"><?= $_SESSION["errors"]["date"] ?? "" ?></p>
                        </div>
                        <div class="field half">
                            <select name="status">
                                <option value="">---Select Status---</option>
                                <option value="Present" <?= ($record['status'] === 'Present') ? 'selected' : '' ?>>Present</option>
                                <option value="Absent" <?= ($record['status'] === 'Absent') ? 'selected' : '' ?>>Absent</option>
                                <option value="Late" <?= ($record['status'] === 'Late') ? 'selected' : '' ?>>Late</option>
                            </select>
                            <p style="color:red;"><?= $_SESSION["errors"]["status"] ?? "" ?></p>
                        </div>
                        <div class="field">
                            <input type="text" name="remarks" placeholder="Remarks (Optional)" value="<?= htmlspecialchars($record['remarks']) ?>">
                            <p style="color:red;"><?= $_SESSION["errors"]["remarks"] ?? "" ?></p>
                        </div>
                        <div class="field half">
                            <input type="text" name="teacher_name" placeholder="Teacher Name" value="<?= htmlspecialchars($record['teacher_name']) ?>">
                            <p style="color:red;"><?= $_SESSION["errors"]["teacher_name"] ?? "" ?></p>
                        </div>
                        <div class="field half">
                            <input type="text" name="period" placeholder="Period" value="<?= htmlspecialchars($record['period']) ?>">
                            <p style="color:red;"><?= $_SESSION["errors"]["period"] ?? "" ?></p>
                        </div>
                        <div class="field text-right">
                            <ul class="actions">
                                <li><input type="submit" value="Update Record" class="primary"></li>
                                <li><a href="view.php" class="button">Cancel</a></li>
                            </ul>
                        </div>
                    </div>
                </form>
                <?php if (isset($_SESSION['errors'])) { unset($_SESSION['errors']); } ?>
            </div>
        </div>
        <footer id="footer">
            <div class="inner">
            </div>
        </footer>
    </div>
</body>
</html> 