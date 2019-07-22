<?php
namespace App\Core;

final class DevFtp {
	
	
	public function __construct($container) {
		$this->container = $container;
    }	
	
	public function ftpLogin($dir = null):array
	{
		$ftp_server = $this->container['settings']['ftp']['server'];
		$ftp_user = $this->container['settings']['ftp']['user'];
		$ftp_pass = $this->container['settings']['ftp']['pass'];

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

		return $c;
	}	
	
	public function getFileList($dir = null)
	{
		try{
			$db = $this->container->get('db');
			$c = ftp_mlsd($this->container->get('ftp'), '/'); // Returns a list of files in the given directory
		    return $c;	
		}catch(\Throwable $e){
			return $e->getMessage();
		}

	}
	
}