var lastName1 = "";
var lastName2 = "";


document.getElementById('nameBar').style.transition = "transform 0.4s ease-in-out";
//document.getElementById('stageIndicator').style.transition = "transform 1s ease-in-out";

document.getElementById('leftHalfBackgroundShadow').style.transition = "transform 0.4s ease-in-out";
document.getElementById('leftHalf').style.transition = "transform 0.4s ease-in-out";

let ws = null;
let wsConnected = false;


function connectWs() {
	console.log("connecting...");

	wsConnected = false;
	ws = new WebSocket(WS_URL);

	ws.onopen = () => {
		console.log("connected");
		wsConnected = true;
	};

	ws.onclose = () => {
		console.log("closed");
		wsConnected = false;
	};

	ws.onerror = () => {
		console.log("error");
		wsConnected = false;
	};

	ws.onmessage = (e) => {
		let msg;
		try {
			msg = JSON.parse(e.data);
		} catch {
			console.log("rx (non-json): " + e.data);
			return;
		}

		if(msg.root === "lowerThird"){
            if(msg.f1 !== ""){
                if(msg.f1 !== lastName1 || msg.f2 !== lastName2){
                    document.getElementById('nameBar').style.transform = "translateX(0)";
                    //sleep for 400ms to allow slide out to finish
                    setTimeout(() => {
                        document.getElementById('name1').innerText = msg.f1;
                        document.getElementById('name2').innerText = msg.f2;
                        document.getElementById('nameBar').style.transform = "translateX(760px)";
                    }, 400);
                    lastName1 = msg.f1;
                    lastName2 = msg.f2;

                    if(msg.duration != 0){
                        setTimeout(() => {
                            document.getElementById('nameBar').style.transform = "translateX(0)";
                            lastName1 = ""; lastName2 = "";
                        }, msg.duration);
                    }
                }
            }
            else{
                document.getElementById('nameBar').style.transform = "translateX(0)";
                lastName1 = ""; lastName2 = "";
            }
        }
        else if(msg.root === "vs"){
            let banner = document.getElementById("team-banner");
            if(msg.f1 !== "" && msg.f2 !== ""){
                document.getElementById('bannerText1').innerText = msg.f1;
                document.getElementById('bannerText2').innerText = msg.f2;

                banner.style.transform = "scaleX(1)";

                if(msg.duration != 0){
                    setTimeout(() => {
                        banner.style.transform = "scaleX(0)";
                    }, msg.duration);
                }
            }
            else{
                banner.style.transform = "scaleX(0)";
            }
        }
        else if(msg.root === "leftHalf"){
            if(msg.f1 === "in"){
                document.getElementById('leftHalfBackgroundShadow').style.transform = "translateX(0)";
                document.getElementById('leftHalf').style.transform = "translateX(0)";
            }
            else if(msg.f1 === "out"){
                document.getElementById('leftHalfBackgroundShadow').style.transform = "translateX(-110%)";
                document.getElementById('leftHalf').style.transform = "translateX(-110%)";
            }
        }
        return;
	};
}
connectWs();

setInterval(() => {
	if (!wsConnected) {
		console.log("attempting WebSocket reconnect...");

		try {
			if (ws) ws.close();
		} catch {}

		connectWs();
	}
}, 5000);