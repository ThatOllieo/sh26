<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
<style>
	:root{
		--shBlue: #015fc1;
		--shBlueDarker: #0256b0;
		--shBlueUltraDark: #00244a;
		--shOrange: #e7953f;
		--shOrangeDarker: #db8e3b;
	}
	
	body{
		width: 100vw;
		height: 100vh;
		background: transparent;
		margin: 0;
		padding: 0;
		
		font-family: "motor", monospace;
		font-weight: 400;
		font-style: normal;
		color:white;
	}
	
	.almightyDiv{
		width: 100%; 
		height: 100%; 
		display: flex; 
		flex-direction: column; 
		justify-content: center; 
		align-items: flex-start; 
		background-image: linear-gradient(135deg,var(--shBlueUltraDark),var(--shBlueDarker));
		/*background: var(--shBlueUltraDark);*/
	}
	
	.groupHeading{
		font-size:35px;
		border-bottom: 2.5px white solid;
		margin: 10px 0;
	}
	
	.group{
		height: calc(100% - 50px); 
		width: calc(100% - 50px); 
		margin: 25px; 
		
		background: #2B3239;
		
		border-radius: 12.5px;
		overflow: hidden;
		border-collapse: collapse;
		
		font-size: 25px;
		
		text-align: center;
		
		box-shadow: 0px 2.5px 10px 0 black;
	}
	
	.group tbody tr td{
		padding: 0 12.5px;
	}
	
	.cameraAreaDummy{
		width: calc(1920px / 3);
		height: calc(1080px / 3); 
		border: red solid 1px;
		margin: 25px 0;
		
	}
	
	
	.highlighted{
		/*background-image: linear-gradient(30deg, var(--shBlue), var(--shOrange));*/
		background-image: linear-gradient(30deg, var(--shOrange), var(--shOrangeDarker));
	}


	/* Layout classes to replace inline styles */
	.headerRow{
		width: 100%;
		height: 22.5%;
		display: flex;
		flex-direction: row;
		align-items: flex-start;
		justify-content: center;
	}
	.headerCol{
		display: flex;
		justify-content: center;
		align-items: center;
		height: 100%;
		width: 33%;
	}
	.headerColCenter{
		display: flex;
		justify-content: flex-end;
		align-items: center;
		height: 100%;
		width: 33%;
		flex-direction: column;
	}
	.headerTitle{
		font-size: 75px;
	}
	.headerSubtitle{
		font-size: 35px;
	}
	.headerLogo{
		height: 200px;
	}

	.bodyRow{
		width: 100%;
		height: 77.5%;
		display: flex;
		flex-direction: row;
		align-items: flex-start;
		justify-content: center;
	}
	.leftPanel{
		width: 50%;
		height: 100%;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}
	.rightPanel{
		width: 50%;
		height: 100%;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}

	.groupsGrid{
		display: flex;
		width: 100%;
		height: 100%;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}
	.groupsRow{
		display: flex;
		width: 100%;
		height: 50%;
		flex-direction: row;
		align-items: center;
		justify-content: center;
	}
	.groupBox{
		display: flex;
		width: 50%;
		height: 100%;
		flex-direction: column;
		justify-content: flex-start;
		align-items: center;
	}
</style>
</head>

<body>
	<div class="almightyDiv">
		<div class="headerRow">
			<div class="headerCol">
				<img src="SH_2025_TRANS.png" class="headerLogo">
			</div>
			<div class="headerColCenter">
				<div class="headerTitle">ScraphEEp 2026</div>
				<div class="headerSubtitle"> - Group Stage -</div>
			</div>
			<div class="headerCol">
				<img src="EARS_white.png" class="headerLogo">
			</div>
		</div>
		<div class="bodyRow">
			<div class="leftPanel">
				<div class="groupsGrid" id="groupsGrid"></div>
			</div>
			<div class="rightPanel">
				<div class="cameraAreaDummy"></div>
				<div class="cameraAreaDummy"></div>
			</div>
		</div>
	</div>
<script src="url.js"></script>
	<script>
		// Example JSON data (replace later with real data)
		const groupsJson = {
			groups: [
				{ groupId: 1, title: "Group 1", teams: [
					{ name: "Team Alpha", passed: false },
					{ name: "Team Bravo", passed: false },
					{ name: "Team Charlie", passed: true },
					{ name: "Team Delta", passed: true }
				]},
				{ groupId: 2, title: "Group 2", teams: [
					{ name: "Team Echo", passed: false },
					{ name: "Team Foxtrot", passed: true },
					{ name: "Team Golf", passed: false },
					{ name: "Team Hotel", passed: true }
				]},
				{ groupId: 3, title: "Group 3", teams: [
					{ name: "Team India", passed: false },
					{ name: "Team Juliet", passed: false },
					{ name: "Team Kilo", passed: true },
					{ name: "Team Lima", passed: true }
				]},
				{ groupId: 4, title: "Group 4", teams: [
					{ name: "Team Mike", passed: true },
					{ name: "Team November", passed: false },
					{ name: "Team Oscar", passed: false },
					{ name: "Team Papa", passed: true }
				]}
			]
		};

		function renderGroupsFromJson(data) {
			const root = document.getElementById("groupsGrid");
			root.innerHTML = "";

			const groups = (data && Array.isArray(data.groups)) ? data.groups : [];

			// Expecting 4 groups: build a 2x2 grid like the original
			const row1 = document.createElement("div");
			row1.className = "groupsRow";
			const row2 = document.createElement("div");
			row2.className = "groupsRow";

			function makeGroupBox(group) {
				const box = document.createElement("div");
				box.className = "groupBox";

				const heading = document.createElement("div");
				heading.className = "groupHeading";
				heading.textContent = group?.title ?? "Group";
				box.appendChild(heading);

				const table = document.createElement("table");
				table.className = "group";
				const tbody = document.createElement("tbody");

				const teams = Array.isArray(group?.teams) ? group.teams : [];
				// Render as 2x2 cells (first 4 teams). Pad missing with "???".
				const padded = teams.slice(0, 4);
				while (padded.length < 4) padded.push({ name: "???", passed: false });

				for (let r = 0; r < 2; r++) {
					const tr = document.createElement("tr");
					for (let c = 0; c < 2; c++) {
						const idx = r * 2 + c;
						const td = document.createElement("td");
						td.textContent = (padded[idx]?.name ?? "???").toString();
						if (padded[idx]?.passed) td.classList.add("highlighted");
						tr.appendChild(td);
					}
					tbody.appendChild(tr);
				}

				table.appendChild(tbody);
				box.appendChild(table);
				return box;
			}

			const boxes = groups.slice(0, 4).map(makeGroupBox);
			while (boxes.length < 4) boxes.push(makeGroupBox({ title: `Group ${boxes.length + 1}`, teams: [] }));

			row1.appendChild(boxes[0]);
			row1.appendChild(boxes[1]);
			row2.appendChild(boxes[2]);
			row2.appendChild(boxes[3]);

			root.appendChild(row1);
			root.appendChild(row2);
		}

let ws;

function connectWS() {
  ws = new WebSocket(WS_URL);

  ws.addEventListener("open", () => {
    // optional: explicitly request, though server already sends on connect
    ws.send(JSON.stringify({ type: "get_state" }));
  });

  ws.addEventListener("message", (ev) => {
    let msg;
    try { msg = JSON.parse(ev.data); } catch { return; }

    if (msg.type === "state") {
      // groups page uses msg.state.groups
      renderGroupsFromJson(msg.state.groups);
    }
  });

  ws.addEventListener("close", () => {
    // auto-reconnect
    setTimeout(connectWS, 1000);
  });
}

document.addEventListener("DOMContentLoaded", () => {
  connectWS();
});
	</script>
</body>
</html>