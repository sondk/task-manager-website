<?php
    session_start();

    require_once "config.php";

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       if ($stmt = $con->prepare('INSERT INTO tasks (id,title) VALUES (?,?)')) {
        mysqli_stmt_bind_param($stmt, "ss", $param_id, $param_title);

        $param_id = $_SESSION['id'];
        $param_title = $_POST['task'];
        if ($stmt->execute()) {
            header("location: task_manager.php");
            exit;
        }
       }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Task Manager</title>
        <link rel="stylesheet" href="task_style.css" type="text/css">
    </head>
    <body>
        <h2>Hi, <?php echo $_SESSION['name'] ?></h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label><b>Task</b></label>
            <br>
            <input type="text" placeholder="" name="task">
            <br>
            <button type="submit">Add Task</button>
            <br>
        </form>
        <br>
        <label>Current Tasks</label>
        <br>
        <hr>
        <label><b>Task</b></label>
        <br>
        <table>
        <?php
            if ($stmt = $con->prepare('SELECT taks_id,title FROM tasks WHERE id=?')) {
                $stmt->bind_param('s', $_SESSION['id']);
                $stmt->execute();
                $result = $stmt->store_result();
                $stmt->bind_result($taks_id, $title);
                if ($stmt->num_rows > 0) {
                    while ($stmt->fetch()) {
                        echo "<tr><td>" . $title . "</td><td><a href=\"task_delete.php?task_id=" . $taks_id ."\">Delete</a></td></tr>";
                    }
                }
                $stmt->close();
            }
        ?>
        </table>
    </body>
</html>
