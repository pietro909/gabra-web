<?php
class WordformsController extends AppController {

  /**
   * Add
   * This is called from lexemes/edit
   */
  public function add() {
    if ($this->request->is('post')) {
      $this->Wordform->create();
      if ($this->Wordform->save($this->request->data)) {
        $this->setMessageGood(__('Item saved'));
      } else {
        $this->setMessageBad(__('Error'));
      }
    }
    $this->redirect(array('controller'=>'lexemes', 'action'=>'edit', $this->request->data['Wordform']['lexeme_id']));
  }

  /**
   * Edit
   */
  // public function edit($id = null) {
  //   if (!$id && empty($this->data)) {
  //     $this->setMessageBad(__('Invalid ID'));
  //   }
  //   if (!empty($this->data)) {
  //     if ($this->Wordform->save($this->data)) {
  //       $this->setMessageGood(__('Changes saved.'));
  //       $this->redirect(array('controller'=>'lexemes','action'=>'view', $this->data['Wordform']['lexeme_id']));
  //     } else {
  //       $this->setMessageBad(__('Error'));
  //     }
  //   }
  //   if (empty($this->data)) {
  //     $this->data = $this->Wordform->read(null, $id);
  //   }
  // }

  /**
   * Save multiple wordforms
   * This is called from lexemes/edit
   */
  public function saveMany() {
    $lexeme_id = $this->request->data['Wordform'][0]['lexeme_id'];
    foreach($this->request->data['Wordform'] as &$v) {
      unset($v['modified']);
    }

    if ($this->Wordform->saveMany($this->request->data['Wordform'])) {
      $this->setMessageGood(__('Changes saved'));
    } else {
      $this->setMessageBad(__('Error'));
    };
    $this->redirect(array('controller'=>'lexemes', 'action'=>'edit', $lexeme_id));
  }

  /**
   * Delete
   * This is called from lexemes/edit
   */
  public function delete($id = null) {
    $wf = $this->Wordform->read(null, $id);
    $lexeme_id = $wf['Wordform']['lexeme_id'];

    $ok = false;
    $msg = '';
    if (!$id) {
      $msg = __('Invalid ID');
    }
    if ($this->Wordform->delete($id)) {
      $ok = true;
      $msg = __('Entry deleted');
    } else {
      $msg = __('Delete failed');
    }
    if($this->RequestHandler->isAjax()) {
      $this->set('response', $ok ? 'OK' : 'ERROR');
      $this->set('message', $msg);
      $this->set('_serialize', array('response', 'message'));
    } else {
      if ($ok)
        $this->setMessageGood($msg);
      else
        $this->setMessageBad($msg);
      $this->redirect(array('controller'=>'lexemes', 'action'=>'edit', $lexeme_id));
    }
  }


}
