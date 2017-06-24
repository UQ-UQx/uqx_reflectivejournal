<div class="row">
	<div class="col-sm-8">

		<!--<h2>Completed Reflections</h2>-->
		<div class="btn-group">
			<form role="form" id="downloadword" action="?controller=activity&action=<?php if ($downloadformat=="Word") {echo "downloadword";} else {echo "downloadpdf";} ?>&format=<?php if ($downloadformat=="Word") {echo "word";} else {echo "pdf";} ?>" method="post">
				<input type="hidden" id="activity_id" name="activity_id" value="<?php echo $activity_id; ?>">
				<input type="hidden" id="course_id" name="course_id" value="<?php echo $course_id; ?>">
				<input type="hidden" id="activity_displaytype" name="activity_displaytype" value="<?php echo $activity_displaytype; ?>">
				<input type="hidden" id="ctx" name="ctx" value="<?php echo $ctx; ?>">
				<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
				<input type="hidden" id="resource_link_id" name="resource_link_id" value="<?php echo $resource_link_id; ?>">
				<input type="hidden" id="consumer_key" name="consumer_key" value="<?php echo $oauth_consumer_key; ?>">
				<input type="hidden" id="lis_result_sourcedid" name="lis_result_sourcedid" value="<?php echo $lis_result_sourcedid; ?>">
				<input type="hidden" id="roles" name="roles" value="<?php echo $roles; ?>">
				<input type="hidden" id="activities_to_include" name="activities_to_include" value="<?php echo $activity_ids; ?>">
				<input type="hidden" id="lis_outcome_service_url" name="lis_outcome_service_url" value="<?php echo $lis_outcome_service_url; ?>">

				<button class="btn btn-primary" type="submit">Download Word Document</button>
			</form>
		</div>
		<p></p>

		<div class="panel-group" id="accordion">
			<?php if (count($journalentries)==0) { ?>
				No reflections were saved.
			<?php }
			      else {
						?>
						<div class="panel panel-default">
							<div class="panel-body" style="font-family: 'Times New Roman';">
							 <?php foreach ($journalentries as $entry): ?>

									 <?php if ($entry['show_titleinexport']==1) { ?>
										 <h4 class="panel-title" style="text-align: center; font-family: 'Times New Roman'; font-size: 18pt; font-weight: bold;">
											 <?php
											 if ($entry['export_title']!=""){
												echo $entry['export_title'];
											 }
											 else {
												 echo $entry['title'];
											 }
											 ?>
										 </h4>
									 <?php } ?>
									 <div style="font-size: 12pt; font-family: 'Times New Roman';"> <!-- text-indent: 3em;-->
									 <?php echo htmlspecialchars_decode($entry['reflectivetext']) ?>
								 	 </div>
							<?php endforeach ?>
						</div>
					</div>
			<?php }?>
		</div>

	</div>
	<?php if ($show_wordcloud==1) { ?>
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
	<?php } ?>
</div>
<script type="text/javascript">
  /*!
   * Create an array of word objects, each representing a word in the cloud
   */
//var word_array = <?php echo $tags ?>;
	var show_wordcloud = <?php echo $show_wordcloud; ?>;
  $(function() {
    // When DOM is ready, select the container element and call the jQCloud method, passing the array of words as the first argument.
		var tags = <?php echo $tags; ?>;
		if (tags!="" & show_wordcloud==1)
		{
			$('#wordcloud').jQCloud(tags, {'autoResize':true});
			setTimeout(function(){ $('[data-toggle="tooltip"]').tooltip(); }, 1000);
		}

  });
</script>
