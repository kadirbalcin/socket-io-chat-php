<?php session_start() ?>

<?php 

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

require __DIR__ . '/vendor/autoload.php';


?>

<?php 


$id = $_SESSION['id'];

try {
	$db = new PDO("mysql:host=localhost;dbname=nerorpgc_sohbet", "nerorpgc_sohbet", "Kadirbaba1961*");
} catch ( PDOException $e ){
	print $e->getMessage();
}

$query2 = $db->query("UPDATE uyeler SET uye_durum = 0 WHERE id = $id");

$client = new Client(new Version2X('http://89.252.169.34:5000'));

$client->initialize();
$client->emit('durum', [
	'durum' => "0",
	'id' => $id
]);



?>
<?php session_destroy();?>