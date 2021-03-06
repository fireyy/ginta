<?php echo $header; ?>
<div id="container">
  <ul id="images" data-submit="<?php echo uri_to("upload/"); ?>">
    <?php if(isset($posts)){ ?>
    <?php foreach($posts as $post){ ?>
    <li class="image" rel="<?php echo $post->id; ?>" data-token="<?php echo $post->id; ?>">
  		<a href="<?php echo uri_to($post->slug); ?>" class="dropzone single thumb" rel="<?php echo $post->id; ?>">
  			<img src="<?php echo getThumbURL($post->images); ?>" />
  		</a>
  		<div class="toolbar">
  			<a href="<?php echo uri_to($post->slug); ?>" class="title"><?php echo $post->title; ?></a>
  			<a href="<?php echo uri_to("edit/".$post->slug); ?>" title="Edit this image" class="contextmenu">Edit</a>
	
  			<ul class="optMenu">
  				<li><a href="<?php echo uri_to("edit/".$post->slug); ?>">Edit</a></li>
  				<li>
  					<a class="confirm" href="javascript://">Delete</a>
  					<a href="<?php echo uri_to("ajax/delete/".$post->id); ?>" class="goDelete" rel="deleteImg" data-type="<?php echo $post->id; ?>" style="display: inline;">Yeah I'm sure</a>
  				</li>
  			</ul>
  		</div>
  	</li>
    <?php } ?>
    <?php } ?>
  	<li class="filechoose" id="uploadSingle">
  		<a href="javascript:void(0);" title="Click or drag here">Drag images here to upload <em>Click or drag up to 15 images at a time</em></a>
  	</li>
  </ul>
</div>
<script type="text/javascript" src="http://cdn.staticfile.org/jquery/2.1.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo asset('assets/js/dropzone.js'); ?>"></script>
<script type="text/javascript" src="<?php echo asset('assets/js/app.js'); ?>"></script>
<?php echo $footer; ?>