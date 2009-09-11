<?php
class Instance extends AppModel {

  var $name = 'Instance';

  var $belongsTo = array('Site');

  var $hasMany = array('Build' => array('dependent' => true));

  function __findBuild() {
    return parent::find('all', array('conditions' => array('enabled' => true,
                                                           'or' => array('pending' => true,
                                                                         'continuous' => true))));
  }
}
?>