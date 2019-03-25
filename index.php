<?php
session_start();
require_once 'RPC.php';
use rabbit\RPC;

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
}

$characters = array();

if (!isset($_GET['load'])) {
	$user_rpc = new RPC('RetrieveJSON');
	$rpc_request = serialize(array("getCharacters", $_SESSION['username']));
	$response = $user_rpc->call($rpc_request);
	// echo "<h1 style='color: white'>";
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
			// echo '<h2>';
			// print_r($characters);
			// echo '</h2>';

			foreach ($characters as $character) {
				echo
				'<table>
					<tr>
						<td>
							Character Name:' . $character['name'] .
						'</td>
					</tr>
					<tr>
						<td>
							Race: ' . $character['race'] . ' | Class: ' . $character['class'] .
						'</td>
					</tr>
				</table>';
			}
		}
		?>
	</div>
</div>

<?php include 'footer.php' ?>