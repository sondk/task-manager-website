<?php
    require_once "config.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($stmt = $con->prepare('SELECT id FROM accounts WHERE username=?')) {
            $stmt->bind_param('s', $_POST['username']);
			$stmt->execute();
            $stmt->store_result();
            
            if ($stmt->num_rows > 0) {
                echo "This username is already taken.";
                $stmt->close();
            } else {
                if (strlen(trim($_POST["password"])) < 6) {
                    echo "Password must have atleast 6 characters.";
                } else if (trim($_POST["password"] != trim($_POST['confirm_password']))) {
                    echo "Password did not match.";
                } else {
                    if ($stmt = $con->prepare('INSERT INTO accounts (username,password) VALUES (?,?)')) {
                        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
                        
                        $param_username = $_POST["username"];
                        $param_password = $_POST["password"];
                        if ($stmt->execute()) {
                            header("location: login.php");
                        } else {
                            echo "Something went wrong. Please try again later.";
                        }
                        $stmt->close();
                    }
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sign Up</title>
		<link rel="stylesheet" href="style.css" type="text/css">
	</head>
	<body>
		<div class="login">
			<h1>Sign Up</h1>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                </div>
                <div class="container">
                  <label><b>Username</b></label>
                  <input type="text" placeholder="Username" name="username" required>
                  <label><b>Password</b></label>
                  <input type="password" placeholder="Password" name="password" required>
                  <label><b>Confirm password</b></label>
                  <input type="password" placeholder="Confirm Password" name="confirm_password" required>
                  <button type="submit">Sign Up</button>
				  <p>Already have an account? <a href="login.php">Login here</a>.</p>
                </div>
            </form>
		</div>
	</body>
</html>