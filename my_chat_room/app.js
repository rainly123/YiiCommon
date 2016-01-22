
/**
 * Module dependencies.（模块依赖）
 */
var express = require('express');
var routes = require('./routes');
var user = require('./routes/user');
var http = require('http');
var path = require('path');
var app = express();

// all environments
app.set('port', process.env.PORT || 3000);
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');
app.use(express.favicon());
app.use(express.logger('dev'));
app.use(express.bodyParser());
app.use(express.cookieParser());
app.use(express.json());
app.use(express.urlencoded());
app.use(express.methodOverride());
app.use(app.router);
app.use(express.static(path.join(__dirname, 'public')));

// development only
if ('development' == app.get('env')) {
  app.use(express.errorHandler());
}

var users = {};
app.get('/', function(req, res) {

    if( req.cookies.user == null ) {
        res.redirect('/signin');
    } else {
        res.sendfile('views/index.html');
    }
});

app.get('/signin', function(req, res) {
    res.sendfile('views/signin.html');
});

app.post('/signin', function(req, res) {
    if(users[req.body.name]) {
        //存在，则不允许登录
        req.redirect('/signin');
    } else {
        res.cookie("user", req.body.name, {maxAge:1000*60*24*30});
        res.redirect('/');
    }
});

//server
// var server = http.createServer(app);
var server = http.createServer(app).listen(3000,function(){
    console.log('listening on :3000');
});
var io = require('socket.io').listen(server);

io.sockets.on('connection', function(socket){
    //有人上线
    socket.on('online', function(data) {
        socket.name = data.user;
        if(!users[data.user]) {
            users[data.user] = data.user;
        }
        console.log(users);
        io.sockets.emit('online', {users: users, user: data.user});
    });
    //有人主动退出
    socket.on('logout',function(){
        if(users[socket.name]) {
            delete users[socket.name];
            socket.broadcast.emit('offline', {users: users, user: socket.name});
        }
    });
   //有人说话
   socket.on('say', function(data) {
        if(data.to=='all') {//对所有人说（群聊）
            console.log("群聊开始");
            socket.broadcast.emit('say', data);
        } else {
            console.log("私聊:"+data.to);//对某人说（私聊）
            var clients = io.sockets.sockets;
            console.log('客户端：'+clients);
            //遍历找到用户
            clients.forEach(function(client) {
                if(client.name == data.to) {
                    client.emit('say', data);
                }
            });
        }
   });

   //有人下线
   socket.on('disconnect', function(){
        if(users[socket.name]) {
            delete users[socket.name];
            socket.broadcast.emit('offline', {users: users, user: socket.name});
        } 
   });
  
});


// http.createServer(app).listen(app.get('port'), function(){
//   console.log('Express server listening on port ' + app.get('port'));
// });
