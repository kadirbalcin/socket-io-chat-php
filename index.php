<?php session_start(); ?>
<?php 

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

require __DIR__ . '/vendor/autoload.php';


?>

<?php if($_SESSION['login']): ?>


	<?php 

	try {
		$db = new PDO("mysql:host=localhost;dbname=nerorpgc_sohbet", "nerorpgc_sohbet", "Kadirbaba1961*");
	} catch ( PDOException $e ){
		print $e->getMessage();
	}

	$id = $_SESSION['id'];

	$query = $db->query("SELECT * FROM konusmalar WHERE alici = $id", PDO::FETCH_ASSOC);
	$koquery2 = $db->query("SELECT * FROM konusmalar WHERE alici = $id", PDO::FETCH_ASSOC);


	?>

	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title></title>

		<style type="text/css">
			* { margin: 0px; padding: 0px; }
			body {
				background: #f0f1f2;
				font:12px "Open Sans", sans-serif; 
			}
			#view-code{
				color:#89a2b5;    
				opacity:0.7;
				font-size:14px;
				text-transform:uppercase;
				font-weight:700;
				text-decoration:none;
				position:absolute;top:660px;
				left:50%;margin-left:-50px;
				z-index:200;
			}
			#view-code:hover{opacity:1;}
			#chatbox{
				width:290px;
				background:#fff;
				border-radius:6px;
				overflow:hidden;
				height:484px;
				position:absolute;
				top:100px;
				left:50%;
				margin-left:-155px;
			}

			#friendslist{
				position:absolute;
				top:0;
				left:0;
				width:290px;
				height:484px;
			}
			#topmenu{
				height:69px;
				width:290px;
				border-bottom:1px solid #d8dfe3;    
			}
			#topmenu span{
				float:left; 
				width: 96px;
				height: 70px;
				background: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/top-menu.png") -3px -118px no-repeat;
			}
			#topmenu span.friends{margin-bottom:-1px;}
			#topmenu span.chats{background-position:-95px 25px; cursor:pointer;}
			#topmenu span.chats:hover{background-position:-95px -46px; cursor:pointer;}
			#topmenu span.history{background-position:-190px 24px; cursor:pointer;}
			#topmenu span.history:hover{background-position:-190px -47px; cursor:pointer;}
			.friend{
				height:70px;
				border-bottom:1px solid #e7ebee;        
				position:relative;
			}
			.friend:hover{
				background:#f1f4f6;
				cursor:pointer;
			}
			.friend img{
				width:40px;
				border-radius:50%;
				margin:15px;
				float:left;
			}
			.floatingImg{
				width:40px;
				border-radius:50%;
				position:absolute;
				top:0;
				left:12px;
				border:3px solid #fff;
			}
			.friend p{
				padding:15px 0 0 0;         
				float:left;
				width:220px;
			}
			.friend p strong{
				font-weight:600;
				font-size:15px;
				color:#597a96;  

			}
			.friend p span{
				font-size:13px;
				font-weight:400;
				color:#aab8c2;
			}
			.friend .status{
				background:#26c281;
				border-radius:50%;  
				width:9px;
				height:9px;
				position:absolute;
				top:31px;
				right:17px;
			}
			.friend .status.away{background:#ffce54;}
			.friend .status.inactive{background:#eaeef0;}
			#search{
				background:#e3e9ed url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/search.png") -11px 0 no-repeat;
				height:60px;
				width:290px;
				position:absolute;
				bottom:0;
				left:0;
			}
			#searchfield{
				background:#e3e9ed;
				margin:21px 0 0 55px;
				border:none;
				padding:0;
				font-size:14px;
				font-family:"Open Sans", sans-serif; 
				font-weight:400px;
				color:#8198ac;
			}
			#searchfield:focus{
				outline: 0;
			}
			#chatview{
				width:290px;
				height:484px;
				position:absolute;
				top:0;
				left:0; 
				display:none;
				background:#fff;
			}
			#profile{
				height:153px;
				overflow:hidden;
				text-align:center;
				color:#fff;
			}
			.p2 #profile{
				background:#fff url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/timeline1.png") 0 0 no-repeat;
			}
			#profile .avatar{
				width:68px;
				border:3px solid #fff;
				margin:23px 0 0;
				border-radius:50%;
			}
			#profile  p{
				font-weight:600;
				font-size:15px;
				margin:118px 0 -1px;
				opacity:0;
				-webkit-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
				-moz-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
				-ms-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
				-o-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
				transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000); 
			}
			#profile  p.animate{
				margin-top:97px;
				opacity:1;
				-webkit-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
				-moz-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
				-ms-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
				-o-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
				transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000); 
			}
			#profile  span{
				font-weight:400;
				font-size:11px;
			}
			#chat-messages{
				opacity:0;
				margin-top:30px;
				width:290px;
				height:270px;
				overflow-y:scroll;  
				overflow-x:hidden;
				padding-right: 20px;
				-webkit-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
				-moz-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
				-ms-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
				-o-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
				transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
			}
			#chat-messages.animate{
				opacity:1;
				margin-top:0;
			}
			#chat-messages label{
				color:#aab8c2;
				font-weight:600;
				font-size:12px;
				text-align:center;
				margin:15px 0;
				width:290px;
				display:block;  
			}
			#chat-messages div.message{
				padding:0 0 30px 58px;
				clear:both;
				margin-bottom:45px;
			}
			#chat-messages div.message.right{
				padding: 0 58px 30px 0;
				margin-right: -19px;
				margin-left: 19px;
			}
			#chat-messages .message img{
				float: left;
				margin-left: -38px;
				border-radius: 50%;
				width: 30px;
				margin-top: 12px;
			}
			#chat-messages div.message.right img{
				float: right;   
				margin-left: 0;
				margin-right: -38px;    
			}
			.message .bubble{   
				background:#f0f4f7;
				font-size:13px;
				font-weight:600;
				padding:12px 13px;
				border-radius:5px 5px 5px 0px;
				color:#8495a3;
				position:relative;
				float:left;
			}
			#chat-messages div.message.right .bubble{
				float:right;
				border-radius:5px 5px 0px 5px ;
			}
			.bubble .corner{
				background:url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/bubble-corner.png") 0 0 no-repeat;
				position:absolute;
				width:7px;
				height:7px;
				left:-5px;
				bottom:0;
			}
			div.message.right .corner{
				background:url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/bubble-cornerR.png") 0 0 no-repeat;
				left:auto;
				right:-5px;
			}
			.bubble span{
				color: #aab8c2;
				font-size: 11px;
				position: absolute;
				right: 0;
				bottom: -22px;
			}
			#sendmessage{
				height:60px;
				border-top:1px solid #e7ebee;   
				position:absolute;
				bottom:0;
				right:0px;
				width:290px;
				background:#fff;
				padding-bottm:50px;
			}
			#sendmessage input{
				border
			}
			#sendmessage input{
				background:#fff;
				margin:21px 0 0 21px;
				border:none;
				padding:0;
				font-size:14px;
				font-family:"Open Sans", sans-serif; 
				font-weight:400px;
				color:#aab8c2;
			}
			#sendmessage input:focus{
				outline: 0;
			}
			#sendmessage button{
				background:#fff url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/send.png") 0 -41px no-repeat;
				width:30px;
				height:30px;
				position:absolute;
				right: 15px;
				top: 23px;
				border:none;
			}
			#sendmessage button:hover{
				cursor:pointer;
				background-position: 0 0 ;
			}
			#sendmessage button:focus{
				outline: 0;  
			}

			#close{
				position:absolute;
				top: 8px;   
				opacity:0.8;
				right: 10px;
				width:20px;
				height:20px;
				cursor:pointer;
			}
			#close:hover{
				opacity:1;
			}
			.cx, .cy{
				background:#fff;
				position:absolute;
				width:0px;
				top:15px;
				right:15px;
				height:3px;
				-webkit-transition: all 250ms ease-in-out;
				-moz-transition: all 250ms ease-in-out;
				-ms-transition: all 250ms ease-in-out;
				-o-transition: all 250ms ease-in-out;
				transition: all 250ms ease-in-out;
			}
			.cx.s1, .cy.s1{ 
				right:0;    
				width:20px; 
				-webkit-transition: all 100ms ease-out;
				-moz-transition: all 100ms ease-out;
				-ms-transition: all 100ms ease-out;
				-o-transition: all 100ms ease-out;
				transition: all 100ms ease-out;
			}
			.cy.s2{ 
				-ms-transform: rotate(50deg); 
				-webkit-transform: rotate(50deg); 
				transform: rotate(50deg);        
				-webkit-transition: all 100ms ease-out;
				-moz-transition: all 100ms ease-out;
				-ms-transition: all 100ms ease-out;
				-o-transition: all 100ms ease-out;
				transition: all 100ms ease-out;
			}
			.cy.s3{ 
				-ms-transform: rotate(45deg); 
				-webkit-transform: rotate(45deg); 
				transform: rotate(45deg);        
				-webkit-transition: all 100ms ease-out;
				-moz-transition: all 100ms ease-out;
				-ms-transition: all 100ms ease-out;
				-o-transition: all 100ms ease-out;
				transition: all 100ms ease-out;
			}
			.cx.s1{ 
				right:0;    
				width:20px; 
				-webkit-transition: all 100ms ease-out;
				-moz-transition: all 100ms ease-out;
				-ms-transition: all 100ms ease-out;
				-o-transition: all 100ms ease-out;
				transition: all 100ms ease-out;
			}
			.cx.s2{ 
				-ms-transform: rotate(140deg); 
				-webkit-transform: rotate(140deg); 
				transform: rotate(140deg);       
				-webkit-transition: all 100ms ease-out;
				-moz-transition: all 100ms ease-out;
				-ms-transition: all 100ease-out;
				-o-transition: all 100ms ease-out;
				transition: all 100ms ease-out;
			}
			.cx.s3{ 
				-ms-transform: rotate(135deg); 
				-webkit-transform: rotate(135deg); 
				transform: rotate(135deg);       
				-webkit-transition: all 100ease-out;
				-moz-transition: all 100ms ease-out;
				-ms-transition: all 100ms ease-out;
				-o-transition: all 100ms ease-out;
				transition: all 100ms ease-out;
			}
			#chatview, #sendmessage { 
				overflow:hidden; 
				border-radius:6px; 
			}
			.badge {
				display: block;
				position: absolute;
				top: 26px;
				right: 43px;
				line-height: 16px;
				height: 16px;
				padding: 0 5px;
				font-family: Arial, sans-serif;
				color: white;
				text-shadow: 0 1px rgba(0, 0, 0, 0.25);
				border: 1px solid;
				border-radius: 10px;
				-webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.3), 0 1px 1px rgba(0, 0, 0, 0.08);
				box-shadow: inset 0 1px rgba(255, 255, 255, 0.3), 0 1px 1px rgba(0, 0, 0, 0.08);
			}
			.badge {
				background: #67c1ef;
				border-color: #30aae9;
				background-image: -webkit-linear-gradient(top, #acddf6, #67c1ef);
				background-image: -moz-linear-gradient(top, #acddf6, #67c1ef);
				background-image: -o-linear-gradient(top, #acddf6, #67c1ef);
				background-image: linear-gradient(to bottom, #acddf6, #67c1ef);
			}

			.badge.green {
				background: #77cc51;
				border-color: #59ad33;
				background-image: -webkit-linear-gradient(top, #a5dd8c, #77cc51);
				background-image: -moz-linear-gradient(top, #a5dd8c, #77cc51);
				background-image: -o-linear-gradient(top, #a5dd8c, #77cc51);
				background-image: linear-gradient(to bottom, #a5dd8c, #77cc51);
			}

			.badge.yellow {
				background: #faba3e;
				border-color: #f4a306;
				background-image: -webkit-linear-gradient(top, #fcd589, #faba3e);
				background-image: -moz-linear-gradient(top, #fcd589, #faba3e);
				background-image: -o-linear-gradient(top, #fcd589, #faba3e);
				background-image: linear-gradient(to bottom, #fcd589, #faba3e);
			}

			.badge.red {
				background: #fa623f;
				border-color: #fa5a35;
				background-image: -webkit-linear-gradient(top, #fc9f8a, #fa623f);
				background-image: -moz-linear-gradient(top, #fc9f8a, #fa623f);
				background-image: -o-linear-gradient(top, #fc9f8a, #fa623f);
				background-image: linear-gradient(to bottom, #fc9f8a, #fa623f);
			}
		</style>

	</head>
	<body>
		<audio id="myAudio">
			<source src="face.mp3" type="audio/mpeg">
				Your browser does not support the audio element.
			</audio>

			<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

			<a id="view-code" href="cikis.php">Çıkış Yap</a>

			<div id="chatbox">
				<div id="friendslist">
					<div id="topmenu">
						<span class="friends"></span>
						<span class="chats"></span>
						<span class="history"></span>
					</div>

					<div id="friends">
						<?php if($query->rowCount()): ?>

							<?php foreach($query as $row): ?>
								<?php $uid = $row['gonderen']; ?>
								<?php $query2 = $db->query("SELECT * FROM uyeler WHERE id = $uid")->fetch(PDO::FETCH_ASSOC); ?>
								<div id="aliciolan-<?php echo $row['id'] ?>" data-konusmaid="<?php echo $row['id'] ?>" class="friend" data-id="<?php echo $query2['id'] ?>">
									<img src="<?php echo $query2['uye_foto'] ?>" />
									<p>
										<strong><?php echo $query2['uye_adi'] ?></strong><br>
										<span id="ufakmesaj-<?php echo $query2['id']; ?>">Naber</span>
									</p>
									<div id="durum-<?php echo $query2['id']; ?>" class="status <?php echo ($query2['uye_durum'] == 0) ? 'inactive' : 'available' ?>"></div>
									<?php $konusmaidsi = $row['id']; ?>
									<?php $query3 = $db->query("SELECT * FROM mesajlar WHERE konusma = $konusmaidsi ORDER BY id DESC ", PDO::FETCH_ASSOC); ?>
									<?php $okunmamis = 0; ?>
									<?php foreach($query3 as $row2){
										if($row2['goruldu'] == 0 AND $row2['alici'] == $_SESSION['id']) {
											$okunmamis++;
										}
									}
									?>
									<?php if($okunmamis != 0): ?>
										<span id="okunmamismesaj-<?php echo $row['id'] ?>" class="badge red"><?php echo $okunmamis; ?></span>
									<?php endif; ?>
								</div>

							<?php endforeach; ?>
						<?php endif; ?>

						<div id="search">
							<input type="text" id="searchfield" value="Search contacts..." />
						</div>

					</div>                

				</div>  

				<?php foreach($koquery2 as $row2): ?>
					<?php $konusma = $row2['id'] ?>
					<?php $mesajquery = $db->query("SELECT * FROM mesajlar WHERE konusma = $konusma ORDER BY id ASC", PDO::FETCH_ASSOC); ?>
					<div id="chatview" class="konusma-<?php echo $konusma ?> p2">      
						<div id="profile">

							<div id="close">
								<div class="cy"></div>
								<div class="cx"></div>
							</div>

							<p>Miro Badev</p>
							<span>miro@badev@gmail.com</span>
						</div>
						<div id="chat-messages">
							<label>Thursday 02</label>

							<?php foreach($mesajquery as $mrow): ?>


								<?php if($mrow['alici'] == $_SESSION['id']){ ?>

									<div id="gelenmesaj">
										<div class="message">
											<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1_copy.jpg" />
											<div class="bubble">
												<?php echo $mrow['mesaj']; ?>
												<div class="corner"></div>
											</div>
										</div>
									</div>

								<?php }else{ ?>

									<div id="gidenmesaj">
										<div class="message right">
											<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/2_copy.jpg" />
											<div class="bubble">
												<?php echo $mrow['mesaj']; ?>
												<div class="corner"></div>
											</div>
										</div>
									</div>

								<?php } ?>

							<?php endforeach; ?>

						</div>


						<ul id="messages"></ul><!-- Gelen mesajları yazdırmak için bir liste oluşturuyoruz. -->

						<form action="">
							<div id="sendmessage">
								<input id="m-<?php echo $row2['id'] ?>" type="text" onkeyup="test(<?php echo $row2['id'] ?>)" name="mesaj" placeholder="Bir mesaj yaz..." />
								<input id="userid-<?php echo $row2['id'] ?>" type="hidden" value="<?php echo $_SESSION['id'] ?>" />
								<input id="alici-<?php echo $row2['id'] ?>" type="hidden" value="<?php echo ($row2['alici'] == $_SESSION['id']) ? $row2['gonderen'] : $row2['alici'] ?>" />
								<button id="send"></button>
							</div>
						</form>

					</div>        
				<?php endforeach; ?>
			</div>  

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

			<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>

			<script>

				var socket = io('http://89.252.169.34:5000');

				function test($koid){
					var mesaj = $("#m-"+$koid).val();
					var id = $("#userid-"+$koid).val();

					if(mesaj == "") {
						$.ajax({
							url: "yaziyor.php",
							type: "post",
							data: {
								"yaziyor":0,
								"userid":id
							}
						});
					}else {
						$.ajax({
							url: "yaziyor.php",
							type: "post",
							data: {
								"yaziyor":1,
								"userid":id
							}
						});
					}

				}

				socket.on('goruldu', function(msg){

					console.log(msg);
					var id = $("#userid").val();

					if(msg.goruldu == 0){
						$("#goruldumsg").remove();
						$("#gidenmesaj .message .bubble").last().append('<span id="goruldumsg">Görüldü</span>');
					}

				});

				socket.on('yaziyor', function(msg) {

					console.log(msg);

					if(msg.yaziyor == 1){
						$("#ufakmesaj-"+msg.userid).text("yaziyor...");
					}else {
						$("#ufakmesaj-"+msg.userid).text("Naber");
					}

				});


				$(function () {
					$('form').submit(function (e) { /* Formu göndermek için alıyor. */
                e.preventDefault(); // Sayfanın yenilenmesini engelliyor.

                var konusmaidsi = sessionStorage.getItem('konusmaidsi');

                var mesaj = $("#m-"+konusmaidsi).val();
                var id = $("#userid-"+konusmaidsi).val();
                var aid = $("#alici-"+konusmaidsi).val();

                $.ajax({
                	url: "mesajgonderim.php",
                	type: "post",
                	data: {
                		"mesaj":mesaj,
                		"userid":id,
                		"alici":aid,
                		"konusma":konusmaidsi
                	}
                });

                $("#m-"+konusmaidsi).val('');
            });

					socket.on('durum', function (msg) {

						console.log(msg);

						if(msg.durum == 1){

							$("#durum-"+msg.id).addClass("available");
							$("#durum-"+msg.id).removeClass("inactive");
						}else if(msg.durum == 0){

							$("#durum-"+msg.id).removeClass("available");
							$("#durum-"+msg.id).addClass("inactive");

						}

					});

					socket.on('chat message', function (msg) { /* yukarıda emit diyerek mesajı yayınladığımız gibi eğer bana chat message başlığı ile bir mesaj gelirse onu ekrana yazdır diyoruz. */
					// $('#messages').append($('<li>').text(msg)); /* gelen mesajı message id'sine sahip elemente text olarak yazdır diyoruz. */
					console.log(msg);

					var benimid = $("#userid-"+msg.konusmaid).val();


					if(msg.userid != benimid) {

						$('.konusma-'+msg.konusmaid+' #chat-messages').append(`

							<div id="gelenmesaj">
							<div class="message">
							<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1_copy.jpg" />
							<div class="bubble">
							${msg.test}
							<div class="corner"></div>
							</div>
							</div>
							</div>
							`);

					}else {

						$('.konusma-'+msg.konusmaid+' #chat-messages').append(`

							<div id="gidenmesaj">
							<div class="message right">
							<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1_copy.jpg" />
							<div class="bubble">
							${msg.test}
							<div class="corner"></div>
							</div>
							</div>
							</div>
							`);

					}

					$(document).ready(function() {
						$('.konusma-'+msg.konusmaid+' #chat-messages').animate({
							scrollTop: 9999
						}, 1);
					});

					var sayiyaptim = parseInt($("#okunmamismesaj-"+msg.konusmaid).text());

					if(sayiyaptim){

						if(msg.userid == $("#aliciolan-"+msg.konusmaid).data("id")){

							var x = document.getElementById("myAudio");

							x.play();

							sayiyaptim++;

							var mesaj = sayiyaptim.toString();

							$("#okunmamismesaj-"+msg.konusmaid).text(mesaj);

							

						}

					}else {
						
						if(msg.userid == $("#aliciolan-"+msg.konusmaid).data("id")){
							$("#aliciolan-"+msg.konusmaid).append('<span id="okunmamismesaj-'+msg.konusmaid+'" class="badge red">1</span>');

							var x = document.getElementById("myAudio");

							x.play();
						}

					}

					
				});
				});

				$(document).ready(function(){

					var preloadbg = document.createElement("img");
					preloadbg.src = "https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/timeline1.png";

					$("#searchfield").focus(function(){
						if($(this).val() == "Search contacts..."){
							$(this).val("");
						}
					});
					$("#searchfield").focusout(function(){
						if($(this).val() == ""){
							$(this).val("Search contacts...");

						}
					});

					

					$(".friend").each(function(){       
						$(this).click(function(){

							var konusma = $(this).data("konusmaid");

							var childOffset = $(this).offset();
							var parentOffset = $(this).parent().parent().offset();
							var childTop = childOffset.top - parentOffset.top;
							var clone = $(this).find('img').eq(0).clone();
							var top = childTop+12+"px";

							$(clone).css({'top': top}).addClass("floatingImg").appendTo("#chatbox");    
							$(".konusma-"+konusma+" #chat-messages").animate({
								scrollTop: 9999
							}, 1);

							$.ajax({
								url: "goruldu.php",
								type: "post",
								data: {
									"goruldu":0,
									"konusma":konusma
								}
							});

							var gorulduset = setInterval(function(){

								$.ajax({
									url: "goruldu.php",
									type: "post",
									data: {
										"goruldu":0,
										"konusma":konusma
									}
								});

								$("#okunmamismesaj-"+konusma).remove();


							}, 2000);

							$("#okunmamismesaj-"+konusma).remove();

							setTimeout(function(){$(".konusma-"+konusma+" #profile p").addClass("animate");$(".konusma-"+konusma+" #profile").addClass("animate");}, 100);
							setTimeout(function(){
								$(".konusma-"+konusma+" #chat-messages").addClass("animate");
								$(".konusma-"+konusma+" .cx, .cy").addClass('s1');
								setTimeout(function(){$(".konusma-"+konusma+" .cx, .cy").addClass('s2');}, 100);
								setTimeout(function(){$(".konusma-"+konusma+" .cx, .cy").addClass('s3');}, 200);         
							}, 150);                                                        

							$('.floatingImg').animate({
								'width': "68px",
								'left':'108px',
								'top':'20px'
							}, 200);

							var name = $(this).find("p strong").html();
							var email = $(this).find("p span").html();                                                      
							$(".konusma-"+konusma+" #profile p").html(name);
							$(".konusma-"+konusma+" #profile span").html(email);         

							$(".konusma-"+konusma+" .message").not(".right").find("img").attr("src", $(clone).attr("src"));                                  
							$('#friendslist').fadeOut();
							$('.konusma-'+konusma).fadeIn();

							sessionStorage.setItem('konusmaidsi', konusma);

							$('.konusma-'+konusma+' #close').unbind("click").click(function(){  
								clearInterval(gorulduset);             

								sessionStorage.removeItem('konusmaidsi');
								$(".konusma-"+konusma+" #chat-messages, #profile, #profile p").removeClass("animate");
								$(".konusma-"+konusma+" .cx, .cy").removeClass("s1 s2 s3");
								$(".floatingImg").animate({
									'width': "40px",
									'top':top,
									'left': '12px'
								}, 200, function(){$(".konusma-"+konusma+" .floatingImg").remove()});                

								setTimeout(function(){
									$(".konusma-"+konusma).fadeOut();
									$('#friendslist').fadeIn();             
								}, 50);
							});

						});
					});         
				});

			</script>



		</body>
		</html>

	<?php endif; ?>
	<?php if(!$_SESSION['login']): ?>

		<?php 




		if($_POST) {

			$mail = $_POST['mail'];

			try {
				$db = new PDO("mysql:host=localhost;dbname=nerorpgc_sohbet", "nerorpgc_sohbet", "Kadirbaba1961*");
			} catch ( PDOException $e ){
				print $e->getMessage();
			}

			$query = $db->query("SELECT * FROM uyeler WHERE uye_mail = '{$mail}'")->fetch(PDO::FETCH_ASSOC);
			if ( $query ){

				$id = $query['id'];

				$query2 = $db->query("UPDATE uyeler SET uye_durum = 1 WHERE id = $id");
				$_SESSION['login'] = TRUE;
				$_SESSION['id'] = $query['id'];

				echo $_POST['userid'];


				$client = new Client(new Version2X('http://89.252.169.34:5000'));

				$client->initialize();
				$client->emit('durum', [
					'durum' => "1",
					'id' => $id
				]);

			}

		}


		?>

		<form action="" method="post">

			<input type="mail" name="mail">
			<button type="submit">Gönder</button>

		</form>

		<?php endif; ?>