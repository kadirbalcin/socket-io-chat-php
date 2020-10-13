<?php 

session_start();

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

require __DIR__ . '/vendor/autoload.php';

try {
	$db = new PDO("mysql:host=localhost;dbname=nerorpgc_sohbet", "nerorpgc_sohbet", "Kadirbaba1961*");
} catch ( PDOException $e ){
	print $e->getMessage();
}

// burada hem database e kayıt ettireceğiz hem de sokete gönderim yapacağız.

if($_POST){

	$goruldu = $_POST['goruldu'];
	$konusma = $_POST['konusma'];


	$client = new Client(new Version2X('http://89.252.169.34:5000'));

	$client->initialize();
	$client->emit('goruldu', [
		'goruldu' => $goruldu,
		'konusma' => $konusma,
		'userid' => $_SESSION['id']
	]);

	$userid = $_SESSION['id'];

	$query = $db->query("UPDATE mesajlar SET goruldu = 1 WHERE konusma = $konusma AND alici = $userid");

}



?>