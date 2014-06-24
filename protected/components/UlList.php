<?php
class UlList extends CWidget {
 
    public $data = array();
    public $fieldName = 'name';

    public function run() {
        $this->render('UlList');
    }
 
}
?>