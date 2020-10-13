<?php 


use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

require __DIR__ . '/vendor/autoload.php';


// burada hem database e kayıt ettireceğiz hem de sokete gönderim yapacağız.

if($_POST){

	echo $_POST['userid'];


	// $client = new Client(new Version2X('http://89.252.169.34:5000'));

	// $client->initialize();
	// $client->emit('chat message', [
	// 	'test' => $mesaj,
	// 	'userid' => $userid
	// ]);

}



?>