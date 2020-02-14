<?php
class Show_404 extends Controller {
  public function index() {
    $this->helper('main');
    show_404();
    exit();
  }
}
