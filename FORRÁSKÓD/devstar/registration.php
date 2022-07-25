<?php 
	header('Content-type: text/html; charset=utf-8');
	session_start();

	require_once 'classes/users_class.php';
	use classes\Users;

	if (empty($_SESSION['level'])) {

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			if(isset($_POST['registration'])){

				Users::userRegistration(Users::testInput($_POST['username']), Users::testInput($_POST['email']), md5($_POST['password']), md5($_POST['confirmpassword']), 'pictures/user_avatar/' . $_FILES['avatar']['name'], $_FILES['avatar']['type'], $_FILES['avatar']['tmp_name']);
			}

			if (isset($_POST['username']) && isset($_POST['email'])) {
				$username = $_POST['username'];
				$email = $_POST['email'];
			}
		}
		else{
			$_SESSION['registration_message'] = "";
			$username = "";
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
	<title>Create new account - Devstar</title>
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
	    	<div class="h1 text-center">Create an account</div>
	    </div>

  		<form method="post" autocomplete="off" enctype="multipart/form-data">
		  	<div class="m-2">
			    <div class="row">
			      	<div class="col-12 form-group">
			        	<div class="alert alert-link text-center text-danger"><?php echo($_SESSION['registration_message']); ?></div>
			      	</div>
			    </div>

			    <div class="row">
			      	<div class="col-sm-6 offset-sm-3 col-lg-4 offset-lg-4 form-group">
			        	<input class="form-control" id="username" type="text" name="username" placeholder="Username" minlength="2" maxlength="12" value="<?php echo $username ?>" required>
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
			      	<div class="col-sm-6 offset-sm-3 col-lg-4 offset-lg-4 form-group">
			        	<input class="form-control" type="password" name="confirmpassword" placeholder="Password again" minlength="6" maxlength="15" required>
			      	</div>
			    </div>

			    <div class="row">
			      	<div class="col-sm-6 offset-sm-3 col-lg-4 offset-lg-4 form-group">
			        	<p>Select your avatar:</p><input type="file" name="avatar" accept="image/*">
			      	</div>
			    </div>

			    <div class="row">
			    	<input class="btn btn-primary col-sm-4 offset-sm-4 mt-4" type="submit" name="registration" value="Sign up">
					<div class="mt-3 mt-sm-5 ml-3"> or <a href="login.php">Login</a></div>
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