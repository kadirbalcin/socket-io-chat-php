<?php 


use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

require __DIR__ . '/vendor/autoload.php';


// burada hem database e kayıt ettireceğiz hem de sokete gönderim yapacağız.

if($_POST){

	$userid = $_POST['userid'];
	$yaziyor = $_POST['yaziyor'];


	$client = new Client(new Version2X('http://89.252.169.34:5000'));

	$client->initialize();
	$client->emit('yaziyor', [
		'yaziyor' => $yaziyor,
		'userid' => $userid
	]);

}



?>