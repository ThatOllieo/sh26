var lastName1 = "";
var lastName2 = "";


document.getElementById('nameBar').style.transition = "transform 0.4s ease-in-out";
//document.getElementById('stageIndicator').style.transition = "transform 1s ease-in-out";

document.getElementById('leftHalfBackgroundShadow').style.transition = "transform 0.4s ease-in-out";
document.getElementById('leftHalf').style.transition = "transform 0.4s ease-in-out";
document.getElementById('topLeftTimer').style.transition = "transform 0.4s ease-in-out";

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
        else if(msg.root === "timerInOut"){
            if(msg.f1 === "in"){
                document.getElementById('topLeftTimer').style.transform = "translateX(0)";
            }
            else if(msg.f1 === "out"){
                document.getElementById('topLeftTimer').style.transform = "translateX(-110%)";
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

  // Set your target time here (UNIX timestamp in seconds)
  const TARGET_UNIX_SECONDS = 1770229200; // example

  const el = document.getElementById("topLeftTimerTime");

  function pad2(n) {
    return String(n).padStart(2, "0");
  }

  function render() {
    const nowSeconds = Math.floor(Date.now() / 1000);
    let remaining = TARGET_UNIX_SECONDS - nowSeconds;

    if (remaining <= 0) {
      el.textContent = "00:00:00";
      // Or: el.textContent = "Time's up!";
      return;
    }

    const days = Math.floor(remaining / 86400);
    remaining %= 86400;

    const hours = Math.floor(remaining / 3600);
    remaining %= 3600;

    const minutes = Math.floor(remaining / 60);
    const seconds = remaining % 60;

    const hh = pad2(hours);
    const mm = pad2(minutes);
    const ss = pad2(seconds);

    el.textContent = days > 0
      ? `${days}d ${hh}:${mm}:${ss}`
      : `${hh}:${mm}:${ss}`;
  }

  render();
  setInterval(render, 250); // updates 4x/sec so it stays crisp
