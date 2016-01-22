$(document).ready(function(){
    var socket = io.connect('127.0.0.1:3000');//设置监听端口
    var from = $.cookie('user');
    var to = 'all';
    //发送用户上线信号
    socket.emit('online', {user: from});
    socket.on('online', function(data) {
        //显示系统消息
        if(data.user != from ) {
            var sys = join(data.user);
        } else {
            var sys =join('你');
        }
        $("#message").append(sys);
        //刷新用户在线列表
        flushUsers(data.users);
        //显示正在对谁说话
        showSayTo();
    });
    //接收消息
    socket.on('say', function(data) {
        //对所有人说
        if(data.to=='all') {
            console.log(data.from);
            $("#message").append(serviceSection(data.from,data.msg));
        }
        if(data.to==from) {  //对你说
            recivePernalMsg(data);
            $("#message").append(serviceSection(data.from,data.msg));
        }
    });
    //有人下线
    socket.on('offline', function(data) {
        var sys = offline(data.user); //'<div style="color:#f00">系统(' + now() + '):' + '用户 ' + data.user + ' 下线了。</div>';
        $("#message").append(sys);
        flushUsers(data.users);
        if(data.user==to) {
            to == 'all';
        }
        showSayTo();
    });
    //服务器关闭
    socket.on('disconnect', function(){
        var sys = error();
        $("#message").append(sys);
        $("#list").empty();
    });
    //服务器瘫痪或关闭
    socket.on('disconnect', function(){
        var sys = restart();
        $("#message").append(sys);
        socket.emit('online', {user:from});
    });

    $("#list").on('dblclick','li',function(){
        //如果不是双击自己的名字
        if($(this).attr('alt')!=from){
            to = $(this).attr('alt');
            //清楚之前的选中效果
            $("#list > li").removeClass('sayingto');
            //选中的用户添加效果
            $(this).addClass('sayingto');
            //刷新正在对谁说话
            showSayTo();
        }
    });
    //刷新在线用户列表和数据
    function flushUsers(users) {
        //当前用户数
        $('#count').empty();
        var j=0;
        //清空之前的用户列表，添加“所有人”选项并默认为灰色选择效果
        $("#list").empty().append('<li title="双击聊天" alt="all" class="sayingto" onselectstart="return false">所有人</li>');
        //遍历生成用户在线列表
        for(var i in users) {
            j++;
            $("#list").append('<li alt="' + users[i] + '" title="双击聊天" onselectstart="return false">' + users[i] + '</li>');
        }
        $('#count').append(j);
    }

   //点击发送消息
    $("#say").click(function(){
       sendMsg();
    });

    //点击退出
    $("#logout").click(function(){
        //有人下线
        socket.emit('logout',{user: from});
        location.href='index';
        return false;
    })

    /**************回车发送信息*************/
    document.getElementById('input_content').onkeydown=function(e)
    {
        if(e.keyCode==13)
        {
           sendMsg();
        }
    }

    //显示对谁说
    function showSayTo() {
        $("#from").html(from);
        $("#showusername").html(from);
        $("#to").html(to=="all" ? "所有人" : to);
    }

    function now() {
        var date = new Date(),
            time = date.getFullYear() + '-' + (date.getMonth() + 1) + '-'
                + date.getDate() + ' ' + date.getHours() + ':'
                + (date.getMinutes() < 10 ? ('0' + date.getMinutes()) : date.getMinutes())
                + ":" + (date.getSeconds() < 10 ? ('0' + date.getSeconds()) : date.getSeconds());
        return time;
    }
    //接受私信
    function recivePernalMsg(data)
    {
        //来信人高亮
        $("li[alt='"+data.from+"']").css("background",'bisque');
        //产生新的对话框

    }
    //发送消息事件
    function sendMsg()
    {
        var $msg = $("#input_content").html();
        if($msg=='')
            return;
        if(to=='all') {
            $("#message").append(userSection('你',$msg));;
        } else {
            $("#message").append(userSection('你对'+to+'说：',$msg));;
        }
       //内容区滚动条保持在最底部
        $("#message").scrollTop($("#message").height());
        //发送消息到服务器
        socket.emit('say', {from:from, to:to, msg: $msg});
        //清空输入框并获得焦点
        $("#input_content").html("").focus();
    }
    //人家说的内容
    function serviceSection(service,message)
    {
        var section='<section class="service"><span>'+service+'</span><div>'+message+'</div></section>';
        return section;
    }
    //当前用户的发送内容
    function userSection(user,message)
    {
        var section='<section class="user"><span>'+user+'</span><div>'+message+'</div></section>';
        return section;
    }
    //有用户加入了聊天室
    function join(user)
    {
        var section='<section class="system J-mjrlinkWrap J-cutMsg"><div class="msg-system">'+now()+''+user+'加入了聊天室</div></section>';
        return section;
    }
    //有用户下线
    function offline(user)
    {
        var section='<section class="system J-mjrlinkWrap J-cutMsg"><div class="msg-system">'+now()+''+user+'离开了聊天室</div></section>';
        return section;
    }
    //服务器连接失败
    function error()
    {
        var section='<section class="system J-mjrlinkWrap J-cutMsg"><div class="msg-system">系统:服务器连接失败</div></section>';
        return section;
    }
    //系统瘫痪或关闭
    function restart()
    {
        var section='<section class="system J-mjrlinkWrap J-cutMsg"><div class="msg-system">系统:连接失败</div></section>';
        return section;
    }

});

