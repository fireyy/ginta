<?php echo $header; ?>
<ul id="images" data-submit="/upload/">
	<li class="filechoose" id="uploadSingle">
		<a href="/upload/" title="Click or drag here">Drag images here to upload <em>Click or drag up to 15 images at a time</em></a>
	</li>
</ul>
<script type="text/javascript" src="http://cdn.staticfile.org/jquery/2.1.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo asset('assets/js/dropzone.js'); ?>"></script>
<script type="text/javascript" src="<?php echo asset('assets/js/app.js'); ?>"></script>
<?php echo $footer; ?>