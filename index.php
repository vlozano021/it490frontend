<?php
session_start();
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
}

require_once 'RPC.php';
use rabbit\RPC;

$characterdashboard_rpc = new RPC("storeUserData");
$getCharacters = serialize(array("getCharacter"));
$response = $forums_rpc->call($getForums);
?>

<?php include 'header.php' ?>

<div class="Body">
	<div class="Content">
		<h1>Character Dashboard</h1>
		<?php
		$unserArr = unserialize($response);
		foreach ($unserArr as $charArr) {
			echo
			'<table>
				<tr>
					<td>
						Character Name:' . $charArr['Name'] .
					'</td>
				</tr>
				<tr>
					<td>
						Race: ' . $charArr['Race'] . ' | Class: ' . $charArr['Class'] .
					'</td>
				</tr>
			</table>';
		}
		?>
	</div>
</div>

<?php include 'footer.php' ?>