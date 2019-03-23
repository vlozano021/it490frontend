<?php 
session_start();
require_once 'RPC.php';
use rabbit\RPC;

$threads_rpc = new RPC("messageboardExchange");
$_SESSION['ThreadID'] = $_GET['threadID'];
$getReplies = serialize(array("getReplies", $_SESSION['ThreadID']));
$response = $threads_rpc->call($getReplies);
$getThread = serialize(array("getThread", $_SESSION['ThreadID']));
$response1 = $threads_rpc->call($getThread);

if(!empty($_POST)){
	$createReplies_rpc = new RPC("createExchange");
	$replyINFO = array($_SESSION['ThreadID'], $_POST['Content'], $_SESSION['User']);
	$createReplies = serialize(array("createThreads", $replyINFO));
	$response2 = $threads_rpc->call($createReplies);
	if ($response2==="S"){
		header('Refresh:0')
	}
	else {
		header('Refresh:0');
	}
}

if(isset($_GET['success'])){
	if($_GET['success']==="F"){
		echo "<script type='text/javascript'>alert('There was an error in creating a thread. Try Again.');</script>";
	}
}
?>


<?php include 'header.php';?>

<div class="Body">
	<div class="Content">
		<?php
		$Thread = unserialize($response1);
		echo 
			'<h1>' . $Thread['Name'] . '</h1>
			<p>' . $Thread['Content'] . '</p><br>
			<p>' . $Thread['User'] . ' - ' . $Thread['Timestamp'] . '</p>'

		?>
		<?php
		$unserArr = unserialize($response);
		foreach ($unserArr as $repliesArr){
			echo
			'<table>
				<tr>
					<td>' 
					. $repliesArr['Content'] .  
                    '</td>
				</tr>
				<tr>
					<td>'
					. $repliesArr['User'] . ' - ' . $repliesArr['Timestamp'] . 
					'</td>
				</tr>
			</table>';
		}
		?>
		<form action="" id="addReply" method="POST">
		  	Add Reply:<br> <textarea name="ReplyContent" form="addReply" required></textarea>
			<br><br>
			<input type="submit" name="createReplySubmit" value="Submit">
		</form>
		<button type="button" id="showAddReply">Add Reply</button>
		<script>
			$(document).ready(function(){
			    $("#showAddReply").click(function(){
			        $("#addReply").show();
			        $(this).hide();
			    });
			});
		</script>
	</div>
</div>

<?php include 'footer.php';?>