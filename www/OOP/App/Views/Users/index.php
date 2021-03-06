<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Login</title>

		<?php require_once '../App/Views/Elements/head.php' ?>

	</head>
	<body>
		<div class='body-div'>
			<?php require_once '../App/Views/Elements/header.php' ?>

			<!-- message part (Elements/message.php) -->
			<?php require_once '../App/Views/Elements/message.php' ?>

			<div class="login-form">
				<p id="auth-label">Authorisation</p>
				<form id="form" action="/" method="post">
					<div class="field">
						<label for="username" class="login-form-label">Login:</label>
							<input type="text" name="username" class="login-form-input"
								value="<?php echo (isset($username)) ? $username : "";?>" /><br>
						<label for="password" class="login-form-label">Password:</label>
							<input type="password" name="password" class="login-form-input"
								value="<?php echo (isset($password)) ? $password : "";?>" /><br>
					</div>

					<div onClick="document.forms['form'].submit();" id="login-button">
						<div id="login-button-img"></div>
						<p id="login-button-p">Login</p>
					</div>
				</form>
			</div>

			<?php require_once '../App/Views/Elements/footer.php' ?>
		</div>
	</body>
</html>