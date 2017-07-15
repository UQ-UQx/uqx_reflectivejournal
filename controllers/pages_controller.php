<?php
  class PagesController {

    public function error() {
      require_once('views/pages/error.php');
    }

    public function incorrectrole() {
      require_once('views/pages/incorrectrole.php');
    }
  }
?>
