<?php
$storedTasks = array();
$weekDayNumber = date('w');
$weekBeginDate = strftime(
    '%Y-%m-%d 00:00:00',
    time() - ($weekDayNumber - 1) * (60*60*24)
);
$weekBeginTs = strtotime($weekBeginDate);

// some start id
$dbId = 327;

for ($i=0; $i<5; $i++) {
    $currentDayTasks = array();
    $currentDayTs = strtotime('+' .$i. 'days', $weekBeginTs );

    // have one day without regs. for demo purposes
    if ($i != 1) {
        // add two lines per day
        $currentDayTasks[ $dbId ] = array(
            'desc' => 'I\'ve got to do this on ' .strftime('%a', $currentDayTs),
            'completed' => false
        );
        $dbId++;
        // 2nd line
        $currentDayTasks[ $dbId ] = array(
            'desc' => 'I\'ve got to do that on ' .strftime('%a', $currentDayTs),
            'completed' => true
        );
        $dbId++;
    }
    $storedTasks[$currentDayTs]['current'] = $currentDayTasks;
}
