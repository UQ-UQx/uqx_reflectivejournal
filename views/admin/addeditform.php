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

  <form id="addeditform" role="form" data-toggle="validator" action="?controller=admin&action=update&format=json&resource_link_id=<?php echo $resource_link_id; ?>" method="post">
    <input type="hidden" id="activityId" name="activityId" value="<?php echo $activityId; ?>">
    <input type="hidden" id="courseId" name="courseId" value="<?php echo $courseId; ?>">
    <h2>Add/Edit Activity</h2>
    <div id="updatemessage" class="alert alert-warning" role="alert"></div>
    <div class="form-group">
      <label>Activity ID</label>
      <p class="form-control-static"><span id="activityid_dsp"><?php if ($activityId!=-1) { ?> <?php echo $activityId; ?><?php } ?></span></p>
    </div>
    <div class="form-group">
      <label for="title">Title</label>
      <input type="input" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
    </div>
    <div class="form-group">
      <label for="introtext">Intro Text</label> (* required)
      <textarea class="form-control" rows="3" name="introtext" required><?php echo $introtext; ?></textarea>
    </div>
    <div class="form-group">
      <label for="question">Question</label> (* required)
      <textarea class="form-control" rows="3" name="question" id="question" required><?php echo $question; ?></textarea>
    </div>
    <div class="form-group">
      <label for="wordclouddisplaytext">Word Cloud Display Text</label> (* required)
      <textarea class="form-control" rows="3" name="wordclouddisplaytext" id="wordclouddisplaytext" required><?php echo $wordclouddisplaytext; ?></textarea>
    </div>
    <div class="form-group">
      <label for="grade">Grade</label> (* number required)
      <input type="number" class="form-control" id="grade" name="grade" data-error="A number must be entered." required value="<?php echo $grade; ?>">
      <div class="help-block with-errors"></div>
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
                $('#activityid_dsp').html(json_data['activityID']);
                $('#activityId').val(json_data['activityID']);
                $('#notcreated_message').hide();
                $('#updatemessage').html(json_data['message']);
                $('#updatemessage').fadeIn( "slow" )
            },
            error: function() {
                $('#updatemessage').text('An error occurred while saving the activity you entered. Please try again.');
            }
        });
        e.preventDefault();
      }
    })
</script>
