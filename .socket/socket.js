const app = require('http').createServer(handler);

const io = require('socket.io')(app);

const Redis = require('ioredis');

const redis = new Redis(6379, 'redis');

const port = 8443;

function handler(req, res){
    res.writeHead(200);
    res.end('');
}

io.on('connection', socket => {
    console.log('===========start new connection===========');
    console.log(`socket id : ${socket.id}`);
    console.log('===========end new connection===========');
});

redis.psubscribe('*', (error, count) => {
    console.log("subscribe to " + count + " channel");
});

redis.on('pmessage', (pattern, channel, message) => {
    channelHandler(channel, message);
});

function channelHandler(channel, message){
    console.log("*********Server Broadcast************");
    var msg = JSON.parse(message);
    var channel_event = channel+":"+msg.event;
    console.log(channel_event, JSON.stringify(msg));
    io.emit(channel_event, msg);
    console.log("**************************************");
}

app.listen(port, () => {
    console.log(`socket server started on port -> ${port}`);
});