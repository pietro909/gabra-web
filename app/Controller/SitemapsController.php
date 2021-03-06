<?php
class SitemapsController extends AppController {

  var $uses = array('Root', 'Lexeme');

  public function index() {
    $this->layout="empty";
    $this->set('roots', $this->Root->find('all',array('fields' => array('radicals','variant','modified'))));
    $this->set('lexemes', $this->Lexeme->find('all',array('fields' => array('_id','lemma','modified'))));
    Configure::write ('debug', 0); //debug logs will destroy xml format, make sure were not in drbug mode
  }

}
?>