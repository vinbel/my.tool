<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="/assets/bootstrap-3.3.7-dist/css/bootstrap.min.css" >
    <script type="text/javascript" src="/assets/js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="/assets/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</head>
<body>
<form method="post" action="<?php echo $post_url;?>">
    <div class="form-group">
        <label for="username">用户名</label>
        <input type="text" class="form-control" name="username" id="usename" placeholder="请输入用户名">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="请输入密码">
    </div>
    <button type="submit" class="btn btn-default">登录</button>
</form>
</body>
</html>