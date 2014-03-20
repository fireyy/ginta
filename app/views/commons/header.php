<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Ginta.me</title>
		<meta name="author" content="">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" href="<?php echo asset('assets/css/style.css'); ?>" type="text/css">
	</head>
	<body>
    <?php if(!$guest){ ?>
      <p>已登录 <?php echo $user->id; ?>, <a href="http://<?php echo Config::app('duoshuo_short_name'); ?>.duoshuo.com/logout/?sso=1&redirect_uri=<?php echo Uri::full('logout'); ?>">退出</a></p>
    <?php }else{ ?>
      <div class="ds-login"></div>
    <?php } ?>