<?php
class BuilderHelper extends AppHelper {
  var $helpers = array('Time', 'Html');

  function getClass($data) {
    if (!empty($data['pending'])) {
      return 'pending';
    } else if (!empty($data['Build'])) {
      if(!empty($data['Build'][0])) {
        $data['Build'] = $data['Build'][0];
      }
      if ($data['Build']['state'] == Build::$running) {
        return 'pending';
      } else if ($data['Build']['success']) {
        return 'success';
      } else {
        return 'error';
      }
    }

    return '';
  }

  function status($data) {
    if ($data['pending']) {
      return __('Pending', true);
    } else if (empty($data['Build'])) {
      return __('Never Built', true);
    } else if ($data['Build'][0]['state'] == Build::$running) {
      return __('In Progress', true);
    } else if ($data['Build'][0]['success']) {
      return __('Success', true);
    }

    return __('Error', true);
  }
  
  function statusIcon($data) {
    if(!empty($data['success'])) {
      return $this->Html->image('icons/tick.png');
    }
    
    return $this->Html->image('icons/cross.png');
  }

  function detail($data) {
    if ($data['pending']) {
      return '';
    } else if (empty($data['Build'])) {
      return '';
    } else if ($data['Build'][0]['state'] == Build::$running) {
      return $data['Build'][0]['status'];
    } else {
      return String::insert(__('Last built :time', true), array('time' => $this->Time->timeAgoInWords($data['Build'][0]['end'])))
             . '<br />'
             . String::insert(__(':passed of :run tests passed', true), array('passed' => $data['Build'][0]['tests_passed'],
                              'run' => $data['Build'][0]['tests_run']));
    }
  }

  function detailLink($data) {
    if ($data['pending']) {
      return '';
    }

    if (!empty($data['Build'][0])) {
      return $this->Html->link(__('Details', true), array('controller' => 'builds', 'action' => 'view', $data['Build'][0]['id']));
    }

    return '';
  }
}
?>