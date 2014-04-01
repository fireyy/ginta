<?php echo $header; ?>
<div id="container">
<div id="content">
  <section id="details" class="inline">
		<aside>
			<a href="<?php echo uri_to("/"); ?>" class="thumb avatar" id="viewImage">
				<img src="<?php echo get_gravatar($user->email, 164); ?>" id="imgThumb" />
			</a>
		</aside>
	
		<form action="<?php echo uri_to("settings"); ?>" method="post" id="updateImg">
			<h2>Account Detail</h2>
			<label><span>Name</span><input type="text" name="nickname" value="<?php echo $user->nickname; ?>" /></label>
      <label><span>Email</span><input type="text" name="email" value="<?php echo $user->email; ?>" /></label>
      <label><span>Bio</span><textarea name="bio"><?php echo $user->bio; ?></textarea></label>
			<div class="buttongroup">
				<button id="save" type="submit">Update Data</button>
			</div>
		</form>
	</section>
</div>
</div>
<script type="text/javascript" src="http://cdn.staticfile.org/jquery/2.1.0/jquery.min.js"></script>
<?php echo $footer; ?>