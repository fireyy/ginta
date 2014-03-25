<?php echo $header; ?>
<ul id="images" data-submit="/upload/">
  <?php if(isset($posts)){ ?>
  <?php foreach($posts as $post){ ?>
  <li class="image" rel="<?php echo $post->id; ?>" data-token="3">
		<a href="/view/<?php echo $post->slug; ?>" class="dropzone single thumb" rel="<?php echo $post->id; ?>">
			<img src="<?php echo getThumbURL($post->images); ?>" />
		</a>
		<div class="toolbar">
			<a href="/view/<?php echo $post->slug; ?>" class="title"><?php echo $post->title; ?></a>
			<a href="/edit/<?php echo $post->slug; ?>" title="Edit this image" class="contextmenu">Edit</a>
	
			<ul class="optMenu">
				<li><a href="/edit/<?php echo $post->slug; ?>">Edit</a></li>
				<li><a href="/edit/<?php echo $post->slug; ?>/rename">Rename</a></li>
				<li>
					<a class="confirm" href="javascript://">Delete</a>
					<a href="/delete/<?php echo $post->id; ?>" class="goDelete" rel="deleteImg" data-type="<?php echo $post->id; ?>" style="display: inline;">Yeah I'm sure</a>
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
<script type="text/javascript" src="http://cdn.staticfile.org/jquery/2.1.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo asset('assets/js/dropzone.js'); ?>"></script>
<script type="text/javascript" src="<?php echo asset('assets/js/app.js'); ?>"></script>
<?php echo $footer; ?>