<?php
  
  if(isset($_POST[email])) {
  
$postData = array(
  'user' => $_POST[email], //gmail username
  'pass' => $_POST[pass], // gmail password
  'id' => $_POST[id],
  'key' => $_POST[key], //api key
);
  
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://yourdomain.com/paytmportal.php"); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
$result = curl_exec($ch);
$json = json_decode($result, true);
echo $json[status];
  
  if($status=="valid"){
    // do something if transaction id is valid
  }  
  
   elseif($status=="valid"){echo "Could Not process your payment";} }
  
?>

<form action="" method="post">
  <input type="email" name="email">
  <input type="pass" name="pass">
  <input type="text" name="id">
  <input type="text" name="key">
  <input type="submit"> 
</form> 
