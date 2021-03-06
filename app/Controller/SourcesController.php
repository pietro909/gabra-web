<?php
class SourcesController extends AppController {

  public function index() {
    $this->set('sources', $this->paginate());
  }

  public function view($key = null) {
    $source = $this->Source->find('first', array('conditions'=>array('key'=>$key)));
    if (!$source) {
      $this->setMessageBad(__('Invalid ID'));
      $this->redirect(array('action'=>'index'));
    }
    $this->set('source', $source);
  }

}