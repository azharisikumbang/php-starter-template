<?php
class Controller {

  public function view($view, $data = []){
    if( file_exists('app/views/' . $view . '.php' ) ) {
      require_once 'app/views/' . $view . '.php';
      return;
    }
    return FALSE;
  }

  public function template($template, $view, $data = []) {
    if( file_exists('app/views/' . $template . '.php' ) ) {
      if( file_exists('app/views/' . $view . '.php' ) ) {
        $content = 'app/views/' . $view . '.php';
      }
      else {
        die("File view $view not found.");
      }

      require_once 'app/views/' . $template . '.php';

    }

    else {
      die("Template $template not found.");
    }

  }

  public function model($model){
    if( file_exists('app/models/' . $model . '.php' ) ) {
      require_once 'app/models/' . $model . '.php';
      return new $model;
    }
    return FALSE;
  }

  public function helper($helper){
    if( file_exists('app/helpers/' . $helper . '_helper.php' ) ) {
      require_once 'app/helpers/' . $helper . '_helper.php';
      return;
    }
    die("<b>Error</b> : Helper <i>$helper</i> does not exists, cross check your code...");
  }

}
 ?>
