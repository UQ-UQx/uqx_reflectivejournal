<?php
  require_once('controllers/base_controller.php');
  require_once('lib/grade.php');
  require_once('config.php');
  require_once('lib/reflectivejournal_utils.php');

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
      $feedback = "";
      $type = "";
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
          $feedback = $activityobj->feedback;
          $type = $activityobj->type;
        }
      }
      catch(Exception $e) {
        $message .= '<p>' . $e->getMessage() . '</p>';
      }

      $reflectivetext = '';
      $response_id = -1;
      try {
        $select = $db->query( 'SELECT response_id, reflectivetext FROM studentresponse WHERE student_id = :student_id AND activity_id = :activity_id', array( 'student_id' => $userId,  'activity_id' => $activityId) ); // Prepare and execute SQL
        while ( $row = $select->fetch() ) // It's a row fetching method
        {
          $reflectivetext =  htmlspecialchars_decode($row->reflectivetext);
          $response_id = $row->response_id;
        }
      }
      catch(Exception $e) {
        $message .= '<p>' . $e->getMessage() . '</p>';
      }

      require_once('views/activity/learnerinput.php');
    }

    public function results() {
      $db = Db::instance();

      $userId = $this->context_vars['userId'];
      $resource_link_id = $this->context_vars['resource_link_id'];

      $journalentries = array();

      try {
        $journalentries = get_journalentries($db, $userId);
        $tags = get_tagcloud($journalentries);
      }
      catch(Exception $e) {
        $message .= '<p>' . $e->getMessage() . '</p>';
      }

      require_once('views/activity/results.php');
    }

    public function save() {
      $db = Db::instance();

      $activityId = $_POST['activityId'];
      $responseId = $_POST['responseId'];
      $userId = $_POST['userId'];
      $reflectivetext = htmlspecialchars($_POST['reflectivetext']);

      $data = array( 'activity_id' => $activityId, 'student_id' => $userId , 'reflectivetext' => $reflectivetext);

      if ($responseId!=-1)
      {
        $data['response_id'] = $responseId;
      }
      $addedit_mode = "add";
      $id = 0;
      if (array_key_exists('response_id', $data)) {
        $addedit_mode = "edit";
        $id = $data['response_id'];
      }

      if ($addedit_mode == "add")
      {
        $db->create( 'studentresponse', $data );
        $id = $db->id(); // Get last inserted id
      }
      else {
        $db->update( 'studentresponse', $data);
      }

      //$db->create('studentresponse', $data);
      //$id = $db->id(); // Get last inserted id

      //send grade back to LTI container
      $sendgrade = $this->context_vars['sendgrade'];
      /*
      if ($sendgrade==True)
      {
        $grade = 1;
        $app_name = $config['app_name'];
        $resource_link_id = $this->context_vars['resource_link_id'];
        $lti_vars = $_SESSION[$app_name][$resource_link_id];
        send_grade2($grade,$lti_vars);
      }
      */

    }

    public function downloadword() {
      $db = Db::instance();
      $userId = $this->context_vars['userId'];
      buildandexport_word($db, $userId);
    }
  }
?>
