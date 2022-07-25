	<?php

	require_once 'classes/users_class.php';
	use classes\Users;

	require_once 'classes/navigation_class.php';
	use classes\Navigation;
 

	$result_folder = Navigation::setCookiePath();

	if ($result_folder == '/') {
		$cookie_path = "../" . $conn_username; // online eléréshez - nincs mappa név (/)
	}
	else{
		$cookie_path = "../" . $result_folder; // helyi eléréshez - dinamikus mappa név
	}

	?>

	<script>
		function news_selected() {
			Cookies.set('category_id', 1, { path: '<?php echo $cookie_path ?>' });
			location.reload();
		}

		function games_selected() {
			Cookies.set('category_id', 2, { path: '<?php echo $cookie_path ?>' });
			location.reload();
		}

		function assets_selected() {
			Cookies.set('category_id', 3, { path: '<?php echo $cookie_path ?>' });
			location.reload();
		}
	</script>

	<?php

	if (isset($_SESSION['level'])) {

		if ($_SESSION['level'] == 5) { ?>

			<div class="container-fluid container-xl p-0">
				<nav class="navbar navbar-dark bg-dark navbar-expand-md col-xl-12">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
	        		<span class="navbar-toggler-icon"></span>
	      			</button>
	      			<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="navbar-nav mr-sm-auto">

						<li class="nav-item dropdown">
					        <a class="nav-link dropdown-toggle" data-toggle="dropdown">Admin</a>
					        <div class="dropdown-menu">
								<a class="dropdown-item disabled" href="#">Statistics</a>
								<a class="dropdown-item" href="admin_users.php">Users</a>
								<a class="dropdown-item" href="admin_contents.php">Contents</a>
								<a class="dropdown-item disabled" href="#">Feedback</a>
					        </div>
					    </li>
						<li class="nav-item">
							<a class="nav-link" href="index.php">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="content_category.php" onclick="news_selected()">News</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="content_category.php" onclick="games_selected()">Games</a>
						</li>
					    <li class="nav-item">
							<a class="nav-link" href="content_category.php" onclick="assets_selected()">Assets</a>
						</li>
						<li class="nav-item">
							<a class="nav-link disabled" href="#">Discord</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="https://www.paypal.com/paypalme/BalintHracza/1" target="_blank">Buy me a coffee</a>
						</li>
					</ul>
					</div>

					<div class="dropdown">
						<button class="btn btn-secondary dropdown-toggle py-1" data-toggle="dropdown">
							<span><?php echo $_SESSION['username']; ?></span>
							<img class="profile_picture" src="<?php echo $_SESSION['avatar']; ?>" />
						</button>
						<div class="dropdown-menu dropdown-menu-right">
						  	<a class="dropdown-item disabled" href="#">Profile</a>
						  	<a class="dropdown-item" href="inventory.php">Inventory</a>
						  	<div class="dropdown-divider"></div>
						  	<a class="dropdown-item" href="logout.php">Logout</a>
						</div>
					</div>
				</nav>
			</div>
			<?php
		}
		else if ($_SESSION['level'] >= 2 && $_SESSION['level'] <= 4){ ?>

			<div class="container-fluid container-xl p-0">
				<nav class="navbar navbar-dark bg-dark navbar-expand-md col-xl-12">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
	        		<span class="navbar-toggler-icon"></span>
	      			</button>
	      			<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="navbar-nav mr-sm-auto">
						<li class="nav-item">
							<a class="nav-link" href="index.php">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="content_category.php" onclick="news_selected()">News</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="content_category.php" onclick="games_selected()">Games</a>
						</li>
					    <li class="nav-item">
							<a class="nav-link" href="content_category.php" onclick="assets_selected()">Assets</a>
						</li>
						<li class="nav-item">
							<a class="nav-link disabled" href="#">Discord</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="https://www.paypal.com/paypalme/BalintHracza/1" target="_blank">Buy me a coffee</a>
						</li>
					</ul>
					</div>

					<div class="dropdown">
						<button class="btn btn-secondary dropdown-toggle py-1" data-toggle="dropdown">
							<span><?php echo $_SESSION['username']; ?></span>
							<img class="profile_picture" src="<?php echo $_SESSION['avatar']; ?>" />
						</button>
						<div class="dropdown-menu">
						  	<a class="dropdown-item disabled" href="#">Profile</a>
						  	<a class="dropdown-item" href="inventory.php">Inventory</a>
						  	<div class="dropdown-divider"></div>
						  	<a class="dropdown-item" href="logout.php">Logout</a>
						</div>
					</div>
				</nav>
			</div>
			<?php
		}
		else if ($_SESSION['level'] == 1) {
			header('location: logout.php');
		}
		else{
			header('location: logout.php');
		}
	}
		
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
		} ?>

		<div class="container-fluid container-xl p-0">
			<nav class="navbar navbar-dark bg-dark navbar-expand-md col-xl-12">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
	        	<span class="navbar-toggler-icon"></span>
	      		</button>
	      		<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav mr-sm-auto">
					<li class="nav-item">
						<a class="nav-link" href="index.php">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="content_category.php" onclick="news_selected()">News</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="content_category.php" onclick="games_selected()">Games</a>
					</li>
					   <li class="nav-item">
						<a class="nav-link" href="content_category.php" onclick="assets_selected()">Assets</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Discord</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="https://www.paypal.com/paypalme/BalintHracza/1" target="_blank">Buy me a coffee</a>
					</li>
				</ul>
				</div>
				<ul class="navbar-nav ml-sm-auto">
					<form method="post" autocomplete="off">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown">Login</a>
						<div class="dropdown-menu dropdown-menu-right p-3" style="width: 250px; max-width: 250px;">
							<div class="form-group">
								<div class="alert alert-link text-center text-danger"><?php echo($_SESSION['login_message']); ?></div>
							</div>
							<div class="form-group">
								<span>Email</span>
								<input class="form-control" type="email" name="email" maxlength="40" value="<?php echo $email ?>" required>
							</div>
							<div class="form-group">
								<span>Password</span>
								<input class="form-control" type="password" name="password" minlength="6" maxlength="15" required>
							</div>
							<div>
								<input class="form-control bg-secondary text-white" type="submit" name="login" value="Login">
							</div>
						</div>
					</li>
					</form>
					<li>
						<div class="nav-item">
							<a class="nav-link bg-danger text-light rounded" href="registration.php">Sign up</a>
						</div>
					</li>
				</ul>
			</nav>
			
		</div>
		<?php
	} ?>