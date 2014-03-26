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
    <ul id="accountNav">
      <?php
      if(!Auth::guest()):
      $user = Auth::user();
      ?>
    	<li>
    		<a href="/settings/" title="Edit your settings" id="person">
    			<div class="name"><?php echo $user->nickname; ?></div>
    			<div class="arrow">&nbsp;</div>
    			<div class="avatar">
    				<img width="25" src="//www.gravatar.com/avatar/2b0f1f4e30aa8fa063e8eaec92fcd69c?s=40&amp;d=%2F%2Fd6tnvk3q3qfqi.cloudfront.net%2Fassets%2Fv3.7.1%2F_gfx%2Fminiman.png">
    			</div>
    		</a>
		
    		<ol id="accountMenu">
    			<li class="in"><a href="/settings/" title="Edit your profile">Profile</a></li>
    			<li><a href="/settings/account" title="Manage your account and team">Account &amp; Team</a></li>
    			<li class="upgrade"><a href="https://fireyy.prevue.it/upgrade/" title="Upgrade your account">Upgrade</a></li>
    			<li class="out"><a href="http://<?php echo Config::app('duoshuo_short_name'); ?>.duoshuo.com/logout/?sso=1&redirect_uri=<?php echo Uri::full('logout'); ?>" title="退出登录">退出</a></li>
    		</ol>
    	</li>
      <?php else: ?>
      <span class="ds-login"></span>
    <?php endif; ?>
    </ul>