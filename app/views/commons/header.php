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
    <header id="logo">
      <a href="<?php echo uri_to("/"); ?>" title="Return Home" id="home">Ginta</a>	
    </header>
    <ul id="accountNav">
      <?php
      if(!Auth::guest()):
      $user = Auth::user();
      ?>
    	<li>
    		<a href="<?php echo uri_to("settings"); ?>" title="Edit your settings" id="person">
    			<div class="name"><?php echo $user->nickname; ?></div>
    			<div class="arrow">&nbsp;</div>
    			<div class="avatar">
    				<img width="25" src="<?php echo get_gravatar($user->email, 40); ?>">
    			</div>
    		</a>
		
    		<ol id="accountMenu">
    			<li class="in"><a href="<?php echo uri_to("settings"); ?>" title="Edit your profile">Profile</a></li>
    			<li><a href="<?php echo uri_to("/"); ?>" title="My Images">My Images</a></li>
    			<li class="out"><a href="http://<?php echo Config::app('duoshuo_short_name'); ?>.duoshuo.com/logout/?sso=1&redirect_uri=<?php echo Uri::full('logout'); ?>" title="退出登录">退出</a></li>
    		</ol>
    	</li>
      <?php else: ?>
      <span class="ds-login"></span>
    <?php endif; ?>
    </ul>