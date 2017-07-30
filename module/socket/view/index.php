<?php
session_start();

if(!isset($_SESSION['user'])) header("location:login.php");
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="/assets/bootstrap-3.3.7-dist/css/bootstrap.min.css" >
    <script type="text/javascript" src="/assets/js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="/assets/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</head>
<body>
<h1><?php echo $_SESSION['user']['user_name']; ?></h1>
<form method="post" href="javascript:void(0);" onsubmit="return false">
    <div class="form-group">
        <label for="exampleInputEmail1">内容：</label>
        <input type="text" class="form-control" id="words" placeholder="请输入内容">
    </div>

    <button type="submit" class="btn btn-default" onclick="send_sms()">发送</button>
</form>

<div id="history" style="background: #f00;">

</div>
<script>
    var my_fd = false;
    var room_id = 1;//先写死
    var user_id = <?php echo $_SESSION['user']['user_id'];?>;
    var wsServer = 'ws://my.vm:9501';
    var websocket = new WebSocket(wsServer);
    websocket.onopen = function (evt) {
        console.log("Connected to WebSocket server.");
        var obj = {"user_id" : user_id, "room_id" : room_id, "act" : "init", "msg" : ""};
        websocket.send(JSON.stringify(obj));
    };

    websocket.onclose = function (evt) {
        console.log("Disconnected");
    };

    websocket.onmessage = function (evt) {
        var obj = str_to_json(evt.data);

        if(!my_fd) my_fd = obj.fd;

        if(user_id == obj.msg_user_id) {
            $('#history').append('<div>你：' + obj.data +'</div>')
        } else {
            $('#history').append('<div style="background-color:blue">' + obj.username + '：' + obj.data +'</div>')

        }

        console.log('Retrieved data from server: ' + evt.data);
    };

    websocket.onerror = function (evt, e) {
        console.log('Error occured: ' + evt.data);
    };

    function send_sms() {
        var msg = $('#words').val();
        $('#words').val("");
        var obj = {"user_id" : user_id, "room_id" : room_id, "act" : "msg", "msg": msg};
        websocket.send(JSON.stringify(obj));
    }

    function str_to_json(str) {
        return obj = JSON.parse(str);
    }

</script>
</body>

</html>