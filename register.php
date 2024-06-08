<?php
	include('fungsi.php');
	include('navbar.php');

	if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_retype'])){
		if($_POST['password'] == $_POST['password_retype']){
			$error = registerUser($_POST['username'], md5($_POST['password']));
		}
		else{
			$error = "password tidak sama";
		}
	}
?>

<section class="content container card pt-3" style="width:300px;margin-top:150px">
	<h2>Daftar User</h2>
	<form method="post" action="register.php">
		<div class="text-start">
			<label class="d-block mt-3 form-label">
				Username <input type="text" class="d-block w-100 form-control" name="username" required>
			</label>
			<label class="d-block mt-2 form-label">
				Password <input type="password" class="d-block w-100 form-control" name="password" required>
			</label>
			<label class="d-block mt-2 form-label">
				Retype Password <input type="password" class="d-block w-100 form-control" name="password_retype" required>
			</label>
		</div>
		<div class="text-end">
			<a href="login.php" class="mt-2 btn btn-secondary">Login</a>
			<input class="mt-2 btn btn-danger" type="submit" name="daftar" value="Daftar">
		</div>
	</br>
		<?php if (isset($error)): ?>
			<div class="alert alert-danger" role="alert">
				<?php echo "$error" ?>
			</div>
		<?php endif; ?>
	</form>
</section>