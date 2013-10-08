<?php
	
    include_once(dirname(__FILE__) . '/include/calendar-grid.class.php');

  
  /*
   *** You must specify <td> generation functions **
   * To use the PHP Calendar Grid Class, you must specify a function to
   * generate the <td> for each day in the grid. In this file, you will
   * see two example functions, doCells() and alternateColors() that
   * generate the <td> grids in two entirely different ways.
   * 
   * While not explicitly required, both the <td> generation functions
   * have an instance of the $calendar object passed to them. Doing so
   * allows the <td> generation function to have access to all the 
   * Calendar object's members and methods.
   * 
   */
  
  /*
   * doCells generates a calendar that will fill up whatever container it 
   * is placed in. Its first paremeter ($cal) is an isntance of the Calendar 
   * object. The second ($days) is a two-dimensional array of 
   * dates in the form [YYYY-MM-DD][validCssColor]. When a date is found that
   * matches the current <td> date, the background color in the 2D index at
   * is put into the 'bgcolor' attribute of the <td> cell. 
   * [Note that this example is clearly not using best practices for HTML5,
   * however, it should suffice to demonstrate how to construct a <td> 
   * generation function that actually does something.  
   */
  function doCells($cal, $days) {
  ?>
  <td<?php
    if(array_key_exists($cal->getVerboseDate(), $days)) {
    	echo ' bgcolor="' . $days[$cal->getVerboseDate()]['bgcolor'] .  '" ';
    }
  ?>>
   <?php echo $cal->getDayCount(); ?><br />
   <?php echo $cal->getVerboseDate(); ?>
  </td>
  <?php
}

    
    /*
     * TODO: Explain the alternateColors <td> generation function
     */
    function alternateColors($cal) {
    	echo '<td bgcolor="';
      if($cal->getDayCount() % 2) {
    		echo '#cccccc';
    	} else {
    		echo 'turquoise';
    	}
       echo '">';
       echo $cal->getDayCount();
       echo '</td>';
    }
?><!doctype html>
<html lang="en">
<head><meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <title>PHP Calendar Grid Generator Examples</title>
</head>
<body>
<?php
    $calendar = new calendar('03', '2008');
    $days['2008-03-04']['bgcolor'] = 'turquoise';
    $days['2008-03-16']['bgcolor'] = 'pink';
    $cellParamArray = array($calendar, $days);

?>
<div>
<?php
  echo '&laquo;' . $calendar->getPreviousMonth() . ' ' .  $calendar->getVerboseMonth() . ' '  . $calendar->getYear() . $calendar->getNextMonth() . ' &raquo;';
    $calendar->generateCalendar('myClass', 'myId', 'border="1"', 'doCells', $cellParamArray);
?>
</div>

<div style="padding-top:50px;">
<?php
  $calendar->setMonth('02');
  $calendar->setYear('2000');
   echo $calendar->getVerboseMonth() . ' ' . $calendar->getYear();
  $calendar->generateCalendar('myClass', 'myId2', '', 'alternateColors', array($calendar));
?>
</div>
</body>
</html>
