<?php

abstract class BaseController
{
    protected $context_vars;

    public function __construct($param) {
      $this->context_vars = $param;
    }
}
?>
