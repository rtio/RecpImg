<?php
include_once('HZip.class.php');

function converter($filename){
    //$db = 'C:\xampp\htdocs\imagem\MON_FOTOS.GDB';
	$db = 'localhost:C:/xampp/htdocs/imagem/uploads/'.$filename;
	echo $db;
    $dbusername = 'sysdba';
    $dbpassword = 'masterkey';
    $query = "SELECT * FROM FOTOS";
	$dbh = ibase_connect($db, $dbusername, $dbpassword, 'UTF-8');
	$sth = ibase_query($dbh, $query);
	
	while ($row = ibase_fetch_object($sth)) {
		
		$blob_data = ibase_blob_info($row->FOTO);
		$blob_hndl = ibase_blob_open($row->FOTO);

		$fp = fopen("imagens_recp/".$row->MATRICULA.".bmp", "w");
		fwrite($fp, ibase_blob_get($blob_hndl, $blob_data[0]));
		fclose($fp);
		ibase_blob_close($blob_hndl);
	}   
    ibase_close($dbh);
}

function zipAndDownload(){
	HZip::zipDir('imagens_recp', 'imagens_down/imgs.zip'); 
	foreach (glob("imagens_recp/*.bmp") as $filename) {
   		echo "$filename size " . filesize($filename) . "\n";
   		unlink($filename);
	}
}

?>