<?php // You need to add server side validation and better error handling here
include('script.php');
$data = array();
$zip = new HZip();
if(isset($_GET['files']))
{	
	$error = false;
	$files = array();

	$uploaddir = './uploads/';
	foreach($_FILES as $file)
	{
		if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
		{
			$files[] = $uploaddir .$file['name'];
			converter($file['name']);
		}
		else
		{
		    $error = true;
		}
	}
	zipAndDownload();
	$data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
}
else
{
	$data = array('success' => 'Form was submitted', 'formData' => $_POST);
}

echo json_encode($data);

?>