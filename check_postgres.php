#!/usr/bin/php
<?php
	$arg = getopt("h:d:p:u:W:");
	$db_ada = pg_connect("host=".$arg['h']." dbname=".$arg['d']." user=".$arg['u']." password=".$arg['W']." port=".$arg['p']." connect_timeout=5");
	if ( !$db_ada ) {
		return 2;
	}
	$result = pg_query($db_ada, "SELECT relname AS table_name, reltuples::bigint AS estimate_nrows FROM pg_class where relname IN ('users', 'gateway', 'device', 'log') ORDER BY relname;");
	$first_string = "OK home7";
	$end_string = " |";
	while ( $row = pg_fetch_row($result) ) {
		$first_string = $first_string . ' ' . $row[0] . ': ' . $row[1];
		$end_string = $end_string . ' ' . $row[0] . '=' . $row[1];
	};
	$result = pg_query($db_ada, "SELECT pg_database_size('home7');");
	$row = pg_fetch_row($result);
	$first_string = $first_string . ' database_size: ' . $row[0].'B';
	$end_string = $end_string . ' database_size=' . $row[0].'B';
	echo $first_string . $end_string . "\n";
	pg_close($db_ada);
	return 0;
?>
	
