<?php session_start(); ?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Class Attendance Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="custom-style.css">
    <noscript>
        <link rel="stylesheet" href="custom-style.css" />
    </noscript>
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
                <h1>Class Attendance Form</h1>
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['success'] ?>
                        <?php unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>
                <section>
                    <h2>Record Attendance</h2>
                    <form method="post" action="process.php">
                        <div class="fields">
                            <div class="field half">
                                <input type="text" name="student_name" placeholder="Student Name" value="<?= $_POST['student_name'] ?? '' ?>">
                                <p style="color:red;"><?= $_SESSION["errors"]["student_name"] ?? "" ?></p>
                            </div>
                            <div class="field half">
                                <input type="text" name="student_id" placeholder="Student ID" value="<?= $_POST['student_id'] ?? '' ?>">
                                <p style="color:red;"><?= $_SESSION["errors"]["student_id"] ?? "" ?></p>
                            </div>
                            <div class="field half">
                                <input type="text" name="class" placeholder="Class" value="<?= $_POST['class'] ?? '' ?>">
                                <p style="color:red;"><?= $_SESSION["errors"]["class"] ?? "" ?></p>
                            </div>
                            <div class="field half">
                                <input type="text" name="subject" placeholder="Subject" value="<?= $_POST['subject'] ?? '' ?>">
                                <p style="color:red;"><?= $_SESSION["errors"]["subject"] ?? "" ?></p>
                            </div>
                            <div class="field half">
                                <input type="date" name="date" placeholder="Date" value="<?= $_POST['date'] ?? '' ?>">
                                <p style="color:red;"><?= $_SESSION["errors"]["date"] ?? "" ?></p>
                            </div>
                            <div class="field half">
                                <select name="status">
                                    <option value="">---Select Status---</option>
                                    <option value="Present" <?= ($_POST['status'] ?? '') === 'Present' ? 'selected' : '' ?>>Present</option>
                                    <option value="Absent" <?= ($_POST['status'] ?? '') === 'Absent' ? 'selected' : '' ?>>Absent</option>
                                    <option value="Late" <?= ($_POST['status'] ?? '') === 'Late' ? 'selected' : '' ?>>Late</option>
                                </select>
                                <p style="color:red;"><?= $_SESSION["errors"]["status"] ?? "" ?></p>
                            </div>
                            <div class="field">
                                <input type="text" name="remarks" placeholder="Remarks (Optional)" value="<?= $_POST['remarks'] ?? '' ?>">
                                <p style="color:red;"><?= $_SESSION["errors"]["remarks"] ?? "" ?></p>
                            </div>
                            <div class="field half">
                                <input type="text" name="teacher_name" placeholder="Teacher Name" value="<?= $_POST['teacher_name'] ?? '' ?>">
                                <p style="color:red;"><?= $_SESSION["errors"]["teacher_name"] ?? "" ?></p>
                            </div>
                            <div class="field half">
                                <input type="text" name="period" placeholder="Period" value="<?= $_POST['period'] ?? '' ?>">
                                <p style="color:red;"><?= $_SESSION["errors"]["period"] ?? "" ?></p>
                            </div>
                            <div class="field text-right">
                                <ul class="actions">
                                    <li><input type="submit" value="Record Attendance" class="primary"></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                    <div class="field text-right">
                        <ul class="actions">
                            <button><a href="view.php">View All Attendence</a></button>
                        </ul>
                    </div>
                    <?php if (isset($_SESSION['errors'])) {
                        unset($_SESSION['errors']);
                    } ?>
                </section>
            </div>
        </div>
        <footer id="footer">
            <div class="inner">
            </div>
        </footer>
    </div>
</body>

</html>