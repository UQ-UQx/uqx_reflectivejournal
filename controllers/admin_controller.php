<?php

  require_once('controllers/base_controller.php');
  require_once('lib/encrypt.php');

  class AdminController extends BaseController {

    protected $context_vars;

    public function addeditform() {
      $db = Db::instance();
      $activity_id = $this->context_vars['activity_id'];
      $user_id = $this->context_vars['user_id'];
      $course_id = $this->context_vars['course_id'];
      $activity_displaytype = $this->context_vars['activity_displaytype'];

      include ('config.php');
      $secret_key = $config['secret_key'];

      $ctx = 1;
      $roles = encrypt($secret_key, $this->context_vars['roles']);

      $resource_link_id = encrypt($secret_key, $this->context_vars['resource_link_id']);
      $oauth_consumer_key = encrypt($secret_key, $this->context_vars['oauth_consumer_key']);
      $lis_result_sourcedid = encrypt($secret_key, $this->context_vars['lis_result_sourcedid']);

      $title = "";
      $introtext = "";
      $reviewintro = "";
      $entry_title = "Journal Entry";
      $feedback = "";
      $type = "text";
      $grade = 0;
      $activityobj = $db->read( 'activity', $activity_id)->fetch();
      $message = "";
      $show_wordcloud = True;
      $wordcount_limit = 0;
      $admin_msg = '<p>You have “Staff” access to this course and can edit the text of this activity. Please view the live version and switch to a student role to view the activity as a student.</br>This LTI tool can be used and customised in multiple edX course locations. A unique activity_id is required and must be set in Custom Parameters within the Edit LTI Block screen. When creating a new AB Split Poll activity, set the activity_id to –1 (e.g. [“activity_id=-1”]). The add/edit activity screen will be displayed where you can add a title, intro screen and final screens. Once the activity is saved a new activity_id will be displayed. The new activity_id should be updated in Custom Parameters within the Edit LTI Block screen (e.g. ["activity_id=7”]).</p>';

      try {
    		$activityobj = $db->read( 'activity', $activity_id)->fetch();
    		if(empty($activityobj)) {
          $activity_id = -1;
    			$message .= '<p>This activity does not exist and will need to be created. Please follow the Admin/Instructor Instructions.</p>';
    		}
    		else {
          $title = $activityobj->title;
          $entry_title = $activityobj->entry_title;
          $introtext = $activityobj->introtext;
          $reviewintro = $activityobj->reviewintro;
          $feedback = $activityobj->feedback;
          $type = $activityobj->type;
          $show_wordcloud = $activityobj->show_wordcloud;
          $wordcount_limit = $activityobj->wordcount_limit;
    		}
    	}
    	catch(Exception $e) {
    		$message .= '<p>' . $e->getMessage() . '</p>';
    	}

      require_once('views/admin/addeditform.php');
    }

    public function update() {
      $db = Db::instance();
      $activity_id = $_POST['activity_id'];
      $course_id = $_POST['course_id'];
      $ctx = 1;
      $user_id = $this->context_vars['user_id'];
      $resource_link_id = $this->context_vars['resource_link_id'];
      $oauth_consumer_key = $this->context_vars['oauth_consumer_key'];
      $lis_result_sourcedid = $this->context_vars['lis_result_sourcedid'];

      $title = $_POST['title'];
      $entry_title = $_POST['entry_title'];
      $introtext = $_POST['introtext'];
      $reviewintro = $_POST['reviewintro'];
      $feedback = $_POST['feedback'];
      $type = $_POST['type'];
      $show_wordcloud_str = $_POST['show_wordcloud'];
      $wordcount_limit = $_POST['wordcount_limit'];
      $show_wordcloud = False;
      if ($show_wordcloud_str=="True")
      {
        $show_wordcloud = True;
      }

      $data = array('title' => $title, 'entry_title' => $entry_title, 'introtext' => $introtext, 'reviewintro' => $reviewintro, 'feedback' => $feedback, 'type' => $type, 'show_wordcloud' => $show_wordcloud, 'wordcount_limit' => $wordcount_limit);
      if ($activity_id!=-1)
      {
        $data['activity_id'] = $activity_id;
      }
      $addedit_mode = "add";
      $id = 0;
      if (array_key_exists('activity_id', $data)) {
        $addedit_mode = "edit";
        $id = $data['activity_id'];
      }

      if ($addedit_mode == "add")
      {
        $db->create( 'activity', $data );
        $id = $db->id(); // Get last inserted id
      }
      else {
        $db->update( 'activity', $data);
      }
      echo '{"activity_id":' . $id . ', "message": "The activity was updated."}';
    }
  }
?>
