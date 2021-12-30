<?php
require_once '../includes/DbOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(isset($_POST['username']) and isset($_POST['locName']))
	{
		$db = new DbOperations();

		if($db->deleteLoc($_POST['username'],$_POST['locName']))
		{
			$response['error'] = false;
			$response['message']="deleted the place";
		}
		else{
			$response['error'] = true;
			$response['message'] = "Place not found";
		}
	}else{
			$response['error'] = true;
			$response['message'] = "Required fields are missing";			
	}
}
echo json_encode($response);