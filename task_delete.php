<?php
    session_start();
    require_once "config.php";

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    if ($stmt = $con->prepare('DELETE FROM tasks WHERE taks_id=?')) {
        $stmt->bind_param('i', $_GET['task_id']);
        $stmt->execute();
        $stmt->close();
    }
    
    header("location: task_manager.php");
?>