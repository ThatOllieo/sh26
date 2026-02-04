import asyncio
import websockets

connected_clients = set()

async def handler(websocket):
    # Add client to the connected set
    connected_clients.add(websocket)
    print("New client connected")

    try:
        async for message in websocket:
            print(f"Received: {message}")
            
            # Broadcast the message to all connected clients
            for client in connected_clients:
                if client != websocket:  # Avoid sending the message back to the sender
                    await client.send(message)

    except websockets.exceptions.ConnectionClosed:
        print("Client disconnected")

    finally:
        # Remove client from the set when they disconnect
        connected_clients.remove(websocket)

async def main():
    server = await websockets.serve(handler, "0.0.0.0", 9002)
    print("WebSocket server running on ws://localhost:9002")
    await server.wait_closed()

# Use asyncio.run() to start the event loop properly
asyncio.run(main())

