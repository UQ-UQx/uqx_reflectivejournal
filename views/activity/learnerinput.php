<?php if ($message!='') { ?>
  <div class="alert alert-warning" role="alert"><?php echo $message ?></div>
<?php } ?>
<h2><?php echo $title; ?></h2>
<p><?php echo $introtext; ?></p>

<div class="row">
<div class="col-sm-12">
  <form role="form" data-toggle="validator" id="inputresponseform" action="?controller=activity&action=save&format=json&resource_link_id=<?php echo $resource_link_id; ?>" method="post">
    <input type="hidden" name="activityId" value="<?php echo $activityId; ?>">
    <input type="hidden" name="userId" value="<?php echo $userId; ?>">
    <input type="hidden" name="responseId" value="<?php echo $response_id; ?>">
    <div class="form-group" >
      <label for="reflectivetext">Journal Entry:</label>
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
  <div id="feedback_container" class="alert alert-info">
    <strong>Feedback:</strong>
    <br/>
    <div id="feedback"></div>
  </div>
</div>
</div>
<script type="text/javascript">

    $(function() {
      $('#feedback_container').hide();

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

      $( "#submitbtn" ).click(function() {
        $('#reflectivetext').val($('#summernote').summernote('code'));
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                $('#feedback').html('<?php echo $feedback; ?>');
                $('#feedback_container').show();
                //console.log(data);
                //var json_data = $.parseJSON(data);
                // $('#submitbtn').prop('disabled', true);
                // $('#questionresponse').prop('disabled', true);
            }

        });
      });

    });
</script>
