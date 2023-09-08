const express = require("express");
const app = express();

const server = require("http").createServer(app);
const io = require("socket.io")(server, {
    cors: { origin: "*" },
});

io.on("connection", (socket)=>{
    const { address, time } = socket.handshake;
    const { remoteAddress, remotePort } = socket.request.connection;
    console.log(`[${time}] ${remoteAddress}:${remotePort} connect`);

    socket.on("sendChatToServer", (message)=>{
        console.log(message);

        // io.sockets.emit("sendChatToClient", message);
        socket.broadcast.emit("sendChatToClient", message);
    })


    socket.on("disconnect", (socket)=>{
        console.log(`[${time}] ${remoteAddress}+${remotePort} disconnect`);
    });
})


server.listen(3000, ()=>{
    console.log("server running");
});