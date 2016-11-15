<div class="row">
	<div class="col-xs-3">
		<div id="pieChart"></div>
		<div><b><?php echo $wordclouddisplaytext; ?></b></div>
		<div id="wordcloud" style="width: 550px; height: 350px;"> </div>
	</div>
</div>
<script type="text/javascript">
  /*!
   * Create an array of word objects, each representing a word in the cloud
   */
  var word_array = <?php echo $word_json ?>;

  $(function() {
    // When DOM is ready, select the container element and call the jQCloud method, passing the array of words as the first argument.
    $("#wordcloud").jQCloud(word_array);

		var pie = new d3pie("pieChart", {
			"header": {
				"title": {
					"text": "First Word Classification Summary",
					"fontSize": 22,
					"font": "verdana"
				},
				"titleSubtitlePadding": 12
			},
			"size": {
				"canvasHeight": 400,
				"canvasWidth": 590,
				"pieOuterRadius": "88%"
			},
			"data": {
				"content": <?php echo $classification_json; ?>
			},
			"labels": {
				"outer": {
					"pieDistance": 32
				},
				"inner": {
					"format": "value"
				},
				"mainLabel": {
					"font": "verdana"
				},
				"percentage": {
					"color": "#e1e1e1",
					"font": "verdana",
					"decimalPlaces": 0
				},
				"value": {
					"color": "#e1e1e1",
					"font": "verdana"
				},
				"lines": {
					"enabled": true,
					"color": "#cccccc"
				},
				"truncation": {
					"enabled": true
				}
			},
			"effects": {
				"pullOutSegmentOnClick": {
					"effect": "linear",
					"speed": 400,
					"size": 8
				}
			}
		});
  });
</script>
