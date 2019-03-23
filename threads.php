<?php 
session_start();
require_once 'RPC.php';
use rabbit\RPC;

$threads_rpc = new RPC("messageBoardExchange");
$_SESSION['ForumID'] = $_GET['forumID'];
$getThreads = serialize(array("getThreads", $_SESSION['ForumID']));
$response = $threads_rpc->call($getThreads);
?>

<?php include 'header.php';?>

<div class="Body">
	<div class="Content">
		<?php
		$ForumName = $_GET['forumName'];
		echo '<h1>' . $ForumName . '</h1>';
		?>
		<a href="createThread.php">Create a Forum Thread</a>
		<?php
		$unserArr = unserialize($response);
		foreach ($unserArr as $threadArr){
			echo
			'<table>
				<tr>
					<td>
                        <a href="replies.php?threadID=' . $threadArr['ThreadID'] .  '>' . $threadArr['Name'] .
                        '</a><br>' . $threadArr['Content'] .
                    '</td>
				</tr>
				<tr>
					<td>'
						 . $threadArr['User'] . ' - ' . $threadArr['Timestamp'] . 
					'</td>
				</tr>
			</table>';
		}
		?>
	</div>
</div>

<?php include 'footer.php';?>