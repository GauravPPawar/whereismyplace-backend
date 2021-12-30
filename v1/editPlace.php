<?php
	require_once '../includes/DbOperations.php';
	$response = array();

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$db = new DbOperations();

		if (isset($_POST['username']) and isset($_POST['oldLocName']) and isset($_POST['newLocName'])) 
		{
			$result = $db->editData(
						$_POST['username'],
						$_POST['oldLocName'],
						$_POST['newLocName']
				);

			if($result == 1)
			{
				$response['error'] = false;
				$response['message'] = "Edited place name";	
			}
			else
			{
				$response['error'] = true;
			 	$response['message'] = "Error while editing the data";	
			}

		}
	}
	echo json_encode($response);
?>