<?php

class QuipCommentFeatureProcessor extends xPDOSimpleObject {
    
    public $classKey = 'quipComment';
    public $permission = '';
    public $languageTopics = array('quip:default');

    /** @var quipComment $comment */
    public $comment;

    public function initialize() {
        $id = $this->getProperty('id');
        if (empty($id)) return $this->modx->lexicon('quip.comment_err_ns');
        $this->comment = $this->modx->getObject($this->classKey,$id);
        if (empty($this->comment)) return $this->modx->lexicon('quip.comment_err_nf');
        return parent::initialize();
    }
    public function process(array $options = array()) {
        $this->set('helpful',true);

        /* first attempt to save/approve */
        if ($this->save() === false) {
            return false;
        }
        return true;
    }
   
}
return 'QuipCommentFeatureProcessor';