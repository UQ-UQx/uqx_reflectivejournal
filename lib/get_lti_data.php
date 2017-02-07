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

	// Assign default values for all possible LTI Variables
	if(isset($context_vars['user_id'])) {
		$userId = $context_vars['user_id'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: user_id is not available.</p>';
	}

	if(isset($context_vars['roles'])) {
		$userRoles = $context_vars['roles'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: roles is not available.</p>';
	}

	if(isset($context_vars['course_id'])) {
		$courseId = $context_vars['course_id'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: context_id is not available.</p>';
	}

	if(isset($context_vars['custom_activity_id'])) {
		$activityId = $context_vars['custom_activity_id'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: custom_activity_id is not available.</p>';
	}

	if(isset($context_vars['custom_activity_displaytype'])) {
		$activity_displaytype = $context_vars['custom_activity_displaytype'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: custom_activity_displaytype is not available.</p>';
	}

	if(isset($context_vars['resource_link_id'])) {
		$resource_link_id = $context_vars['resource_link_id'];
	}
	else {
		$ltivars_warning_msg .= '<p>LTI var: resource_link_id is not available.</p>';
	}

	$warning_msg .= $ltivars_warning_msg;

?>
