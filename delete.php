<?php
session_start();
require_once 'database.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $db = new Database('localhost', 'root', '', 'bus_ticket_booking');
    $result = $db->deleteTicket($id);
    if ($result === true) {
        $_SESSION['success'] = 'Ticket deleted successfully!';
    } else {
        $_SESSION['success'] = 'Failed to delete ticket: ' . $result;
    }
}
header('Location: viewbooking.php');
exit; 