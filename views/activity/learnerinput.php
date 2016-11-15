<?php if ($message!='') { ?>
  <div class="alert alert-warning" role="alert"><?php echo $message ?></div>
<?php } ?>
<h2><?php echo $title; ?></h2>
<p><?php echo $introtext; ?></p>
<?php if ($questionresponse=='')
{ ?>
<div class="row">
<div class="col-xs-4">
  <form role="form" data-toggle="validator" id="inputresponseform" action="?controller=activity&action=save&format=json&resource_link_id=<?php echo $resource_link_id; ?>" method="post">
    <input type="hidden" name="activityId" value="<?php echo $activityId; ?>">
    <input type="hidden" name="userId" value="<?php echo $userId; ?>">
    <div class="form-group" >
      <label for="questionresponse"><?php echo $question; ?></label>
      <input type="text" class="form-control" id="questionresponse" name="questionresponse" placeholder="First Word" required>
      <span class="help-block with-errors"></span>
    </div>
    <button type="submit" id="submitbtn" class="btn btn-default">Submit</button>
  </form>
  <br/>
  <p id="wordcloudintrotext" style="display:none;">
    <b><?php echo $wordclouddisplaytext; ?></b>
  </p>
  <div id="wordcloud" style="width: 550px; height: 350px;"></div>
</div>
</div>
<script type="text/javascript">

    var frm = $('#inputresponseform');

    $('#inputresponseform').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
        // handle the invalid form...
      } else {
        // everything looks good!
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                console.log(data);
                var json_data = $.parseJSON(data);
                //data = [{"weight":1,"text":"bob", "html": {"title": "1"}},{"weight":2,"text":"mum", "html": {"title": "2"}}];
                $("#wordcloud").jQCloud(json_data);
                $("#wordcloudintrotext").show();
                $('#submitbtn').prop('disabled', true);
                $('#questionresponse').prop('disabled', true);
            }
        });
        e.preventDefault();
      }
    })
</script>
<?php }
else {
?>
<label><?php echo $question; ?></label> Your Response:<?php echo $questionresponse; ?>
<p>
  <b><?php echo $wordclouddisplaytext; ?></b>
</p>
<div id="wordcloud" style="width: 550px; height: 350px;"></div>
<script type="text/javascript">
  var word_array = <?php echo $word_json ?>;

  $(function() {
    $("#wordcloud").jQCloud(word_array);
  });
</script>
<?php 
}
?>
