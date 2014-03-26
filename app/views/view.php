<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $post->title; ?></title>
	<meta name="author" content="">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="<?php echo asset('assets/css/view.css'); ?>" type="text/css">
</head>
<body>
<div id="container">
	<div id="image">
		<div id="artwork">
			<img src="<?php echo getImageURL($post->images); ?>" />
		</div>
	</div>
</div>

<ul id="nav">
	<li class="return"><a href="https://fireyy.prevue.it/pro/cjz" data-original-title="Return to project">Return to project</a></li>
	<li class="edit"><a href="https://fireyy.prevue.it/edit/hullxk" data-original-title="Edit this image">Edit this image</a></li>
	<li class="annotate"><a href="#" id="addnotelink" data-original-title="Add annotation">Add annotation</a></li>
	<li id="tip" style="display:none;"></li>
</ul>

<div id="noteform">
	<div class="inner">
		<div id="response"></div>
		<form id="NoteAddForm" method="post" action="<?php echo uri_to("/ajax/add/".$post->id); ?>">	
			<textarea name="data[note]" autofocus="true" placeholder="Your annotation..." id="NoteNote" /></textarea>
			<input name="data[x1]" type="hidden" value="" id="NoteX1" />
			<input name="data[y1]" type="hidden" value="" id="NoteY1" />
			<input name="data[height]" type="hidden" value="" id="NoteHeight" />
			<input name="data[width]" type="hidden" value="" id="NoteWidth" />
			<input name="data[author]" type="hidden" value="<?php echo $post->author_id; ?>" />
			<button type="submit">Add annotation</button>
			<a href="javascript://" id="cancelnote">Cancel</a>
		</form>
	</div>
	<span class="point">&nbsp;</span>
</div>
<script type="text/javascript" src="http://cdn.staticfile.org/jquery/2.1.0/jquery.min.js"></script>
<script src="<?php echo asset('assets/js/annotation.area.js'); ?>"></script>
<script src="<?php echo asset('assets/js/jquery-migrate-1.2.1.js'); ?>"></script>
<script src="<?php echo asset('assets/js/annotations.js'); ?>"></script>
<script type="text/javascript">notes=<?php echo Json::encode($note); ?>;</script>
<script>
$(document).ready(function(){ 
  $('#nav a').hover(function(){
    $('#tip').stop().html($(this).attr('data-original-title')).fadeIn(10,function(){
      $('#tip').css('opacity','1');
    })
  },function(){
    $('#tip').fadeOut(10,function(){
      $('#tip');
    });
  }); 
});
</script>
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