<?php

  require_once('controllers/base_controller.php');

  class AdminController extends BaseController {

    protected $context_vars;

    public function addeditform() {
      $db = Db::instance();
      $activityId = $this->context_vars['activityId'];
      $userId = $this->context_vars['userId'];
      $courseId = $this->context_vars['courseId'];
      $resource_link_id = $this->context_vars['resource_link_id'];
      $title = "";
      $introtext = "";
      $feedback = "";
      $type = "text";
      $grade = 0;
      $activityobj = $db->read( 'activity', $activityId)->fetch();
      $message = "";
      $admin_msg = '<p>You have “Staff” access to this course and can edit the text of this activity. Please view the live version and switch to a student role to view the activity as a student.</br>This LTI tool can be used and customised in multiple edX course locations. A unique activity_id is required and must be set in Custom Parameters within the Edit LTI Block screen. When creating a new AB Split Poll activity, set the activity_id to –1 (e.g. [“activity_id=-1”]). The add/edit activity screen will be displayed where you can add a title, intro screen and final screens. Once the activity is saved a new activity_id will be displayed. The new activity_id should be updated in Custom Parameters within the Edit LTI Block screen (e.g. ["activity_id=7”]).</p>';

      try {
    		$activityobj = $db->read( 'activity', $activityId)->fetch();
    		if(empty($activityobj)) {
          $activityId = -1;
    			$message .= '<p>This activity does not exist and will need to be created. Please follow the Admin/Instructor Instructions.</p>';
    		}
    		else {
          $title = $activityobj->title;
          $introtext = $activityobj->introtext;
          $feedback = $activityobj->feedback;
          $type = $activityobj->type;
          $grade = $activityobj->grade;
    		}
    	}
    	catch(Exception $e) {
    		$message .= '<p>' . $e->getMessage() . '</p>';
    	}

      require_once('views/admin/addeditform.php');
    }

    public function update() {
      $db = Db::instance();
      $activityId = $_POST['activityId'];
      $courseId = $_POST['courseId'];
      $title = $_POST['title'];
      $introtext = $_POST['introtext'];
      $feedback = $_POST['feedback'];
      $type = $_POST['type'];
      $grade = $_POST['grade'];

      $data = array( 'title' => $title, 'introtext' => $introtext, 'feedback' => $feedback, 'type' => $type, 'grade' => $grade);
      if ($activityId!=-1)
      {
        $data['activity_id'] = $activityId;
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
      echo '{"activityID":' . $id . ', "message": "The activity was updated."}';
    }
  }
?>
