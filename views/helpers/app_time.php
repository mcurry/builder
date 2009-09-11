<?php
class AppTimeHelper extends AppHelper {
  function timeInWords($seconds) {
    $days = floor($seconds / DAY);
    $hours = floor(($seconds - ($days * DAY)) / HOUR);
    $minutes = floor(($seconds - ($days * DAY) - ($hours  * HOUR)) / MINUTE);
    $seconds = floor($seconds - ($days * DAY) - ($hours  * HOUR) - ($minutes  * MINUTE));
    
    $ret = array();
    if($days) {
      $ret[] = sprintf('%d %s', $days, __n('day', 'days', $days, true));
    }
    if($ret || $hours) {
      $ret[] = sprintf('%d %s', $hours, __n('hours', 'hours', $hours, true));
    }
    if($ret || $minutes) {
      $ret[] = sprintf('%d %s', $minutes, __n('minutes', 'minutes', $minutes, true));
    }
    if(($ret || $seconds) || (!$ret && !$seconds)) {
      $ret[] = sprintf('%02d %s', $seconds, __n('seconds', 'seconds', $seconds, true));
    }
   
    return implode(', ', $ret);
  }
  
  
}
?>