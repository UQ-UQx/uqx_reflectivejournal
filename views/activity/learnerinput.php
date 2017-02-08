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
        <div class="pull-right"><button class="btn btn-link" type="submit">Edit LTI Activity</button></div>
      </form>
    </div>
  </div>
<?php } ?>

<h2><img src="www/img/journal_icon.png"  alt="Journal Icon" width="38" height="38"/><?php echo $title; ?></h2>
<p><?php echo $introtext; ?></p>

<div class="row">
<div class="col-sm-8">
    <div class="panel panel-default">
      <div class="panel-heading">Journal Entry</div>
      <div class="panel-body">
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
            <input type="hidden" name="reflectivetext" id="reflectivetext" />
            <!--<textarea class="form-control" rows="15" name="reflectivetext" id="reflectivetext" required></textarea>-->
            <span class="help-block with-errors"></span>
          </div>
          <div class="btn-group">
            <button type="button" id="submitbtn" class="btn btn-primary">Save</button>
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
<div class="col-sm-4">
    <div class="panel panel-default">
      <div class="panel-heading">Tag Cloud</div>
      <div class="panel-body" style="min-height:400px;">
          <div id="wordcloud" style="min-width:200px; min-height:400px"></div>
      </div>
    </div>
</div>
</div>
<script type="text/javascript">

    $(function() {
      $('#feedback_container').hide();
      $('#validation_container').hide();

      // Render Summernote editor
      //$('#summernote').summernote();

      $('#summernote').summernote({
        height: 400,
        toolbar: [
          // [groupName, [list of button]]
          ['style', ['bold', 'italic', 'clear']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['link', ['linkDialogShow', 'unlink']],
          ['para', ['ul', 'ol', 'paragraph']],
        ]
      });

      var frm = $('#inputresponseform');

      var tags = <?php echo $tags; ?>;
      if (tags!="")
      {
        $('#wordcloud').jQCloud(tags, {'autoResize':true});
        setTimeout(function(){ $('[data-toggle="tooltip"]').tooltip(); }, 1000);
      }

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
                  $('#wordcloud').jQCloud('destroy');
                  $('#wordcloud').jQCloud(json_data['tags'], {'autoResize':true});
                  setTimeout(function(){ $('[data-toggle="tooltip"]').tooltip(); }, 1000);
              }
          });
        }

      });

    });
</script>
