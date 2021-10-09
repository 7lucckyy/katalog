<?php
include 'config.php';
header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

$product_id = uniqid();
$users_id = uniqid();
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];

if(!isset($name) || !isset($description) || !isset($price)){
	http_response_code(400);
    echo ("Name, Decription and Price are required");
	exit();
}

$fileName  =  $_FILES['frontimage']['name'];
$tempPath  =  $_FILES['frontimage']['tmp_name'];
$fileSize  =  $_FILES['frontimage']['size'];

$fileName1  =  $_FILES['backimg']['name'];
$tempPath1  =  $_FILES['backimg']['tmp_name'];
$fileSize1  =  $_FILES['backimg']['size'];

$fileName2  =  $_FILES['sideimg']['name'];
$tempPath2  =  $_FILES['sideimg']['tmp_name'];
$fileSize2  =  $_FILES['sideimg']['size'];

$fileName3  =  $_FILES['leftimg']['name'];
$tempPath3  =  $_FILES['leftimg']['tmp_name'];
$fileSize3  =  $_FILES['leftimg']['size'];

$fileName4  =  $_FILES['rightimg']['name'];
$tempPath4  =  $_FILES['rightimg']['tmp_name'];
$fileSize4  =  $_FILES['rightimg']['size'];


$date = date_create();
$newfile =  date_timestamp_get($date). "-" .$fileName;
$newfile1 =  date_timestamp_get($date). "-" .$fileName1;
$newfile2 =  date_timestamp_get($date). "-" .$fileName2;
$newfile3 =  date_timestamp_get($date). "-" .$fileName3;
$newfile4 =  date_timestamp_get($date). "-" .$fileName4;

if(empty($newfile || $newfile1 || $newfile2 || $newfile3 || $newfile4))
{
	$errorMSG = json_encode(array("message" => "please select image", "status" => false));	
	echo $errorMSG;
	
}
else
{

    $upload_path = "upload/";
	
	$fileExt = strtolower(pathinfo($newfile,PATHINFO_EXTENSION));
	$fileExt1 = strtolower(pathinfo($newfile1,PATHINFO_EXTENSION));
	$fileExt2 = strtolower(pathinfo($newfile2,PATHINFO_EXTENSION));
	$fileExt3 = strtolower(pathinfo($newfile3,PATHINFO_EXTENSION));
	$fileExt4 = strtolower(pathinfo($newfile4,PATHINFO_EXTENSION)); // get image extension
		
	// valid image extensions
	$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); 
					
	// allow valid image file formats
	if(in_array($fileExt && $fileExt1 && $fileExt2 && $fileExt3 && $fileExt4, $valid_extensions))
	{				
		//check file not exist our upload folder path
		if(!file_exists($upload_path . $newfile || $upload_path . $newfile1 || $upload_path . $newfile2 || $upload_path . $newfile3 || $upload_path . $newfile4))
		{
			// check file size '5MB'
			if($fileSize < 5000000){



				move_uploaded_file($tempPath, $upload_path . $newfile);
				move_uploaded_file($tempPath1, $upload_path . $newfile1);
				move_uploaded_file($tempPath2, $upload_path . $newfile2);
				move_uploaded_file($tempPath3, $upload_path . $newfile3);
				move_uploaded_file($tempPath4, $upload_path . $newfile4); // move file from system temporary path to our upload folder path 
			}
			else{		
				$errorMSG = json_encode(array("message" => "Sorry, your file is too large, please upload 5 MB size", "status" => false));	
				echo $errorMSG;
			}
		}
		else
		{		
			$errorMSG = json_encode(array("message" => "Sorry, file already exists check upload folder", "status" => false));	
			echo $errorMSG;
		}
	}
	else
	{		http_response_code(400);
		$errorMSG = json_encode(array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed", "status" => false));	
		echo $errorMSG;		
	}
}

$imageName = $upload_path . $newfile;
$imageName1 = $upload_path . $newfile1;
$imageName2 = $upload_path . $newfile2;
$imageName3 = $upload_path . $newfile3;
$imageName4 = $upload_path . $newfile4;

$sql = "INSERT INTO `products`( `id`, `users_id`,`name`, `description`,`price`,`frontimg`, `backimg`, `sideimg`, `rightimg`, `leftimg`) 
		    VALUES ('$product_id', '$users_id','$name', '$description','$price','$imageName', '$imageName1', '$imageName2', '$imageName3', '$imageName4')";
        if (mysqli_query($conn, $sql)) {
                	
                http_response_code(201);
                
                
				$images = [
					"src1" => $imageName,
					"src2" => $imageName1,
					"src3" => $imageName2,
					"src4" => $imageName3,
					"src5" => $imageName4
				];
                $message = json_encode(array("message" => "Product Created Successfully", "success" => true, "status"=> 201,"images" => $images));
				echo $message;
        } 
        else {
        
	        http_response_code(400);
            $message = json_encode(array("message" => mysqli_error($conn), "status" => false));	
            echo $message;
				
			

        }       

?>