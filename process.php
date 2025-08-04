<?php

session_start();
require_once("database.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_SESSION["errors"])) {
        $_SESSION["errors"] = [];
    }

    $student_name = trim($_POST['student_name']);
    $student_id = trim($_POST['student_id']);
    $class = trim($_POST['class']);
    $subject = trim($_POST['subject']);
    $date = trim($_POST['date']);
    $status = trim($_POST['status']);
    $remarks = trim($_POST['remarks']);
    $teacher_name = trim($_POST['teacher_name']);
    $period = trim($_POST['period']);

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


    if (empty($_SESSION["errors"])) {
        $db = new Database("localhost", "root", "", "class_attendance");
        if ($db->storeAttendance($student_name, $student_id, $class, $subject, $date, $status, $remarks, $teacher_name, $period)) {

            unset($_SESSION["errors"]);
            $_SESSION["success"] = "Attendance recorded successfully!";
            header("Location: index.php");
            exit;
        } else {
            $_SESSION["errors"]["general"] = "Failed to record attendance. Please try again.";
            header("Location: index.php");
            exit;
        }
    } else {
        header("Location: index.php");
        exit;
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $db = new Database("localhost", "root", "", "class_attendance");
    if ($db->deleteAttendance($id)) {
        $_SESSION['success'] = "Attendance record deleted successfully!";
    } else {
        $_SESSION['errors']['general'] = "Failed to delete attendance record.";
    }
    header("Location: view.php");
    exit;
}
