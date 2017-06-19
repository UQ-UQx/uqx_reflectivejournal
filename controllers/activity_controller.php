<?php
  require_once('controllers/base_controller.php');
  require_once('lib/grade.php');
  require_once('lib/reflectivejournal_utils.php');

  class ActivityController extends BaseController {

    protected $context_vars;

    public function learnerinput() {
      $db = Db::instance();
      $activity_id = $this->context_vars['activity_id'];
      $user_id = $this->context_vars['user_id'];
      $course_id = $this->context_vars['course_id'];
      $activity_displaytype = $this->context_vars['activity_displaytype'];

      include ('config.php');
      $secret_key = $config['secret_key'];

      $ctx = 1;
      $current_role = $this->context_vars['roles'];
      $roles = encrypt($secret_key, $this->context_vars['roles']);
      //print_r("roles:");
      //print_r($roles);
      $resource_link_id = encrypt($secret_key, $this->context_vars['resource_link_id']);
      $oauth_consumer_key = encrypt($secret_key, $this->context_vars['oauth_consumer_key']);
      $lis_result_sourcedid = encrypt($secret_key, $this->context_vars['lis_result_sourcedid']);
      $lis_outcome_service_url = encrypt($secret_key, $this->context_vars['lis_outcome_service_url']);

      $title = "";
      $entry_title = "Journal Entry";
      $introtext = "";
      $reviewintro = "";
      $feedback = "";
      $type = "";
      $show_wordcloud = 1;
      $show_wordcount= 1;
      $wordcount_limit = 0;
      $wordcount_limit = 400;
      $activityobj = $db->read('activity', $activity_id)->fetch();
      $message = "";
      $studentresponse = "";

      try {
        $activityobj = $db->read('activity', $activity_id)->fetch();
        if(empty($activityobj)) {
          $message .= '<p>This activity does not exist. Please contact UQx Technical Team.</p>';
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
          $show_wordcount = $activityobj->show_wordcount;
          $height = $activityobj->height;
        }
      }
      catch(Exception $e) {
        $message .= '<p>' . $e->getMessage() . '</p>';
      }

      $reflectivetext = '';
      $response_id = -1;
      try {
        $select = $db->query( 'SELECT response_id, reflectivetext FROM studentresponse WHERE student_id = :student_id AND activity_id = :activity_id', array( 'student_id' => $user_id,  'activity_id' => $activity_id) ); // Prepare and execute SQL
        while ( $row = $select->fetch() ) // It's a row fetching method
        {
          $reflectivetext =  htmlspecialchars_decode($row->reflectivetext);
          $response_id = $row->response_id;
        }
      }
      catch(Exception $e) {
        $message .= '<p>' . $e->getMessage() . '</p>';
      }

      $journalentries = array();
      $tags = "[]";

      $journalentries = get_journalentries($db, $user_id, $activity_id);
      $tags = get_tagcloud($journalentries);

      require_once('views/activity/learnerinput.php');
    }

    public function showentry() {
      $this->learnerinput();
    }

    public function save() {
      $db = Db::instance();

      $activity_id = $_POST['activity_id'];
      $response_id = $_POST['response_id'];
      $user_id = $_POST['user_id'];
      $reflectivetext = htmlspecialchars($_POST['reflectivetext']);

      $ctx = 1;
      $user_id = $this->context_vars['user_id'];
      $course_id = $this->context_vars['course_id'];
      $resource_link_id = $this->context_vars['resource_link_id'];
      $oauth_consumer_key = $this->context_vars['oauth_consumer_key'];
      $lis_result_sourcedid = $this->context_vars['lis_result_sourcedid'];
      $lis_outcome_service_url = $this->context_vars['lis_outcome_service_url'];

      $data = array( 'activity_id' => $activity_id, 'student_id' => $user_id , 'course_id'=>$course_id, 'reflectivetext' => $reflectivetext, 'dateadded' => date("Y-m-d H:i:s"));

      if ($response_id!=-1)
      {
        $data['response_id'] = $response_id;
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

      include ('config.php');
      $sendgrade = $config['sendgrade'];


      if ($sendgrade==True)
      {
        $lti_vars = array('lis_result_sourcedid'=>$lis_result_sourcedid, 'oauth_consumer_key'=>$oauth_consumer_key, 'oauth_consumer_secret'=>$oauth_consumer_secret, 'lis_outcome_service_url'=>$lis_outcome_service_url);
        send_grade2($grade,$lti_vars);
      }

      $journalentries = array();
      $tags = "[]";

      $journalentries = get_journalentries($db, $user_id, $activity_id);
      $tags = get_tagcloud($journalentries);

      echo '{"response_id":' . $id . ', "message": "The reflection was updated.", "tags": '. $tags . '}';

    }

    public function results() {
      $db = Db::instance();

      $activity_id = $this->context_vars['activity_id'];
      $user_id = $this->context_vars['user_id'];
      $course_id = $this->context_vars['course_id'];
      $activity_displaytype = $this->context_vars['activity_displaytype'];

      include ('config.php');
      $secret_key = $config['secret_key'];

      $ctx = 1;
      $current_role = $this->context_vars['roles'];
      $roles = encrypt($secret_key, $this->context_vars['roles']);
      //print_r("roles:");
      //print_r($roles);
      $resource_link_id = encrypt($secret_key, $this->context_vars['resource_link_id']);
      $oauth_consumer_key = encrypt($secret_key, $this->context_vars['oauth_consumer_key']);
      $lis_result_sourcedid = encrypt($secret_key, $this->context_vars['lis_result_sourcedid']);
      $lis_outcome_service_url = encrypt($secret_key, $this->context_vars['lis_outcome_service_url']);

      $activity_ids = $this->context_vars['activities_to_include'];

      $show_wordcloud = 0;

      $journalentries = array();
      $tags = "";
      try {
        $journalentries = get_journalentries($db, $user_id, $activity_ids);
        $tags = get_tagcloud($journalentries);
      }
      catch(Exception $e) {
        $message .= '<p>' . $e->getMessage() . '</p>';
      }

      require_once('views/activity/results.php');
    }

    public function downloadword() {
      $db = Db::instance();
      $user_id = $this->context_vars['user_id'];
      //$activity_ids = $this->context_vars['activities_to_include'];
      $activity_ids = $_POST['activities_to_include'];
      buildandexport_word($db, $user_id, $activity_ids);
    }
  }
?>
