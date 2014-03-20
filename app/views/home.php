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
    <?php var_dump($guest); ?>
    <div class="ds-login"></div>
<script>
var duoshuoQuery = {
   short_name: "ginta", 
   sso: { 
       login: "http://ginta.me/login/",
       logout: "http://ginta.me/logout/"
   }};

(function() {
    var ds = document.createElement('script');
    ds.type = 'text/javascript';ds.async = true;
    ds.src = 'http://static.duoshuo.com/embed.js';
    ds.charset = 'UTF-8';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ds);
})();
</script>
    </body>
</html>