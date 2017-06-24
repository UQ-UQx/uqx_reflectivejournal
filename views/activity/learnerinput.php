<?php if ($message!='') { ?>
  <div class="alert alert-warning" role="alert"><?php echo $message ?></div>
<?php } ?>
<?php if ($current_role == 'Instructor' || $current_role == 'Administrator') { ?>
  <div class="row">
    <div class="col-xs-12">
      <form role="form" id="editactivity" action="?controller=admin&action=addeditform" method="post">
        <input type="hidden" id="activity_id" name="activity_id" value="<?php echo $activity_id; ?>">
        <input type="hidden" id="course_id" name="course_id" value="<?php echo $course_id; ?>">
        <input type="hidden" id="activity_displaytype" name="activity_displaytype" value="<?php echo $activity_displaytype; ?>">
        <input type="hidden" id="ctx" name="ctx" value="<?php echo $ctx; ?>">
        <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" id="resource_link_id" name="resource_link_id" value="<?php echo $resource_link_id; ?>">
        <input type="hidden" id="consumer_key" name="consumer_key" value="<?php echo $oauth_consumer_key; ?>">
        <input type="hidden" id="lis_result_sourcedid" name="lis_result_sourcedid" value="<?php echo $lis_result_sourcedid; ?>">
        <input type="hidden" id="roles" name="roles" value="<?php echo $roles; ?>">
        <input type="hidden" id="activities_to_include" name="activities_to_include" value="<?php echo $activities_to_include; ?>">
        <div class="pull-right"><button class="btn btn-link" type="submit">Edit LTI Activity</button></div>
      </form>
    </div>
  </div>
<?php } ?>
<div style="background-color:#00aeef;">
<h3 style="color:white"><img src="www/img/writing.png"  alt="Journal Icon" width="53" height="40"/><?php echo $title; ?></h3>
</div>
<?php if ($activity_displaytype=="learnerinput") { ?>
<p><?php echo $introtext; ?></p>
<?php } ?>
<?php if ($activity_displaytype=="showentry") { ?>
<p><?php echo $reviewintro; ?></p>
<?php } ?>

<div class="row">
<?php if ($show_wordcloud==1) { ?>
<div class="col-sm-8">
<?php } ?>
<?php if ($show_wordcloud==0) { ?>
<div class="col-sm-12">
<?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading"><?php echo $entry_title; ?></div>
      <div class="panel-body">
        <form role="form" data-toggle="validator" id="downloadform" action="?controller=activity&action=downloadpdf&format=pdf" method="post">
          <input type="hidden" id="activity_id" name="activity_id" value="<?php echo $activity_id; ?>">
  				<input type="hidden" id="course_id" name="course_id" value="<?php echo $course_id; ?>">
  				<input type="hidden" id="activity_displaytype" name="activity_displaytype" value="<?php echo $activity_displaytype; ?>">
  				<input type="hidden" id="ctx" name="ctx" value="<?php echo $ctx; ?>">
  				<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
  				<input type="hidden" id="resource_link_id" name="resource_link_id" value="<?php echo $resource_link_id; ?>">
  				<input type="hidden" id="consumer_key" name="consumer_key" value="<?php echo $oauth_consumer_key; ?>">
  				<input type="hidden" id="lis_result_sourcedid" name="lis_result_sourcedid" value="<?php echo $lis_result_sourcedid; ?>">
  				<input type="hidden" id="roles" name="roles" value="<?php echo $roles; ?>">
  				<input type="hidden" id="activities_to_include" name="activities_to_include" value="<?php echo $activity_id; ?>">
  				<input type="hidden" id="lis_outcome_service_url" name="lis_outcome_service_url" value="<?php echo $lis_outcome_service_url; ?>">

          <input type="hidden" id="response_id" name="response_id" value="<?php echo $response_id; ?>">
        </form>
        <form role="form" data-toggle="validator" id="inputresponseform" action="?controller=activity&action=save&format=json" method="post">
          <input type="hidden" id="activity_id" name="activity_id" value="<?php echo $activity_id; ?>">
          <input type="hidden" id="course_id" name="course_id" value="<?php echo $course_id; ?>">
          <input type="hidden" id="activity_displaytype" name="activity_displaytype" value="<?php echo $activity_displaytype; ?>">
          <input type="hidden" id="ctx" name="ctx" value="<?php echo $ctx; ?>">
          <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
          <input type="hidden" id="resource_link_id" name="resource_link_id" value="<?php echo $resource_link_id; ?>">
          <input type="hidden" id="consumer_key" name="consumer_key" value="<?php echo $oauth_consumer_key; ?>">
          <input type="hidden" id="lis_result_sourcedid" name="lis_result_sourcedid" value="<?php echo $lis_result_sourcedid; ?>">
          <input type="hidden" id="roles" name="roles" value="<?php echo $roles; ?>">
          <input type="hidden" id="lis_outcome_service_url" name="lis_outcome_service_url" value="<?php echo $lis_outcome_service_url; ?>">

          <input type="hidden" id="response_id" name="response_id" value="<?php echo $response_id; ?>">
          <div class="form-group" >
            <div id="summernote"><?php echo $reflectivetext; ?></div>
            <?php if ($show_wordcount==1) { ?>
            <p>Total word count: <span id="display_count">0</span> words. Words left: <span id="word_left"><?php echo $wordcount_limit; ?></span></p>
            <?php } ?>
            <input type="hidden" name="reflectivetext" id="reflectivetext" />
            <!--<textarea class="form-control" rows="15" name="reflectivetext" id="reflectivetext" required></textarea>-->
            <span class="help-block with-errors"></span>
          </div>
          <div class="btn-group">
            <button type="button" id="submitbtn" class="btn btn-primary">Save</button>
            <?php if ($show_downloadonentry==1) { ?>
            <button type="button" id="downloadbtn" class="btn btn-primary">Download <?php if ($downloadfilename=="Word") {echo "Word Document";} else {echo "PDF";} ?></button>
            <?php } ?>
          </div>
        </form>
        <p></p>
        <div id="validation_container" class="alert alert-danger">
          <strong>The reflective journal entry is blank. Please type in your reflection and then click on the Submit button.</strong>
        </div>
        <div id="feedback_container" class="alert alert-info">
          <strong>Feedback:</strong>
          <br/>
          <div id="feedback"><?php echo $feedback; ?></div>
        </div>
      </div>
    </div>
</div>
<?php if ($show_wordcloud==1) { ?>
  <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">Tag Cloud</div>
        <div class="panel-body" style="min-height:400px;">
            <div id="wordcloud" style="min-width:200px; min-height:400px"></div>
        </div>
      </div>
  </div>
<?php } ?>

</div>
<script type="text/javascript">
    var show_wordcloud = <?php echo $show_wordcloud; ?>;
    var wordcount_limit = <?php echo $wordcount_limit; ?>;

    function count_words(entered_txt){
      var no_words = entered_txt.match(/\S+/g).length;
      return no_words;
    }

    function update_wordcount_dsp(no_words){
      $('#display_count').text(no_words);
      $('#word_left').text(wordcount_limit-no_words);
    }

    $(function() {
      $('#feedback_container').hide();
      $('#validation_container').hide();

      // Render Summernote editor
      //$('#summernote').summernote();

      $('#summernote').summernote({
        height: <?php echo $height; ?>,
        toolbar: [
          // [groupName, [list of button]]
          ['style', ['bold', 'italic', 'clear']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['link', ['linkDialogShow', 'unlink']],
          ['para', ['ul', 'ol', 'paragraph']],
        ]
      });

      $('#summernote').on('summernote.keyup', function (e)
      {
              //console.log($('#summernote').summernote('code'));
              var entered_text = $('#summernote').summernote('code');
              entered_text = entered_text.replace(new RegExp('&nbsp;', 'gi'), " ").replace(new RegExp('<\/li>', 'gi'), " ").replace(new RegExp('<li>', 'gi'), " ").replace(new RegExp('<\/p>', 'gi'), " ").replace(new RegExp('<p>', 'gi'), " ").replace(new RegExp('<br>', 'gi'), " ");

              //console.log(entered_text);
              entered_text = entered_text.replace(/(<([^>]+)>)/ig, "").replace(/( )/, " ");
              //console.log(entered_text);
              var word_count = count_words(entered_text);
              update_wordcount_dsp(word_count);
              $('#feedback_container').hide();
       });

      var frm = $('#inputresponseform');

      var tags = <?php echo $tags; ?>;
      if (tags!="" & show_wordcloud==1)
      {
        $('#wordcloud').jQCloud(tags, {'autoResize':true});
        setTimeout(function(){ $('[data-toggle="tooltip"]').tooltip(); }, 1000);
      }

      $( "#downloadbtn" ).click(function() {
        //submit word or pdf download form
        $( "#downloadform" ).submit();
      };

      $( "#submitbtn" ).click(function() {

        $('#reflectivetext').val($('#summernote').summernote('code'));
        if (($('#reflectivetext').val() == "") || ($('#reflectivetext').val() == "<p><br></p>"))
        {
          $('#feedback_container').hide();
          $('#validation_container').show();
        }
        else{
          $.ajax({
              type: frm.attr('method'),
              url: frm.attr('action'),
              data: frm.serialize(),
              success: function (data) {
                  //$('#feedback').html('');
                  $('#feedback_container').show();
                  $('#validation_container').hide();
                  var json_data = $.parseJSON(data);
                  $('#response_id').val(json_data['response_id']);
                  if (show_wordcloud==1){
                    $('#wordcloud').jQCloud('destroy');
                    $('#wordcloud').jQCloud(json_data['tags'], {'autoResize':true});
                  }
                  setTimeout(function(){ $('[data-toggle="tooltip"]').tooltip(); }, 1000);
              }
          });
        }

      });

    });
</script>
