import express from "express";
import { Server } from "socket.io";
import { createServer } from "http";
import axios from "axios";

const port = process.env.PORT ?? 3000;

const app = express();
const server = createServer(app);
const io = new Server(server, {
  connectionStateRecovery: {},
});

io.on("connection", async (socket) => {
  console.log("Conexion");

  socket.on("disconnect", () => {
    console.log("Desconectado");
  });

  socket.on("chat message", async (msg) => {
    let res;

    try {
      res = await axios.post(
        `http://localhost/Full-stack/JS/chat/server/insert.php?content=${msg}`,
        {
          content: msg,
        }
      );

      res = await axios.get(
        `http://localhost/Full-stack/JS/chat/server/consult.php`
      );
    } catch (e) {
      console.error(e);
      return;
    }

    socket.broadcast.emit("chat message", { msg }, res.data.id.toString());

    socket.emit("chat message", { value: true, msg }, res.data.id.toString());
  });

  console.log(socket.handshake.auth);

  if (!socket.recovered) {
    try {
      let res = await axios.get(
        `http://localhost/Full-stack/JS/chat/server/all.php?id=${
          socket.handshake.auth.serverOffset ?? 0
        }`
      );
      console.log(res.data);
      res.data.forEach((e) =>
        socket.emit("chat message", { msg: e.content }, e.id)
      );
    } catch (e) {
      console.log(e);
    }
  }
});

app.use(express.json());

app.get("/", (req, res) => {
  res.sendFile(process.cwd() + "/client/index.html");
});

server.listen(port, () => {
  console.log(`Server running ${port}`);
});
