<?php
class App {

  protected $controller = 'Home'; // Default Controller
  protected $method = 'index'; // Default Method
  protected $params = []; // Default Params

  protected $controller_uri = 0; // Default Uri Segment controller
  protected $method_uri = 1; // Default Uri Segment method
  protected $dirname = ''; // Default Dirname

  protected $controller_url; // Controller file location

  public function __construct(){
    $url = $this->parse_url();
    $this->controller_url = $this->controller;

    if(is_array($url)){
      for ($i=0; $i < count($url); $i++) {
        if(is_dir('app/controllers/' . $this->dirname . $url[$i])) {
          $this->dirname .= $url[$this->controller_uri] .'/';
          unset($url[$this->controller_uri]);
          $this->controller_uri += 1;
          $this->method_uri += 1;
        }
      }
    }

    if(isset($url[$this->controller_uri])) {
      $this->controller_url = $this->dirname . ucfirst($url[$this->controller_uri]);
      if( file_exists('app/controllers/' . $this->controller_url .'.php') ) {
         $this->controller = $url[$this->controller_uri];
         unset($url[$this->controller_uri]);
      }
      else {
        $this->controller = 'Show_404';
        $this->controller_url = $this->controller;
      }
    }
    else {
      if($this->dirname != '') {
        $this->controller = 'Show_404';
        $this->controller_url = $this->controller;
      }
    }


    require_once 'app/controllers/' . $this->controller_url .'.php';
    $this->controller = new $this->controller;

    if( isset($url[$this->method_uri]) ) {
      if( method_exists($this->controller, $url[$this->method_uri]) ) {
        $this->method = $url[$this->method_uri];
        unset($url[$this->method_uri]);
      }
    }

    if(!empty($url)) {
        $this->params = array_values($url);
    }

    call_user_func_array([$this->controller, $this->method], $this->params);

  }

  public function parse_url(){
    if(isset($_GET['url'])) {
      $url = rtrim($_GET['url'], '/');
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);
      return $url;
    }
    return FALSE;
  }

}
?>
