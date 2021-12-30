<?php
	require_once '../includes/DbOperations.php';
	$response = array();

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$db = new DbOperations();

		if (isset($_POST['username']) and isset($_POST['locName']) and isset($_POST['lat']) and isset($_POST['lon'])) {
			$result = $db->addData(
						$_POST['username'],
						$_POST['locName'],
						$_POST['lat'],
						$_POST['lon']
				);

			if($result == 1)
			{
				$response['error'] = false;
				$response['message'] = "Data added";	
			}
			else
			{
				$response['error'] = true;
			 	$response['message'] = "Error while adding the data";	
			}

		}
	}
	echo json_encode($response);
?>