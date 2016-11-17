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
  $controllers = array('pages' => array('error'),
                       'admin' => array('addeditform', 'update'),
                       'activity' => array('learnerinput', 'save', 'results', 'downloadword'));

  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action, $context_vars);
    } else {
      call('pages', 'error', $context_vars);
    }
  } else {
    call('pages', 'error', $context_vars);
  }
?>
