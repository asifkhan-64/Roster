<?php
$connection = mysqli_connect('localhost:3306', 'swatdiaries_smc_user', 'bf~[Yu}qG6Q=', 'swatdiaries_smc');
	if ($connection) {
 	//	echo "Connection Established!";
	}else{
		$err = "Data base Error";
		 $response = array(
            'code'=> "505", 
            'error'=> $err

           );
           $data['response'] = $response;
			header('Content-Type:application/json');
			echo json_encode($data);
			exit(); 
	}

?>