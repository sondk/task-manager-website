<?php
	session_start();

	require_once "config.php";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if ($stmt = $con->prepare('SELECT id,password FROM accounts WHERE username=?')) {
			$stmt->bind_param('s', $_POST['username']);
			$stmt->execute();
			$stmt->store_result();
			
			if ($stmt->num_rows > 0) {
				$stmt->bind_result($id, $password);
				$stmt->fetch();

				if ($_POST['password'] === $password) {
					session_regenerate_id();
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['name'] = $_POST['username'];
					$_SESSION['id'] = $id;
					header("location: task_manager.php");
				} else {
					echo "Incorrect password";
				}
			} else {
				echo "Incorrect username";
			}
			$stmt->close();
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="style.css" type="text/css">
	</head>
	<body>
		<div class="login">
			<h1>Login</h1>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                </div>
                <div class="container">
                  <label><b>Username</b></label>
                  <input type="text" placeholder="Username" name="username" required>
                  <label><b>Password</b></label>
                  <input type="password" placeholder="Password" name="password" required>
                  <button type="submit">Login</button>
				  <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
                </div>
            </form>
		</div>
	</body>
</html>