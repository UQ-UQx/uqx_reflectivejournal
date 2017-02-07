<div class="row">
	<div class="col-sm-8">
		<h2>Completed Reflections</h2>
		<div class="btn-group">
			<a href="?controller=activity&action=downloadword&format=word&resource_link_id=<?php echo $resource_link_id; ?>" class="btn btn-primary" role="button">Download Word Document</a>
		</div>
		<p></p>
		<div class="panel-group" id="accordion">
			<?php if (count($journalentries)==0) { ?>
				No reflections were saved.
			<?php }
			      else {
							 foreach ($journalentries as $entry): ?>
							 <div class="panel panel-default">
								 <div class="panel-heading">
									 <h4 class="panel-title">
										 <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $entry['activity_id'] ?>">
										 <?php echo $entry['title'] ?></a>
									 </h4>
								 </div>
								 <div id="collapse<?php echo $entry['activity_id'] ?>" class="panel-collapse collapse">
									 <div class="panel-body"><?php echo htmlspecialchars_decode($entry['reflectivetext']) ?></div>
								 </div>
							 </div>
							 </div>
							<?php endforeach ?>

			<?php }?>
		</div>
	<div class="col-sm-4">
		<?php if (count($journalentries)>0) { ?>
			<div class="panel panel-default">
			  <div class="panel-heading">Tag Cloud</div>
			  <div class="panel-body">
					<div id="wordcloud" style="min-width:200px; min-height:400px"></div></div>
				</div>
			</div>
		<?php } ?>

</div>
<script type="text/javascript">
  /*!
   * Create an array of word objects, each representing a word in the cloud
   */
//var word_array = <?php echo $tags ?>;

  $(function() {
    // When DOM is ready, select the container element and call the jQCloud method, passing the array of words as the first argument.
		var tags = <?php echo $tags; ?>;
		if (tags!="")
		{
			$('#wordcloud').jQCloud(tags, {'autoResize':true});
			setTimeout(function(){ $('[data-toggle="tooltip"]').tooltip(); }, 1000);
		}

  });
</script>
