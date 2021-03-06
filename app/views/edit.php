<?php echo $header; ?>
<div id="container">
<div id="content">
  <section id="details" class="inline">
		<aside>
			<a href="<?php echo uri_to($post->slug); ?>" class="thumb" id="viewImage">
				<img src="<?php echo getImageURL($post->images); ?>" id="imgThumb" />
			</a>
		</aside>
	
		<form action="<?php echo uri_to("edit/".$post->id); ?>" method="post" id="updateImg">
      <input type="hidden" name="slug" value="<?php echo $post->slug; ?>" />
			<h2>Image Properties</h2>
			<label><span>Title</span><input type="text" name="title" value="<?php echo $post->title; ?>" /></label>
      <label><span>Description</span><textarea name="description"><?php echo $post->description; ?></textarea></label>
      <div class="radios">
				<span>Status</span>
				<div class="group">
					<label><input type="radio" value="active" name="status"<?php if($post->status == "active") echo " checked = 'true'"; ?> />Active</label>
					<label><input type="radio" value="inactive" name="status"<?php if($post->status == "inactive") echo " checked = 'true'"; ?> />Inactive</label>
				</div>
			</div>
			<div class="buttongroup">
				<button id="save" type="submit">Update Image</button>
			</div>
		</form>
	</section>
</div>
</div>
<script type="text/javascript" src="http://cdn.staticfile.org/jquery/2.1.0/jquery.min.js"></script>
<?php echo $footer; ?>