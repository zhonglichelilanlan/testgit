<?PHP
date_default_timezone_set('Asia/Shanghai');

	function timediff( $begin_time, $end_time ){
		  if ( $begin_time < $end_time ){
		    $starttime = $begin_time;
		    $endtime = $end_time;
		  } else {
		    $starttime = $end_time;
		    $endtime = $begin_time;
		  }
		  $timediff = $endtime - $starttime;
		  $days = intval( $timediff / 86400 );
		  $remain = $timediff % 86400;
		  $hours = intval( $remain / 3600 );
		  $remain = $remain % 3600;
		  $mins = intval( $remain / 60 );
		  $secs = $remain % 60;
		  $res = array( "day" => $days, "hour" => $hours, "min" => $mins, "sec" => $secs );
		  return $res;
	}
?>