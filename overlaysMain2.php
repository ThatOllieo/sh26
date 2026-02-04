<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
<link rel="stylesheet" href="https://use.typekit.net/tyk6wyc.css">
<link rel="stylesheet" href="overlays.css">

<!--
font-family: "motor", monospace;
font-weight: 400;
font-style: normal;

font-family: "motor-stencil", sans-serif;
font-weight: 400;
font-style: normal;
-->
	
</head>

<body>
    <!-- 
	<div style="position: absolute; top: 75px; display: flex; flex-direction: row; height: 100px; align-items: center; justify-content: flex-start; box-shadow: 0px 2.5px 10px 0 black; left: -1500px;" id="stageIndicator">
		<div style="height: 100%; background: var(--shOrange); display: flex; align-items: center; justify-content: flex-end; width: 1500px;">
			<div style="margin: 20px; font-size: 70px; color: var(--shBlueUltraDark);" id="stageIndicator.text">Build Stage</div>
		</div>
		<div style="height: 100%; background: var(--shBlueDarker); width:10px; position: relative;">
			<img src="clatter.jpg" style="height: 100px; position: absolute; top: -35px;left:-250px;" id="clatter">
		</div>
	</div>
-->
    <div class="leftHalfBackgroundShadow" id="leftHalfBackgroundShadow">
        <div class="leftHalfBackground" id="leftHalfBackground"></div>
    </div>
    <div class="leftHalf" id="leftHalf">
        <t class="leftHalfTitle">Lightning McQueens Drive</t>
        <img class="botImage" src="muffin.png" />
    </div>
	
	<div style="position: absolute; bottom: calc(125px + 50px); left: calc(-25px - 760px);" id="nameBar">
		<div style="width: 760px; height: 125px; background: var(--shOrange); transform: skew(-20deg); box-shadow: 0px 2.5px 10px 0 black; position: absolute; top:10px; left:0;"></div>
		<div style="width: 750px; height: 125px; background: var(--shBlue); transform: skew(-20deg); box-shadow: 0px 2.5px 10px 0 black; position: absolute; top:0; left:0;">
			<?php 
			$c = 0;
			$cap = 750 / 25;
			$alt = false;
			while($c < $cap){
				if($alt){
					$offset = $c *25;
					?>
						<div style="width: 25px; height: 125px; background: var(--shBlueDarker); transform: skew(0deg); position: absolute; top:0; left:<?php echo("$offset");?>px;"></div>
					<?php
					$alt = false;
				}
				else{
					$alt = true;
				}
				$c+=1;
			}
			?>
		</div>
		<div style="position: absolute; top:0; left:25px; width: 700px; display: flex; flex-direction: column; justify-content: center; align-items: flex-start; padding: 10px 30px; height: calc(125px - 20px);">
			<div style="color: white;font-size: 50px;" id="name1">Oliver Broad</div>
			<div style="color: white;font-size: 25px; font-style: italic;" id="name2">Electronics - TeamKoteri</div>
		</div>
	</div>
	
	
	<div style="position: absolute; display: flex; top:0; left:0; width: 100%; height: 100%; justify-content: flex-end; align-items: center; flex-direction: column;">

	<div style="position: relative; bottom: 50px; display: flex; flex-direction: row; justify-content: center; align-items: center; transform: scaleX(0); transition: transform 0.4s ease-in-out; transform-origin: center;" id="team-banner">
		<div style="position: relative;">
		<div style="width: 760px; height: 125px; background: var(--shOrange); transform: skew(-20deg); box-shadow: 0px 2.5px 10px 0 black;">
			<?php 
			$c = 0;
			$cap = 750 / 25;
			$alt = false;
			while($c < $cap){
				if($alt){
					$offset = $c *25;
					?>
						<div style="width: 25px; height: 125px; background: var(--shOrangeDarker); transform: skew(0deg); position: absolute; top:0; left:<?php echo("$offset");?>px;"></div>
					<?php
					$alt = false;
				}
				else{
					$alt = true;
				}
				$c+=1;
			}
			?>
		</div>
		<div style="position: absolute; top:0; left:25px; width: 700px; display: flex; flex-direction: column; justify-content: center; align-items: flex-start; padding: 10px 30px; height: calc(125px - 20px);">
			<div style="color: white;font-size: 75px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 675px;" id="bannerText1">Team One</div>
		</div>		
		</div>

		<div style="position: relative;">
		<div style="width: 750px; height: 125px; background: var(--shBlue); transform: skew(-20deg); box-shadow: 0px 2.5px 10px 0 black;">
			<?php 
			$c = 0;
			$cap = 750 / 25;
			$alt = false;
			while($c < $cap){
				if($alt){
					$offset = $c *25;
					?>
						<div style="width: 25px; height: 125px; background: var(--shBlueDarker); transform: skew(0deg); position: absolute; top:0; left:<?php echo("$offset");?>px;"></div>
					<?php
					$alt = false;
				}
				else{
					$alt = true;
				}
				$c+=1;
			}
			?>
		</div>
		<div style="position: absolute; top:0; right:25px; width: 700px; display: flex; flex-direction: column; justify-content: center; align-items: flex-end; padding: 10px 30px; height: calc(125px - 20px);">
			<div style="color: white;font-size: 75px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 675px;" id="bannerText2">Team Two</div>
		</div>
		</div>
		
		<div style="position: absolute; top:50%; left:50%; ">
			<div style="color: white; font-size: 75px; text-align: center; position: absolute; transform: translateX(-50%) translateY(-50%);">VS</div>
		</div>
	</div>
		
		
	</div>
	
<script src="url.js"></script>
<script src="script.js"></script>
</body>
</html>