<?php
$servername = "https://databases.000webhost.com/";
$username = "id9713655_akash";
$password = "123456";
$connected = false;


try {
    $conn = new PDO("mysql:host=$servername;dbname=id9713655_theintrepid", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connected = true;
}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

$type = $_POST['type'];
if($type == "1"){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  $sql = "INSERT INTO messages (id, name, email, message) VALUES (null,'".$name."', '".$email."', '".$message."')";
  $conn->exec($sql);
  echo "Data Saved";
}else if($type == "2"){
    $blog = $_POST['blog'];

    $stmt = $conn->prepare("SELECT * FROM comment_section WHERE blog='".$blog."'"); 
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result=$stmt->fetchAll();

    $response_string = '';
    $return_array = array();

    foreach ($result as $key => $value) {
      if($key % 2 == 0){
        $darker='darker';
      }else{
        $darker='';
      }
      $response_string.='<div class="container '.$darker.'"><span><b>'.$value["name"].' : </b>'.$value["comments"].'</span><span class="time-right">'.$value["date_time"].'</span></div>';
    }
    $return_array['status']='success';
    $return_array['data']=$response_string;
    echo json_encode($return_array);

}else if($type == "3"){
  $name = $_POST['name'];
  $comment = $_POST['comment'];
  $blog = $_POST['blog'];
  $sql = "INSERT INTO comment_section (id, blog, name, comments) VALUES (null,'".$blog."', '".$name."', '".$comment."')";
  $conn->exec($sql);
  echo "Data Saved";
}
