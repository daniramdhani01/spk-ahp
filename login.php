<?php
	include('fungsi.php');
	include('navbar.php');
	$message = isset($_SESSION['alert']) ? $_SESSION['alert'] : '';

	if(isset($_POST['username']) && isset($_POST['password'])){
		$loginError = loginUser($_POST['username'], md5($_POST['password']));
	}
?>

<section class="content container card pt-3" style="width:300px;margin-top:150px">
	<h2>Login</h2>
	<form method="post" action="login.php">
		<div class="text-start">
			<label class="d-block mt-3 form-label">
				Username <input type="text" class="d-block w-100 form-control" name="username" required>
			</label>
			<label class="d-block mt-2 form-label">
				Password <input type="password" class="d-block w-100 form-control" name="password" required>
			</label>
		</div>
		<div class="text-end">
			<a href="register.php" class="mt-2 btn btn-secondary">Daftar</a>
			<input class="mt-2 btn btn-danger" type="submit" name="login" value="Login">
		</div>
		</br>
		<?php if (isset($loginError) && $loginError): ?>
				<div class="alert alert-danger" role="alert">
					Username atau password salah.
				</div>
		<?php endif; ?>

		<?php if ($message): ?>
				<div class="alert alert-success" role="alert">
					<?php echo "$message" ?>
					<?php unset($_SESSION['alert']); ?>
				</div>
		<?php endif; ?>
	</form>
</section>