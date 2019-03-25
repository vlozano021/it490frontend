<?php 
session_start();
require_once 'RPC.php';
use rabbit\RPC;

if(!empty($_POST)){
	$login_rpc = new RPC("login");
	$user = $_POST['loginUN'];
	$usernamepasswd = serialize(array($user, $_POST['loginPW']));

	$response = $login_rpc->call($usernamepasswd);
	if ($response==='S'){
		$_SESSION['username'] = $user;
		header('Location: index.php');
	} else {
		header('Location: login.php?success=F');
	}
}

if (isset($_GET['success']) && $_GET['success'] === 'F') {
	echo "<script type='text/javascript'>alert('Failed to Log In! Try Again.');</script>";
}
?>

<?php include 'header.php' ?>

<div class="uaBody">
	<div class="Content">
		<h1>Log In</h1>
		<form action="" method="POST">
			<h4>Username:</h4>
			<input type="text" name="loginUN" required>
			<h4>Password:</h4>
			<input type="password" name="loginPW" required>
			<br><br>
			Don't have an account? <a href="signup.html">Sign Up</a><br><br>
			<input type="submit" name="loginSubmit" value="Log In">
		</form>
	</div>
</div>


<?php include 'footer.php' ?>
