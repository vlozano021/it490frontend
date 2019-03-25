<?php
session_start();
require_once 'RPC.php';
use rabbit\RPC;

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
}

if (!isset($_GET['load'])) {
	$user_rpc = new RPC("getCharacters");
	$rpc_request = serialize(array("getCharacters", $_SESSION['username']));
	$response = $user_rpc->call($rpc_request);
	if ($response !== 'E') {
		$characters = unserialize($response);
	} else {
		header('Location index.php?load=F');
	}
}

?>

<?php include 'header.php' ?>

<div class="Body">
	<div class="Content">
		<h1>Character Dashboard</h1>
		<?php
		if (isset($_GET['load'])) {
			echo "<script type='text/javascript'>alert('Failed to get characters!');</script>";
		} else {
			foreach ($characters as $character) {
				echo
				'<table>
					<tr>
						<td>
							Character Name:' . $character['Name'] .
						'</td>
					</tr>
					<tr>
						<td>
							Race: ' . $character['Race'] . ' | Class: ' . $character['Class'] .
						'</td>
					</tr>
				</table>';
			}
		}
		?>
	</div>
</div>

<?php include 'footer.php' ?>