<?php
  function call($controller, $action, $context_vars) {
    require_once('controllers/' . $controller . '_controller.php');

    switch($controller) {
      case 'pages':
        $controller = new PagesController();
      break;
      case 'admin':
        $controller = new AdminController($context_vars);
      break;
      case 'activity':
        $controller = new ActivityController($context_vars);
      break;
    }

    $controller->{ $action }();
  }

  // we're adding an entry for the new controller and its actions
  $controllers = array('pages' => array('error','incorrectrole'),
                       'admin' => array('addeditform', 'update'),
                       'activity' => array('learnerinput', 'showentry', 'save', 'results', 'downloadword', 'downloadpdf'));

  $controller_roles = array('pages' => array('Instructor','Student'),
                       'admin' => array('Instructor'),
                       'activity' => array('Instructor','Student'));

  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      // check that the role is allowed
      if (in_array($context_vars['roles'], $controller_roles[$controller]))
      {
        call($controller, $action, $context_vars);
      }
      else {
        call('pages', 'incorrectrole', $context_vars);
      }
    } else {
      call('pages', 'error', $context_vars);
    }
  } else {
    call('pages', 'error', $context_vars);
  }
?>
