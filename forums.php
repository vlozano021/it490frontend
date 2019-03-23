<?php 
session_start();
require_once 'RPC.php';
use rabbit\RPC;

$forums_rpc = new RPC("ForumsExchange");
$getForums = "getForums";
$response = $forums_rpc->call($getForums);
?>

<?php include 'header.php';?>

<div class="Body">
	<div class="Content">
		<h1>Forums</h1>
		<?php
		$unserArr = unserialize($response);
		foreach ($unserArr as $forumArr){
			echo
			"<table>
				<tr>
					<td>
						<a href=\"threads.php?\"> . $forumArr .</a>
					</td>
				</tr>
			</table>";
		}
		?>
	</div>
</div>

<?php include 'footer.php';?>
