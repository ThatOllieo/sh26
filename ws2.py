import asyncio
import json
import os
import websockets

STATE_FILE = "tournament_state.json"
connected_clients = set()

DEFAULT_STATE = {
    "groups": {
        "groups": [
            {"groupId": 1, "title": "Group 1", "teams": [{"name": "???", "passed": False} for _ in range(4)]},
            {"groupId": 2, "title": "Group 2", "teams": [{"name": "???", "passed": False} for _ in range(4)]},
            {"groupId": 3, "title": "Group 3", "teams": [{"name": "???", "passed": False} for _ in range(4)]},
            {"groupId": 4, "title": "Group 4", "teams": [{"name": "???", "passed": False} for _ in range(4)]},
        ]
    },
    "knockouts": {
        "slots": [{"slotId": i, "teamName": "???"} for i in range(1, 16)]
    }
}

STATE_LOCK = asyncio.Lock()
STATE = None


def load_state():
    if os.path.exists(STATE_FILE):
        try:
            with open(STATE_FILE, "r", encoding="utf-8") as f:
                return json.load(f)
        except Exception as e:
            print("Failed to load state file, using default. Error:", e)
    return DEFAULT_STATE


def save_state(state):
    try:
        with open(STATE_FILE, "w", encoding="utf-8") as f:
            json.dump(state, f, indent=2)
    except Exception as e:
        print("Failed to save state file:", e)


async def broadcast_full_state():
    payload = json.dumps({"type": "state", "state": STATE})
    dead = []
    for ws in connected_clients:
        try:
            await ws.send(payload)
        except Exception:
            dead.append(ws)
    for ws in dead:
        connected_clients.discard(ws)

        


def deep_get_container(root, parts):
    """
    Returns (container, last_key) so you can set container[last_key] = value
    Supports dict keys and list indices.
    """
    cur = root
    for p in parts[:-1]:
        if p.isdigit():
            cur = cur[int(p)]
        else:
            cur = cur[p]
    last = parts[-1]
    return cur, int(last) if last.isdigit() else last


async def handle_message(ws, msg_obj):
    global STATE

    msg_type = msg_obj.get("type")

    if msg_type == "get_state":
        await ws.send(json.dumps({"type": "state", "state": STATE}))
        return

    # Replace entire state (simple + robust)
    if msg_type == "set_state":
        new_state = msg_obj.get("state")
        if not isinstance(new_state, dict):
            await ws.send(json.dumps({"type": "error", "error": "state must be an object"}))
            return

        async with STATE_LOCK:
            STATE = new_state
            save_state(STATE)
        await broadcast_full_state()
        return

    # Optional: patch a single value
    if msg_type == "patch":
        path = msg_obj.get("path")
        value = msg_obj.get("value")
        if not isinstance(path, str) or not path:
            await ws.send(json.dumps({"type": "error", "error": "patch.path must be a non-empty string"}))
            return

        parts = path.split(".")
        async with STATE_LOCK:
            try:
                container, key = deep_get_container(STATE, parts)
                container[key] = value
                save_state(STATE)
            except Exception as e:
                await ws.send(json.dumps({"type": "error", "error": f"patch failed: {e}"}))
                return

        await broadcast_full_state()
        return

    # Backwards-compat: if it's not one of our stateful commands, behave like the old server
    # and rebroadcast the message to all other connected clients.
    payload = json.dumps(msg_obj)
    dead = []
    for client in connected_clients:
        if client == ws:
            continue  # don't echo back to sender (matches old behaviour)
        try:
            await client.send(payload)
        except Exception:
            dead.append(client)

    for client in dead:
        connected_clients.discard(client)


async def handler(websocket):
    connected_clients.add(websocket)
    print("New client connected")

    # Immediately push full state on connect (fixes refresh problem)
    await websocket.send(json.dumps({"type": "state", "state": STATE}))

    try:
        async for message in websocket:
            try:
                obj = json.loads(message)
            except json.JSONDecodeError:
                await websocket.send(json.dumps({"type": "error", "error": "invalid JSON"}))
                continue

            await handle_message(websocket, obj)

    except websockets.exceptions.ConnectionClosed:
        print("Client disconnected")
    finally:
        connected_clients.discard(websocket)


async def main():
    global STATE
    STATE = load_state()

    server = await websockets.serve(handler, "0.0.0.0", 9002)
    print("WebSocket server running on ws://localhost:9002")
    await server.wait_closed()


asyncio.run(main())