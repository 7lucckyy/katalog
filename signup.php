<?php
include 'config.php';

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

try{
  // $json_string = file_get_contents( "php://input");
  // $data = json_decode($json_string,true);
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];

  
  $fileName  =  $_FILES['logosrc']['name'];
  $tempPath  =  $_FILES['logosrc']['tmp_name'];
  $fileSize  =  $_FILES['logosrc']['size'];

	
    //Logo uplad block
    
        $date = date_create();
        $newfile =  date_timestamp_get($date). "-" .$fileName;

        
        if(empty($newfile))
        {
          $errorMSG = json_encode(array("message" => "please select image", "status" => false));	
          echo $errorMSG;
        }
        else
        {
          // $upload_path = getCwd(); 
            $upload_path = "upload/";
          
          $fileExt = strtolower(pathinfo($newfile,PATHINFO_EXTENSION));
          ; // get image extension
            
          // valid image extensions
          $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); 
                  
          // allow valid image file formats
          if(in_array($fileExt, $valid_extensions))
          {				
            //check file not exist our upload folder path
            if(!file_exists($upload_path . $newfile ))
            {
              // check file size '5MB'
              if($fileSize < 5000000){



                move_uploaded_file($tempPath, $upload_path . $newfile);
              // move file from system temporary path to our upload folder path 
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

        $logosrc = $upload_path . $newfile;
        
        

        $password= password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user_id = uniqid();

        $sql = "INSERT INTO `users`( `id`,`name`, `email`,`phone`,`password`, `logosrc`) 
		    VALUES ('$user_id','$name','$email','$phone','$password', '$logosrc')";
        if (mysqli_query($conn, $sql)) {
                $logoImg = [
                  "src" => $logosrc
                ];
                $message = json_encode(array("message" => "User Created Successfully", "success" => true, "status" => 201, "logoImg" => $logosrc));	
                http_response_code(201);
                echo $message;
        } 
        else {
        
          http_response_code(400);
                $message = json_encode(array("message" => mysqli_error($conn), "status" => false));	
                echo $message;
    

        }
            
}
catch(Exception $e) {
  http_response_code(400);
    echo 'Message: ' .$e->getMessage();
  }

?>