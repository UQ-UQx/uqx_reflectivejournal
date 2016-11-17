<?php
	/*
	$ltivars = $lti->calldata();
	//print_r($ltivars);

	// Extra data needed
	$lti_id = $lti->lti_id();
	$lis_outcome_service_url =  $lti->grade_url();
	$lis_result_sourcedid = $lti->result_sourcedid();

	$ltivars_warning_msg = '';

	$userId = '';
	$userRoles = '';
	$courseId = '';
	$activityId = 0;
	$activity_displaytype = '';

	// Assign default values for all possible LTI Variables
	if(isset($ltivars['user_id'])) {
		$userId = $ltivars['user_id'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: user_id is not available.</p>';
	}

	if(isset($ltivars['roles'])) {
		$userRoles = $ltivars['roles'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: roles is not available.</p>';
	}

	if(isset($ltivars['context_id'])) {
		$courseId = $ltivars['context_id'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: context_id is not available.</p>';
	}

	if(isset($ltivars['custom_activity_id'])) {
		$activityId = $ltivars['custom_activity_id'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: custom_activity_id is not available.</p>';
	}

	if(isset($ltivars['custom_activity_displaytype'])) {
		$activity_displaytype = $ltivars['custom_activity_displaytype'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: custom_activity_displaytype is not available.</p>';
	}

	$warning_msg .= $ltivars_warning_msg;
	*/

	$ltivars_warning_msg = '';

	$userId = '';
	$userRoles = '';
	$courseId = '';
	$activityId = 0;
	$activity_displaytype = '';
	$activities_to_include = '';

	// Assign default values for all possible LTI Variables
	if(isset($_SESSION[$app_name][$resource_link_id]['user_id'])) {
		$userId = $_SESSION[$app_name][$resource_link_id]['user_id'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: user_id is not available.</p>';
	}

	if(isset($_SESSION[$app_name][$resource_link_id]['roles'])) {
		$userRoles = $_SESSION[$app_name][$resource_link_id]['roles'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: roles is not available.</p>';
	}

	if(isset($_SESSION[$app_name][$resource_link_id]['context_id'])) {
		$courseId = $_SESSION[$app_name][$resource_link_id]['context_id'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: context_id is not available.</p>';
	}

	if(isset($_SESSION[$app_name][$resource_link_id]['custom_activity_id'])) {
		$activityId = $_SESSION[$app_name][$resource_link_id]['custom_activity_id'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: custom_activity_id is not available.</p>';
	}

	if(isset($_SESSION[$app_name][$resource_link_id]['custom_activity_displaytype'])) {
		$activity_displaytype = $_SESSION[$app_name][$resource_link_id]['custom_activity_displaytype'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: custom_activity_displaytype is not available.</p>';
	}

	if(isset($_SESSION[$app_name][$resource_link_id]['custom_activities_to_include'])) {
		$activities_to_include = $_SESSION[$app_name][$resource_link_id]['custom_activities_to_include'];
	}
	/*
	// Is not mandatory
	else {
		$ltivars_warning_msg .= '<p>LTI var: custom_activities_to_include is not available.</p>';
	}
	*/

	$warning_msg .= $ltivars_warning_msg;

?>
