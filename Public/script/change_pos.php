<?php
@session_start();
$_SESSION['pos']=$_POST['pos_id'];
unset($_SESSION['jour']);
?>