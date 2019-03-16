<html>
<head>
<title>Worklog dim</title>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
</head>
<?php

// Database file, i.e. file with real data
$data_file = 'order_lesson.txt';

// Database definition file. You have to describe database format in this file.
// See flatfile.inc.php header for sample.
$structure_file = 'order_lesson.def';

// Fields delimiter
$delimiter = '|_|';

// Number of header lines to skip. This is needed if you have some heder saved in the 
// database file, like comment or description
$skip_lines = 0;

// run flatfile manager
include ('flatfile.inc.php');

?>
