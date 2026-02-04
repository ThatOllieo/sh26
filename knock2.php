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
	
	.cameraAreaDummy{
		width: calc(1920px / 3);
		height: calc(1080px / 3); 
		border: red solid 1px;
		margin: 25px 0;
		
	}
	
	.tournyItem{
		width: calc(100% - 25px); 
		height: 75px;
		margin: 12.5px;
		border-radius: 12.5px;
		
		background: #2B3239;
		
		font-size: 25px;
		
		display: flex;
		align-items: center;
		justify-content: center;
		box-shadow: 0px 2.5px 10px 0 black;
		
		text-align: center;
		overflow: hidden;
		text-overflow: ellipsis;
		
		z-index: 10;
	}
	
	.tournyColumn{
		width:25%; 
		height: 100%; 
		display: flex; 
		flex-direction: column;
		justify-content: space-evenly; 
		align-items: center;
	}
	
	.highlighted{
		/*background-image: linear-gradient(30deg, var(--shBlue), var(--shOrange));*/
		background-image: linear-gradient(30deg, var(--shOrange), var(--shOrangeDarker));
	}
	
	.c1{
		display: flex; 
		height: 12.5%; 
		width: 100%; 
		justify-content: center; 
		align-items: center;
	}
	
	.c2{
		display: flex; 
		height: 25%; 
		width: 100%; 
		justify-content: center; 
		align-items: center;
	}
	
	.c3{
		display: flex; 
		height: 50%; 
		width: 100%; 
		justify-content: center; 
		align-items: center;
	}
	
	.c4{
		display: flex; 
		height: 100%; 
		width: 100%; 
		justify-content: center; 
		align-items: center;
	}
	
	/* SVG Positioned Behind */
	.lines {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		pointer-events: none; /* Allow clicking through */
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
	.tournamentPanel{
		width: 50%;
		height: 100%;
		display: flex;
		flex-direction: row;
		justify-content: center;
		align-items: center;
		position: relative;
	}
	.tournyColumnsRoot{
		width: 100%;
		height: 100%;
		display: flex;
		flex-direction: row;
		justify-content: space-evenly;
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
				<div class="headerSubtitle"> - Knockouts -</div>
			</div>
			<div class="headerCol">
				<img src="EARS_white.png" class="headerLogo">
			</div>
		</div>
		<div class="bodyRow">
			<div class="leftPanel">
				<div class="cameraAreaDummy"></div>
				<div class="cameraAreaDummy"></div>
			</div>
			<div class="tournamentPanel" id="tournament">
				<svg class="lines" id="svg"></svg>
				<div id="tournyColumns" class="tournyColumnsRoot"></div>
			</div>
		</div>
	</div>
<script src="url.js"></script>
<script>
function drawTournamentLines(elem1Id, elem2Id, midpointTargetId) {
    const svg = document.getElementById("svg");
    const container = document.getElementById("tournament");

    let elem1 = document.getElementById(elem1Id);
    let elem2 = document.getElementById(elem2Id);
    let midpointTarget = document.getElementById(midpointTargetId);

    let box1 = elem1.getBoundingClientRect();
    let box2 = elem2.getBoundingClientRect();
    let boxMid = midpointTarget.getBoundingClientRect();
    let containerBox = container.getBoundingClientRect(); // Get container position

    // Calculate center positions relative to the container
    let x1 = box1.left + box1.width / 2 - containerBox.left;
    let y1 = box1.top + box1.height / 2 - containerBox.top;
    let x2 = box2.left + box2.width / 2 - containerBox.left;
    let y2 = box2.top + box2.height / 2 - containerBox.top;

    // Midpoint of the first line
    let midX = (x1 + x2) / 2;
    let midY = (y1 + y2) / 2;

    // Midpoint target position relative to container
    let xMidTarget = boxMid.left + boxMid.width / 2 - containerBox.left;
    let yMidTarget = boxMid.top + boxMid.height / 2 - containerBox.top;

    // Create first line (between elem1 and elem2)
    let line1 = document.createElementNS("http://www.w3.org/2000/svg", "line");
    line1.setAttribute("x1", x1);
    line1.setAttribute("y1", y1);
    line1.setAttribute("x2", x2);
    line1.setAttribute("y2", y2);
    line1.setAttribute("stroke", "white");
    line1.setAttribute("stroke-width", "2");

    // Create second line (midpoint to midpointTarget)
    let line2 = document.createElementNS("http://www.w3.org/2000/svg", "line");
    line2.setAttribute("x1", midX);
    line2.setAttribute("y1", midY);
    line2.setAttribute("x2", xMidTarget);
    line2.setAttribute("y2", yMidTarget);
    line2.setAttribute("stroke", "white");
    line2.setAttribute("stroke-width", "2");

    // Append lines to SVG
    svg.appendChild(line1);
    svg.appendChild(line2);
}

// Example JSON data (replace this with real data later)
const tournamentJson = {
    slots: [
        { slotId: 1, teamName: "Team Alpha" },
        { slotId: 2, teamName: "Team Bravo" },
        { slotId: 3, teamName: "Team Charlie" },
        { slotId: 4, teamName: "Team Delta" },
        { slotId: 5, teamName: "Team Echo" },
        { slotId: 6, teamName: "Team Foxtrot" },
        { slotId: 7, teamName: "Team Golf" },
        { slotId: 8, teamName: "Team Hotel" },
        { slotId: 9, teamName: "Team Bravo" },
        { slotId: 10, teamName: "???" },
        { slotId: 11, teamName: "???" },
        { slotId: 12, teamName: "???" },
        { slotId: 13, teamName: "???" },
        { slotId: 14, teamName: "???" },
        { slotId: 15, teamName: "???" }
    ]
};

function renderTournamentFromJson(data) {
    const columnsRoot = document.getElementById("tournyColumns");
    const svg = document.getElementById("svg");

    // Clear existing content
    columnsRoot.innerHTML = "";
    svg.innerHTML = "";

    // Build a slotId -> teamName map, defaulting to "???"
    const slotMap = new Map();
    if (data && Array.isArray(data.slots)) {
        for (const s of data.slots) {
            if (!s || typeof s.slotId !== "number") continue;
            slotMap.set(s.slotId, (s.teamName ?? "???").toString());
        }
    }

    // Column boundaries match your old PHP layout:
    // col1: 1-8 (c1), col2: 9-12 (c2), col3: 13-14 (c3), col4: 15 (c4)
    const columns = [
        { cClass: "c1", slots: [1,2,3,4,5,6,7,8] },
        { cClass: "c2", slots: [9,10,11,12] },
        { cClass: "c3", slots: [13,14] },
        { cClass: "c4", slots: [15] }
    ];

    for (const col of columns) {
        const colDiv = document.createElement("div");
        colDiv.className = "tournyColumn";

        for (const slotId of col.slots) {
            const wrap = document.createElement("div");
            wrap.className = col.cClass;

            const item = document.createElement("div");
            item.className = "tournyItem";
            item.id = `slot${slotId}`;
            item.textContent = slotMap.get(slotId) ?? "???";

            wrap.appendChild(item);
            colDiv.appendChild(wrap);
        }

        columnsRoot.appendChild(colDiv);
    }

    // Draw the lines (same as before)
    drawTournamentLines("slot1", "slot2", "slot9");
    drawTournamentLines("slot3", "slot4", "slot10");
    drawTournamentLines("slot5", "slot6", "slot11");
    drawTournamentLines("slot7", "slot8", "slot12");

    drawTournamentLines("slot9", "slot10", "slot13");
    drawTournamentLines("slot11", "slot12", "slot14");

    drawTournamentLines("slot13", "slot14", "slot15");

    // Highlight duplicates (same logic as before)
    let valuesMap = new Map();

    for (let i = 1; i <= 15; i++) {
        let slot = document.getElementById(`slot${i}`);
        if (!slot) continue;

        let value = slot.textContent.trim();
        if (value === "???") continue;

        if (!valuesMap.has(value)) valuesMap.set(value, []);
        valuesMap.get(value).push(slot);
    }

    valuesMap.forEach((elements) => {
        if (elements.length > 1) {
            elements.sort((a, b) => parseInt(a.id.replace("slot", "")) - parseInt(b.id.replace("slot", "")));
            elements.slice(0, -1).forEach(el => el.classList.add("highlighted"));
        }
    });
}

let ws;

function connectWS() {
  ws = new WebSocket(WS_URL);

  ws.addEventListener("open", () => {
    ws.send(JSON.stringify({ type: "get_state" }));
  });

  ws.addEventListener("message", (ev) => {
    let msg;
    try { msg = JSON.parse(ev.data); } catch { return; }

    if (msg.type === "state") {
      renderTournamentFromJson(msg.state.knockouts);
    }
  });

  ws.addEventListener("close", () => {
    setTimeout(connectWS, 1000);
  });
}

document.addEventListener("DOMContentLoaded", () => {
  connectWS();
});
</script>
	
</body>
</html>