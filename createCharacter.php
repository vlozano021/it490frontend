<?php 
session_start();
require_once 'RPC.php';
use rabbit\RPC;

if(!empty($_POST)){
	$createCharacter_rpc = new RPC("createExchange");
	$characterArr = array(
		"characterName" => $_POST['characterName'],
		"age" => $_POST['age'],
		"sex" => $_POST['sex'],
		"height" => $_POST['height'],
		"weight" => $_POST['weight'],
		"race" => $_POST['race'],
		"subrace" => $_POST['subrace'],
		"class" => $_POST['class'],
		"subclass" => $_POST['subclass'],
		"statsSTR" => $_POST['statsSTR'],
		"statsDEX" => $_POST['statsDEX'],
		"statsCONST" => $_POST['statsCONST'],
		"statsINT" => $_POST['statsINT'],
		"statsWIS" => $_POST['statsWIS'],
		"statsCHA" => $_POST['statsCHA'],
		"passivePerception" => $_POST['passivePerception'],
		"sthrowSTR" => $_POST['sthrowSTR'],
		"sthrowDEX" => $_POST['sthrowDEX'],
		"sthrowCONST" => $_POST['sthrowCONST'],
		"sthrowINT" => $_POST['sthrowINT'],
		"sthrowWIS" => $_POST['sthrowWIS'],
		"sthrowCHA" => $_POST['sthrowCHA'],
		"armorClass" => $_POST['armorClass'],
		"speed" => $_POST['speed'],
		"maxHitPoint" => $_POST['maxHitPoint'],
		"acrobatics" => $_POST['acrobatics'],
		"animalHandling" => $_POST['animalHandling'],
		"arcana" => $_POST['arcana'],
		"athletic" => $_POST['athletic'],
		"deception" => $_POST['deception'],
		"history" => $_POST['history'],
		"insight" => $_POST['insight'],
		"investigation" => $_POST['investigation'],
		"medicine" => $_POST['medicine'],
		"nature" => $_POST['nature'],
		"perception" => $_POST['perception'],
		"performance" => $_POST['performance'],
		"persuation" => $_POST['persuation'],
		"religion" => $_POST['religion'],
		"soHand" => $_POST['soHand'],
		"stealth" => $_POST['stealth'],
		"survival" => $_POST['survival'],
		"hkit" => $_POST['hkit'],
		"equipment" => $_POST['equipment'],
		"spell" => $_POST['spell'],
		"features" => $_POST['features'],
		"traits" => $_POST['traits'],
		"personalityTraits" => $_POST['personalityTraits'],
		"ideals" => $_POST['ideals'],
		"bonds" => $_POST['bonds'],
		"flaws" => $_POST['flaws'],
		"hitDice" => $_POST['hitDice'],
	);

	$jsonCharacter = json_encode($characterArr);

	$createCharacterMSG = serialize(array("createCharacter", $jsonCharacter));

	$response = $createCharacter_rpc->call($createCharacterMSG);
	
	if ($response==="S"){
		header('Location: characterdashboard.php?');
	}
	else {
		header('Location: createCharacter.php?success=F');
	}
}

if(isset($_GET['success'])){
	if($_GET['success']==="F"){
		echo "<script type='text/javascript'>alert("There was an error in creating a character. Try Again.");</script>";
	}
}

?>

<?php include 'header.php';?>

<div class="Body">
		<div class="Content">
			<h1>Create a Character</h1>
			<div class="Character">
				<form action="" id="createCharacter" method="POST">
					<h3>Character Info:</h3>
					Character Name:
					<input type="text" name="characterName"></input><br>
					<br>
					Age:
					<input type="number" name="age">
					&nbsp;
					Sex:
					<select name="sex">
						<option value="Unknown"></option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>&nbsp;
					Height:
					<input type="number" name="height">
					ft
					&nbsp;
					Weight:
					<input type="number" name="weight">
					lbs
					<br>
					<h3>Race:</h3>
					Race:
					<select name="race" id="Race">
					</select>
					&nbsp;
					Subrace:
					<select name="subrace" id="Subrace">
					</select>
					&nbsp;
					Class:
					<select name="class" id="Class">
					</select>
					&nbsp;
					Subclass:
					<select name="subclass" id="Subclass">
					</select>
					<h3>Stats:</h3>
					STR:
					<input type="number" name="statsSTR">
					&nbsp;
					DEX:
					<input type="number" name="statsDEX">
					&nbsp;
					CONST:
					<input type="number" name="statsCONST">
					&nbsp;
					INT:
					<input type="number" name="statsINT">
					&nbsp;
					WIS:
					<input type="number" name="statsWIS">
					&nbsp;
					CHA:
					<input type="number" name="statsCHA">
					<br>
					<h3>Passive Perception:
						<input type="number" name="passivePerception">
					</h3>
					<h3>Saving Throws</h3>
					STR:
					<input type="number" name="sthrowSTR">
					&nbsp;
					DEX:
					<input type="number" name="sthrowDEX">
					&nbsp;
					CONST:
					<input type="number" name="sthrowCONST">
					&nbsp;
					INT:
					<input type="number" name="sthrowINT">
					&nbsp;
					WIS:
					<input type="number" name="sthrowWIS">
					&nbsp;
					CHA:
					<input type="number" name="sthrowCHA">
					<br>
					<h3>Armor Class:
						<input type="number" name="armorClass">
					</h3>
					<h3>Speed:
						<input type="number" name="speed">
					</h3>
					<h3>Max Hit Point:
						<input type="number" name="maxHitPoint">
					</h3>
					<h3>Skills</h3>
					Acrobatics:
					<input type="number" name="acrobatics">
					&nbsp;
					Animal Handling:
					<input type="number" name="animaHandling">
					&nbsp;
					Arcana:
					<input type="number" name="arcana">
					&nbsp;
					Athletic:
					<input type="number" name="athletic">
					&nbsp;
					Deception:
					<input type="number" name="deception">
					&nbsp;
					History:
					<input type="number" name="history">
					&nbsp;
					Insight:
					<input type="number" name="insight">
					&nbsp;
					Investigation:
					<input type="number" name="investigation">
					&nbsp;
					Medicine:
					<input type="number" name="medicine">
					&nbsp;
					Nature:
					<input type="number" name="nature" >
					&nbsp;
					Perception:
					<input type="number" name="perception" >
					&nbsp;
					Performance:
					<input type="number" name="performance" >
					&nbsp;
					Persuation:
					<input type="number" name="persuation" >
					&nbsp;
					Religion:
					<input type="number" name="religion" >
					&nbsp;
					Sleight of Hand:
					<input type="number" name="soHand" >
					&nbsp;
					Stealth:
					<input type="number" name="stealth" >
					&nbsp;
					Survival:
					<input type="number" name="survival" >
					&nbsp;
					Herbalism Kit:
					<input type="number" name="hkit" >
					<br>
					<h3>Equipment</h3>
					Add Equipment:&nbsp;
					<input type="button" value="Add Equipment" onclick="addEquipment()"></input>
					<div id="addEquipment"><select name="equipment" id="Equipment">
					</select></div>
					<div id="moreEquipment"></div>
					<h3>Spells:</h3>
					Add Spell:&nbsp;
					<input type="button" value="Add Spell" onclick="addSpell()"></input>
					<br>
					<div id="addSpell"><select name="spell" id="Spell">
					</select></div>
					<div id="moreSpell"></div>
					<h3>Features and Traits</h3>
					Features:
					<select name="features" id="Features">
					</select>
					&nbsp;
					Traits:
					<select name="traits" id="Traits">
					</select>
					<br>
					<h3>Personality Traits</h3>
					<textarea name="personalityTraits" form="createCharacter"></textarea>
					<h3>Ideals</h3>
					<textarea name="ideals" form="createCharacter"></textarea>
					<br>
					<h3>Bonds</h3>
					<textarea name="bonds" form="createCharacter"></textarea>
					<br>
					<h3>Flaws</h3>
					<textarea name="flaws" form="createCharacter"></textarea>
					<br>
					<h3>Hit Dice</h3>
					<textarea name="hitDice" form="createCharacter"></textarea>
					<br><br>
					<input type="submit" name="createCharacterSubmit" value="Save Character">
				</form>
				<script src="scripts.js"></script>
			</div>
		</div>
	</div>

<?php include 'footer.php';?>