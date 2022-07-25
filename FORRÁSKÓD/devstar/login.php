<?php 
	header('Content-type: text/html; charset=utf-8');
	session_start();

	require_once 'classes/users_class.php';
	use classes\Users;

	if (empty($_SESSION['level'])) {

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			if (isset($_POST['login'])) {

				Users::userLogin(Users::testInput($_POST['email']),md5($_POST['password']));
			}

			if (isset($_POST['email'])) {
				$email = $_POST['email'];
			}
		}
		else{
			$_SESSION['login_message'] = "";
			$email = "";
		}
	}
	else{
		header('location: index.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login - Devstar</title>
	<?php include 'include/head.php'; ?>
</head>
<body>
	<header>
		<?php include 'include/header.php'; ?>
	</header>

	<nav>
		<?php include 'include/navigation.php'; ?>
	</nav>


	<div class="container-fluid container-xl p-0">
	<div class="content text-center px-0 px-lg-5 col-xl-12">
	<div class="d-flex align-items-center min-vh-100">
	<div class="container-fluid">
	    <div class="text-center">
	    	<div class="h1 text-center">Login</div>
	    </div>

		<form method="post" autocomplete="off">
			<div class="m-2">

				<div class="row">
			      	<div class="col-12 form-group">
			        	<div class="alert alert-link text-center text-danger"><?php echo($_SESSION['login_message']); ?></div>
			      	</div>
			    </div>

				<div class="row">
			      	<div class="col-sm-6 offset-sm-3 col-lg-4 offset-lg-4 form-group">
			        	<input class="form-control" type="email" name="email" placeholder="Email" maxlength="40" value="<?php echo $email ?>" required>
			      	</div>
			    </div>

				<div class="row">
			      	<div class="col-sm-6 offset-sm-3 col-lg-4 offset-lg-4 form-group">
			        	<input class="form-control" type="password" name="password" placeholder="Password" minlength="6" maxlength="15" required>
			      	</div>
			    </div>
				<div class="row">
			    	<input class="btn btn-primary col-sm-4 offset-sm-4 mt-4" type="submit" name="login" value="Login">
					<div class="mt-3 mt-sm-5 ml-3"> or <a href="registration.php">Sign up</a></div>
				</div>

			</div>
		</form>

	</div>
	</div>
	</div>
	</div>

	<footer>
		<?php include 'include/footer.php'; ?>
	</footer>

</body>
</html>