<?php
if( !function_exists('show_404')){
  function show_404(){
    header("HTTP/1.0 404 Not Found");
    http_response_code(404);
    die("<h1>Error : 404 Page not found</h1> no page for <i>" . $_SERVER['REQUEST_URI'] . "</i> on our system.");
  }
}
