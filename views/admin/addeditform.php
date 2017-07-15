<div class="jumbotron">
  <?php if ($message!='') { ?>
    <div class="alert alert-warning" role="alert" id='notcreated_message'><?php echo $message ?></div>
  <?php } ?>
  <?php if ($admin_msg!='') { ?>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Show Instructor/Administrator Instructions
            </a>
          </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
            <div class="alert alert-warning" role="alert"><?php echo $admin_msg ?></div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <form id="addeditform" role="form" data-toggle="validator" action="?controller=admin&action=update&format=json" method="post">
    <input type="hidden" id="activity_id" name="activity_id" value="<?php echo $activity_id; ?>">
    <input type="hidden" id="course_id" name="course_id" value="<?php echo $course_id; ?>">
    <input type="hidden" id="activity_displaytype" name="activity_displaytype" value="<?php echo $activity_displaytype; ?>">
    <input type="hidden" id="ctx" name="ctx" value="<?php echo $ctx; ?>">
    <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
    <input type="hidden" id="resource_link_id" name="resource_link_id" value="<?php echo $resource_link_id; ?>">
    <input type="hidden" id="consumer_key" name="consumer_key" value="<?php echo $oauth_consumer_key; ?>">
    <input type="hidden" id="lis_result_sourcedid" name="lis_result_sourcedid" value="<?php echo $lis_result_sourcedid; ?>">
    <input type="hidden" id="roles" name="roles" value="<?php echo $roles; ?>">
    <h2>Add/Edit Activity</h2>
    <div id="updatemessage" class="alert alert-warning" role="alert"></div>
    <div class="form-group">
      <label>Activity ID</label>
      <p class="form-control-static"><span id="activityid_dsp"><?php if ($activity_id!=-1) { ?> <?php echo $activity_id; ?><?php } ?></span></p>
    </div>
    <div class="form-group">
      <label for="title">Title</label>
      <input type="input" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
    </div>
    <div class="form-group">
      <label for="title">Entry Title</label> (* required)
      <input type="input" class="form-control" id="entry_title" name="entry_title" value="<?php echo $entry_title; ?>">
    </div>
    <div class="form-group">
      <label for="introtext">Intro Text</label> (* required)
      <textarea class="form-control" rows="3" id="introtext" name="introtext" required><?php echo $introtext; ?></textarea>
    </div>
    <div class="form-group">
      <label for="reviewintro">Review Intro Text</label>
      <textarea class="form-control" rows="3" id="reviewintro" name="reviewintro"><?php echo $reviewintro; ?></textarea>
    </div>
    <div class="form-group">
      <label for="feedback">Feedback</label> (* required)
      <textarea class="form-control" rows="3" name="feedback" id="feedback" required><?php echo $feedback; ?></textarea>
    </div>
    <div class="form-group">
      <label for="show_wordcloud">Show Word Cloud: </label>
      <select class="form-control" id="show_wordcloud" name="show_wordcloud">
        <option value="True" <?php if ($show_wordcloud==1) { ?> <?php echo "selected"; ?><?php } ?>>Yes</option>
        <option value="False" <?php if ($show_wordcloud==0) { ?> <?php echo "selected"; ?><?php } ?>>No</option>
      </select>
    </div>
    <div class="form-group">
      <label for="show_titleinexport">Include Title when Exported:</label>
      <select class="form-control" id="show_titleinexport" name="show_titleinexport">
        <option value="True" <?php if ($show_titleinexport==1) { ?> <?php echo "selected"; ?><?php } ?>>Yes</option>
        <option value="False" <?php if ($show_titleinexport==0) { ?> <?php echo "selected"; ?><?php } ?>>No</option>
      </select>
    </div>
    <div class="form-group">
      <label for="export_title">Custom Export Title</label>
      <input type="input" class="form-control" id="export_title" name="export_title" value="<?php echo $export_title; ?>">
    </div>
    <div class="form-group">
      <label for="exportdisplay">Export Page Display Type:</label>
      <select class="form-control" id="exportdisplay" name="exportdisplay">
        <option value="Expanded" <?php if ($exportdisplay=="Expanded") { ?> <?php echo "selected"; ?><?php } ?>>Expanded</option>
        <option value="Collapsed" <?php if ($exportdisplay=="Collapsed") { ?> <?php echo "selected"; ?><?php } ?>>Collapsed</option>
      </select>
    </div>
    <div class="form-group">
      <label for="title">Word Count Limit</label>
      <input type="number" class="form-control" id="wordcount_limit" name="wordcount_limit" value="<?php echo $wordcount_limit; ?>" required>
    </div>
    <div class="form-group">
      <label for="show_wordcount">Show Word Count:</label>
      <select class="form-control" id="show_wordcount" name="show_wordcount">
        <option value="True" <?php if ($show_wordcount==1) { ?> <?php echo "selected"; ?><?php } ?>>Yes</option>
        <option value="False" <?php if ($show_wordcount==0) { ?> <?php echo "selected"; ?><?php } ?>>No</option>
      </select>
    </div>
    <div class="form-group">
      <label for="title">Text Editor Height (in pixels)</label>
      <input type="number" class="form-control" id="height" name="height" value="<?php echo $height; ?>" required>
    </div>
    <div class="form-group">
      <label for="show_wordcount">Show Download Button on Entry UI:</label>
      <select class="form-control" id="show_downloadonentry" name="show_downloadonentry">
        <option value="True" <?php if ($show_downloadonentry==1) { ?> <?php echo "selected"; ?><?php } ?>>Yes</option>
        <option value="False" <?php if ($show_downloadonentry==0) { ?> <?php echo "selected"; ?><?php } ?>>No</option>
      </select>
    </div>
    <div class="form-group">
      <label for="type">Download Format:</label>  (* required)
      <select class="form-control" id="downloadformat" name="downloadformat">
        <option value="Word" <?php if ($downloadformat=='Word') { ?> <?php echo "selected"; ?><?php } ?>>Word</option>
        <option value="PDF" <?php if ($downloadformat=='PDF') { ?> <?php echo "selected"; ?><?php } ?>>PDF</option>
      </select>
    </div>
    <div class="form-group">
      <label for="title">Download Filename</label> (* required)
      <input type="input" class="form-control" id="downloadfilename" name="downloadfilename" value="<?php echo $downloadfilename; ?>">
    </div>
    <button type="submit" id="submitbtn" class="btn btn-default">Save</button>
  </form>
</div>
<script type="text/javascript">
    $('#updatemessage').hide();
    var frm = $('#addeditform');
    //$('#form').validator().on('submit', function (e)
    $('#addeditform').validator().on('submit', function (e) {
      $('#updatemessage').hide();
      if (e.isDefaultPrevented()) {
        // handle the invalid form...
      } else {
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                var json_data = $.parseJSON(data);
                $('#activityid_dsp').html(json_data['activity_id']);
                $('#activity_id').val(json_data['activity_id']);
                $('#notcreated_message').hide();
                $('#updatemessage').html(json_data['message']);
                $('#updatemessage').fadeIn( "slow" );
            },
            error: function() {
                $('#updatemessage').text('An error occurred while saving the activity you entered. Please try again.');
            }
        });
        e.preventDefault();
      }
    })
</script>
