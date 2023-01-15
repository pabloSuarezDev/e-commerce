<?php
  function controllers_autoLoader($classname) {
    include 'controllers/'.$classname.'.php';
  }

  spl_autoload_register("controllers_autoLoader");
?>