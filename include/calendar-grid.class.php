<?php
require_once(dirname(__FILE__) . '/./constants.php');
class calendar {

    var $month;
    var $year;
    var $dayCount;
    var $cellHandler = null;
    var $cellHandlerParams = array();
    var $summary = null;

    function calendar($newMonth = null, $newYear = null) {
      if($newMonth) {
      	$this->month = $newMonth;
      }

      if($newYear) {
      	$this->year = $newYear;
      }

    }

  function setMonth($newMonth) {
  	$this->month = $newMonth;
  }

  function getMonth() {
  	return $this->month;
  }

  function setSummary($newSummary) {
    $this->summary = $newSummary;
  } 
  
  function getSummary() {
    return $this->summary;
  }
  
  function getVerboseMonth() {
  	$returnValue = null;
    switch($this->month) {
  		case('01'):
        return 'January';
        break;

      case('02'):
        return 'February';
        break;

      case('03'):
        return 'March';
        break;

      case('04'):
        return 'April';
        break;

      case('05'):
        return 'May';
        break;

      case('06'):
        return 'June';
        break;

      case('07'):
        return 'July';
        break;

      case('08'):
        return 'August';
        break;

      case('09'):
        return 'September';
        break;

      case('10'):
        return 'October';
        break;

      case('11'):
        return 'November';
        break;

      case('12'):
        return 'December';
        break;

      default:
        return null;
        break;
    }
  }

  function setYear($newYear) {
  	$this->year = $newYear;
  }

  function getYear() {
  	return $this->year;
  }

  function getDayCount() {
  	return $this->dayCount;
  }

  function getVerboseDate() {
  	$retMonth = $this->month;
    if(strlen($retMonth) < 2) {
    	$retMonth = '0' . $retMonth;
    }

    $retDay = $this->dayCount;
    if(strlen($retDay) <  2) {
      $retDay = '0' . $retDay;
    }
    return $this->year . '-' . $retMonth . '-' . $retDay;
  }


  // FIXED: getDayOfWeek - Database Dependency
  function getDayOfWeek() {
  	return date("w", strtotime($this->year . '-' . $this->month . '-01'))+1;
  }

  // FIXED: getLastDay - Database Dependency
  function getLastDay() {
  	return date("t", strtotime($this->year . '-' . $this->month . '-01'));
  }

  // FIXED: getPreviousMonth - Database Dependency
  function getPreviousMonth() {
    return date('Y-m-d', strtotime('first day of last month', strtotime($this->getYear() . '-' . $this->getMonth() . '-01')));

  }
  
  // FIXED: getNextMonth - Database Dependency
  function getNextMonth() {
  	return date('Y-m-d', strtotime('first day of next month', strtotime($this->getYear() . '-' . $this->getMonth() . '-01')));

  }

  function generateCalendar($class=null, $id=null, $htmlOptions=null, $newCellHandler=null, $newCellHandlerParams=array()) {
      if($newCellHandler) {
        $this->cellHandler = $newCellHandler;
      } else {
      	$this->cellHandler = null;
      }

      if(is_array($newCellHandlerParams) && !empty($newCellHandlerParams)) {
        $this->cellHandlerParams = $newCellHandlerParams;
      } else {
      	$this->cellHandlerParams = null;
      }
    $startWeekDay = $this->getDayOfWeek();
    $lastDay = $this->getLastDay();
    ?>
    <table <?php
      if($class) {
      	echo ' class="' . $class . '" ';
      }

      if($id) {
      	echo ' id="'. $id . '" ';
      }

      if($htmlOptions) {
      	echo ' ' . $htmlOptions . ' ';
      }
      
      if($this->summary) {
        echo ' summary="' . $this->summary . '" ';
      }
    ?>
    >
      <tr class='weekdayLabels'>
        <td>Su</td>
        <td>M</td>
        <td>T</td>
        <td>W</td>
        <td>Th</td>
        <td>F</td>
        <td>Sa</td>
      </tr>
      <?php
        $weekDay = $this->getDayOfWeek();
        $this->dayCount = 1;
        $firstCount = 1;
        echo '<tr>';
        while($this->dayCount <= $this->getLastDay()) {
        if($firstCount < $startWeekDay) {
        	echo '<td></td>';
            $firstCount++;
        } else {
        if($weekDay==1) {
        	echo '<tr>';
        }
        if(!$this->cellHandler) {
          $this->cellHandler = null;
          $this->cellHandlerParams = null;
          echo '<td>' . $this->dayCount . '</td>';
        } else {
        	call_user_func_array($this->cellHandler, $this->cellHandlerParams);
        }
        if($weekDay==7) {
        	echo '</tr>';
          $weekDay=0;
        }
        $weekDay++;
        $this->dayCount++;
      ?>
    <?php
    }
  }
  while($weekDay <= 7) {
  	echo '<td></td>';
    $weekDay++;
  }
    if($weekDay == 8) {
    echo '</tr>';
  }
  echo '</table>';
  }

}