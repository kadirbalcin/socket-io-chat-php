<?php 


use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

require __DIR__ . '/vendor/autoload.php';


try {
	$db = new PDO("mysql:host=localhost;dbname=nerorpgc_sohbet", "nerorpgc_sohbet", "Kadirbaba1961*");
} catch ( PDOException $e ){
	print $e->getMessage();
}

if($_POST){

	$mesaj = $_POST['mesaj'];
	$userid = $_POST['userid'];
	$aid = $_POST['alici'];
	$konusmaid = $_POST['konusma'];

	if(!$mesaj) return false;
	
	$client = new Client(new Version2X('http://89.252.169.34:5000'));

	$client->initialize();
	$client->emit('chat message', [
		'test' => $mesaj,
		'userid' => $userid,
		'alici' => $aid,
		'konusmaid' => $konusmaid
	]);

	$query = $db->prepare("INSERT INTO mesajlar SET
		mesaj = ?,
		konusma = ?,
		gonderen = ?,
		alici = ?");
	$insert = $query->execute(array(
		$mesaj, $konusmaid, $userid, $aid
	));

}



?>