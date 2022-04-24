<?php
require_once('bootstrapping.php');
  $r = new RouterController();
  $request = $_SERVER['REQUEST_URI'];
  $r->routerRedirect($request);
?>
