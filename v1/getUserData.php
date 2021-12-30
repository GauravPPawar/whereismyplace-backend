<?php
	require_once '../includes/DbOperations.php';
	$res1 = array();
	$res2 = array();
	$res3 = array();

	$response = array();

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$db = new DbOperations();

		$data = $db->getUserData($_POST['username']);	
		//print_r($response);
		$response['error'] = false;
		for($i=0;$i<count($data);$i+=1)
		{
				array_push($res1,$data[strval($i)]['0']);	
		}	
		$response['locName'] = $res1;

		for($i=0;$i<count($data);$i+=1)
		{
				array_push($res2,$data[strval($i)]['1']);	
		}
		$response['lat'] = $res2;
		reset($res1);
		
		for($i=0;$i<count($data);$i+=1)
		{
				array_push($res3,$data[strval($i)]['2']);	
		}
		$response['lon'] = $res3;
		// $response = $db->getUserLat($_POST['username']);		

		// print_r(json_encode($response));


		// $response = $db->getUserLon($_POST['username']);		

		// echo json_encode($response);
	}
	echo(json_encode($response));
?>