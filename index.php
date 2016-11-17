<?php
  require_once('config.php');
  require_once('lib/db_connection.php');
  require_once('lib/lti.php');

  session_start();
  //session_unset();
  //session_destroy();
  //session_start();

  $warning_msg = '';

  //If session exists with valid LTI details than just load session variables into $context_vars
  //else create session and add lti variables
  $context_vars = array();
  $app_name = $config['app_name'];
  $use_dummydata = $config['use_dummydata'];
  $sendgrade = $config['sendgrade'];

  if (isset($_GET['resource_link_id']))
  {
    $resource_link_id = $_GET['resource_link_id'];
  }
  else if (isset($_POST['resource_link_id']))
  {
    $resource_link_id = $_POST['resource_link_id'];
  }
  else {
    if ($use_dummydata == True)
    {
      // Test data
      $resource_link_id = "abc123";
    }
    else {
      $warning_msg .= '<p>Invalid Session.</p>';
    }
  }

  if (isset($_SESSION[$app_name][$resource_link_id]['lti-valid']) && ($_SESSION[$app_name][$resource_link_id]['lti-valid']== True) && !isset($_POST['oauth_consumer_key']))
  {
    $context_vars = $_SESSION[$app_name][$resource_link_id];
  }
  else {
    $lti = new Lti($config,true);
    $lti_valid = $lti->is_valid();
    if(!$lti->is_valid()) {
      $warning_msg .= '<p>LTI Invalid.</p>';
    }
    else {
      $ltidata = $lti->calldata();
      // print_r($ltidata[resource_link_id]);
      $resource_link_id = $ltidata['resource_link_id'];
      $_SESSION[$app_name][$resource_link_id] = $lti->calldata();
      $_SESSION[$app_name][$resource_link_id]['lti-valid'] = True;
    }
  }

  $admin_msg = '';

  require_once('lib/get_lti_data.php');

  if ($use_dummydata == True)
  {
    // Test data
    $activityId = 1;
    $userRoles = 'Student';
    //$userRoles = 'Instructor';
    $userId = 160;
    //$activity_displaytype = 'learnerinput';
    $activity_displaytype = 'results';

  }

  //$context_vars = array('activityId' => $activityId, 'userId' => $userId, 'userRoles' => $userRoles, 'courseId' => $courseId, 'activity_displaytype' => $activity_displaytype);

  $context_vars['activityId'] = $activityId;
  $context_vars['userId'] = $userId;
  $context_vars['userRoles'] = $userRoles;
  $context_vars['courseId'] = $courseId;
  $context_vars['activity_displaytype'] = $activity_displaytype;
  $context_vars['resource_link_id'] = $resource_link_id;
  $context_vars['sendgrade'] = $sendgrade;

  /*
    Custom Controller
    Instead of using querystring or path params, LTI variables are used to determine the
    controller and action to run
  */

  if ($userRoles=="Student") {
    $controller = 'activity';
    if ($activity_displaytype=="results")
    {
      $action = 'results';
    }
    elseif (isset($_GET['action'])) {
      $action = $_GET['action'];
    }
    else{
      $action = 'learnerinput';
    }
  } elseif ($userRoles == 'Instructor' || $userRoles == 'Administrator') {
    if (isset($_GET['controller']) && isset($_GET['action'])) {
      $controller = $_GET['controller'];
      $action     = $_GET['action'];
    } else {
      $controller = 'admin';
      $action     = 'addeditform';
    }
  }

  if(isset($config['use_db']) && $config['use_db']) {
    try {
      $db = Db::instance();
    }
    catch (Exception $e) {
      $warning_msg .= '<p>' . $e->getMessage() . '</p>';
    }
  }

  $format = "html";
  if (isset($_GET['format'])) {
    $format     = $_GET['format'];
  }

  // If format is not json (i.e., not an ajax call then only render routes.php)
  if ($format == 'json' or $format == 'word')
  {
    if ($format=='word')
    {
      $action = "downloadword";
    }
    require_once('routes.php');
  }
  else {
    require_once('views/layout.php');
  }
  //print_r($_SESSION);
  session_write_close()
?>
