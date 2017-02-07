<?php
  require_once('config.php');
  require_once('lib/db_connection.php');
  require_once('lib/lti.php');
  require_once('lib/encrypt.php');

  $warning_msg = '';

  //If session exists with valid LTI details than just load session variables into $context_vars
  //else create session and add lti variables
  $context_vars = array();
  $app_name = $config['app_name'];
  $use_dummydata = $config['use_dummydata'];
  $sendgrade = $config['sendgrade'];
  $secret_key = $config['secret_key'];

  //print_r($_POST);

  //print_r("ctx post:" . $_POST['ctx']);

  if (isset($_POST['oauth_consumer_key']))
  {
    // check if lti is valid and then store lti variables to context_vars
    $lti = new Lti($config,true);
    $lti_valid = $lti->is_valid();
    if(!$lti->is_valid()) {
      $warning_msg .= '<p>LTI Invalid.</p>';
    }
    else {
      $ltidata = $lti->calldata();
      $context_vars['activity_id'] = $ltidata['custom_activity_id'];
      $context_vars['activity_displaytype'] = $ltidata['custom_activity_displaytype'];
      $context_vars['activities_to_include'] = $ltidata['custom_activities_to_include'];
      $context_vars['roles'] = $ltidata['roles'];
      $context_vars['custom_activity_displaytype'] = $ltidata['custom_activity_displaytype'];
      $context_vars['custom_activity_id'] = $ltidata['custom_activity_id'];
      $context_vars['course_id'] = $ltidata['context_id'];
      $context_vars['user_id'] = $ltidata['user_id'];
      $context_vars['resource_link_id'] = $ltidata['resource_link_id'];
      $context_vars['oauth_consumer_key'] = $ltidata['oauth_consumer_key'];
      $context_vars['lis_result_sourcedid'] = $ltidata['lis_result_sourcedid'];
      $context_vars['lis_outcome_service_url'] = $ltidata['lis_outcome_service_url'];
    }
  }
  elseif (isset($_POST['ctx'])){
    // get context_vars from ctx form posted variable
    //print_r("getting values from ctx");
    $context_vars['activity_id'] = $_POST['activity_id'];
    $context_vars['course_id'] = $_POST['course_id'];
    $context_vars['user_id'] = $_POST['user_id'];
    $context_vars['custom_activity_displaytype'] = $_POST['activity_displaytype'];
    $context_vars['custom_activity_id'] = $_POST['activity_id'];
    $context_vars['activity_displaytype'] = $_POST['activity_displaytype'];
    $context_vars['roles'] = decrypt($secret_key, $_POST['roles']);
    $context_vars['resource_link_id'] = decrypt($secret_key, $_POST['resource_link_id']);
    $context_vars['oauth_consumer_key'] = decrypt($secret_key, $_POST['consumer_key']);
    $context_vars['lis_result_sourcedid'] = decrypt($secret_key, $_POST['lis_result_sourcedid']);
    $context_vars['lis_outcome_service_url'] = decrypt($secret_key, $_POST['lis_outcome_service_url']);
  }
  else{
    $warning_msg .= '<p>Loading Dummy LTI Data.</p>';
    $lti = new Lti($config,true);
    $ltidata = $lti->calldata();
    $context_vars['activity_id'] = $ltidata['custom_activity_id'];
    $context_vars['course_id'] = $ltidata['context_id'];
    $context_vars['user_id'] = $ltidata['user_id'];
    $context_vars['custom_activity_displaytype'] = $ltidata['custom_activity_displaytype'];
    $context_vars['custom_activity_id'] = $ltidata['custom_activity_id'];
    $context_vars['activity_displaytype'] = $ltidata['custom_activity_displaytype'];
    $context_vars['roles'] = $ltidata['roles'];
    $context_vars['resource_link_id'] = $ltidata['resource_link_id'];
    $context_vars['oauth_consumer_key'] = $ltidata['oauth_consumer_key'];
    $context_vars['lis_result_sourcedid'] = $ltidata['lis_result_sourcedid'];
    $context_vars['lis_outcome_service_url'] = $ltidata['lis_outcome_service_url'];
  }
  //print_r("context_vars:");
  //print_r($context_vars);

  $admin_msg = '';

  require_once('lib/get_lti_data.php');

  if ($use_dummydata == True)
  {
    // Test data
    $activityId = 2;
    //$userRoles = 'Student';
    $userRoles = 'Instructor';
    $userId = 45;
    $activity_displaytype = 'learnerinput';
    //$activity_displaytype = 'results';
    $activities_to_include = '2';

    $context_vars['activity_id'] = $activityId;
    $context_vars['roles'] = $userRoles;
    $context_vars['user_id'] = $userId;
    $context_vars['activity_displaytype'] = $activity_displaytype;
    $context_vars['activities_to_include'] = $activities_to_include;

  }

  /*
    Custom Controller
    Instead of using querystring or path params, LTI variables are used to determine the
    controller and action to run
  */

  //if ($userRoles=="Student") {
  if ($activityId > 0) {
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
    if (isset($_GET['controller'])){
      $controller = $_GET['controller'];
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
  //print_r("controller:");
  //print_r($controller . '-' .$action);

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
  if ($format == 'json')
  {
    require_once('routes.php');
  }
  else {
    require_once('views/layout.php');
  }

?>
