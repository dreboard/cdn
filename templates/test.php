<h1><?=$title; ?></h1>

<?php

$ftp_server = "cdn.dev-php.site";
$ftp_user = "ftpcdn@cdn.dev-php.site";
$ftp_pass = "FLwm@1989";

// set up a connection or die
$conn_id = ftp_connect($ftp_server) or die("Couldn't connect to server"); 

// try to login
if (ftp_login($conn_id, $ftp_user, $ftp_pass)) {
	ftp_pasv($conn_id, true);
    echo "Connected <br>";
} else {
    echo "Couldn't connect<br>";
}
$c = ftp_mlsd($conn_id, '/'); // Returns a list of files in the given directory

// close the connection
ftp_close($conn_id);

var_dump($c);

?>