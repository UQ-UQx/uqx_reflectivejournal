<?php
  require_once('controllers/base_controller.php');
  require_once('lib/grade.php');
  require_once('config.php');

  class ActivityController extends BaseController {

    protected $context_vars;

    public function learnerinput() {
      $db = Db::instance();
      $activityId = $this->context_vars['activityId'];
      $userId = $this->context_vars['userId'];
      $courseId = $this->context_vars['courseId'];
      $resource_link_id = $this->context_vars['resource_link_id'];
      $title = "";
      $introtext = "";
      $question = "";
      $wordclouddisplaytext = "";
      $activityobj = $db->read('activity', $activityId)->fetch();
      $message = "";
      $studentresponse = "";

      try {
        $activityobj = $db->read('activity', $activityId)->fetch();
        if(empty($activityobj)) {
          $message .= '<p>This activity does not exist. Please contact UQx Technical Team.</p>';
        }
        else {
          $title = $activityobj->title;
          $introtext = $activityobj->introtext;
          $question = $activityobj->question;
          $wordclouddisplaytext = $activityobj->wordclouddisplaytext;
        }
      }
      catch(Exception $e) {
        $message .= '<p>' . $e->getMessage() . '</p>';
      }

      $questionresponse = '';
      try {
        $select = $db->query( 'SELECT questionresponse FROM studentresponse WHERE student_id = :student_id AND activity_id = :activity_id', array( 'student_id' => $userId,  'activity_id' => $activityId) ); // Prepare and execute SQL
        while ( $row = $select->fetch() ) // It's a row fetching method
        {
          $questionresponse =  $row->questionresponse;
        }
      }
      catch(Exception $e) {
        $message .= '<p>' . $e->getMessage() . '</p>';
      }
      list($word_json, $classification_json) = getnounsummary($db, $activityId);

      require_once('views/activity/learnerinput.php');
    }

    public function results() {
      $db = Db::instance();

      $activityId = $this->context_vars['activityId'];
      $userId = $this->context_vars['userId'];
      $title = "";
      $introtext = "";
      $question = "";
      $wordclouddisplaytext = "";
      $activityobj = $db->read('activity', $activityId)->fetch();
      $message = "";

      try {
        $activityobj = $db->read('activity', $activityId)->fetch();
        if(empty($activityobj)) {
          $message .= '<p>This activity does not exist. Please contact UQx Technical Team.</p>';
        }
        else {
          $title = $activityobj->title;
          $introtext = $activityobj->introtext;
          $question = $activityobj->question;
          $wordclouddisplaytext = $activityobj->wordclouddisplaytext;
        }
      }
      catch(Exception $e) {
        $message .= '<p>' . $e->getMessage() . '</p>';
      }


      require_once('views/activity/results.php');
    }

    public function save() {
      $db = Db::instance();

      $activityId = $_POST['activityId'];
      $userId = $_POST['userId'];
      $questionresponse = $_POST['questionresponse'];

      $data = array( 'activity_id' => $activityId, 'student_id' => $userId , 'questionresponse' => $questionresponse);

      $db->create('studentresponse', $data);
      $id = $db->id(); // Get last inserted id

      //send grade back to LTI container
      $sendgrade = $this->context_vars['sendgrade'];
      if ($sendgrade==True)
      {
        $grade = 1;
        $app_name = $config['app_name'];
        $resource_link_id = $this->context_vars['resource_link_id'];
        $lti_vars = $_SESSION[$app_name][$resource_link_id];
        send_grade2($grade,$lti_vars);
      }

    }
  }
?>
