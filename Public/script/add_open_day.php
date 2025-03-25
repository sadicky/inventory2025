<?php
session_start();
require_once('../../Models/Admin/journal.class.php');
require_once('../../Models/Admin/transaction.class.php');
$jours = new Journal();
$transactions = new Transactions();

// var_dump($_POST);die();
$posId = $_SESSION['pos'];

if (!isset($_SESSION['jour'])) {
    $openBal = (int)str_replace(',', '', $_POST['open_bal']);
    $user_id = $_SESSION['id'];
    $startDate = $_POST['open_date'];

    unset($_SESSION['last_jour']);
    $_SESSION['jour'] = $jours->insert($user_id, $posId, $openBal, $startDate);
} else {
    $closing_cash = (int)str_replace(',', '', $_POST['closing_cash']);
    $closingBal = $transactions->select_bal_jour($_SESSION['jour']);
    $jours->close_day($_SESSION['id'], $closingBal, $closing_cash);
    $_SESSION['last_jour'] = $_SESSION['jour'];
    unset($_SESSION['jour']);
}
