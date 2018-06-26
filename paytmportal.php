<?php

/**
 * paytmportal.php
 *
 * Author : Rishav Anand
 * Description : Paytm payment verification and participant registration script
 *
 */


//=== MODIFY VALUES BELOW ========

$decided_fee = '1';// decided registration fees - put here

//gmail Credentials
$username = '*********@gmail.com';
$password = '*********';

//datebase credentials
$servername = "localhost";
$db_username = "****";
$db_password = "****";
$db_name = "****";

//================================

//function to get string between two strings
function get_string_between($string, $start, $end){
  $string = " " . $string;
  $ini = strpos($string, $start);
  if ($ini == 0) return "";
  $ini+= strlen($start);
  $len = strpos($string, $end, $ini) - $ini;
  return substr($string, $ini, $len);
}
  

if(isset($_POST['tid']) && isset($_POST['reg']) && isset($_POST['sname'])){

  $transid = $_POST['tid'];

  //initializing connection to database
  $conn = new mysqli($servername, $db_username, $db_password, $db_name);
  if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
  } 

  //connect to gmail
  $imapPath = '{imap.gmail.com:993/imap/ssl}INBOX';

  //try to connect
  $inbox = imap_open($imapPath, $username, $password) or die('Cannot connect to Gmail: ' . imap_last_error());

  //search for emails with payment subject
  $emails = imap_search($inbox, 'SUBJECT "You have received Rs."');

  //for each found email extract the transaction id
  foreach($emails as $mail){

	$output = array();
	$fullstring = imap_fetchbody($inbox, $mail, 1);
	
	/* THIS PART CHANGES FREQUENTLY AS PAYTM UPDATES THEIR EMAIL FORMAT */

	$output['mob_number'] = get_string_between($fullstring, 'Linked to', '<');
	$output['mob_number'] = trim($output['mob_number']);
	$output['tid'] = get_string_between($fullstring, 'Transaction Id: ', 'Your');
	$output['tid'] = trim($output['tid']);
	$head = imap_headerinfo($inbox, $mail);
	$subject = $head->subject;
	$output['amount'] = get_string_between($subject, 'Rs.', ' ');
	$output['date'] = $head->date;

	/* ---------------------------------------------------------------- */

	$test_amount = round($output['amount']);
	
	if($output['tid'] == $transid && $test_amount == $decided_fee){
	  $sql = "INSERT INTO paytm (tid, date, amount, mob_number,name,reg)
	  VALUES ('".$output['tid']."', '".$output['date']."', '".$output['amount']."','".$output['mob_number']."','".$_POST['sname']."','".$_POST['reg']."')";
	  if ($conn->query($sql) === TRUE) {
		  $msg[0] = 'success';
		  $msg[] = 'You have been registered.';
	  } else {
		if (strpos($conn->error, 'Duplicate') !== false) {
			$msg[0] = 'error';
			$msg[1] = 'Already registered.';
		}
		else{
		  $msg[0] = 'error';
		  $msg[1] = $conn->error;
		}
	  }
	  $conn->close();
	}
	else{
	  $msg[0] = 'error';
	  $msg[1] = 'Invalid entry.';
	}

  }

  //imap closing statements
  imap_expunge($inbox);
  imap_close($inbox);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Mozilla Workshop Registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Registration form</h2>
   <?php
  if(isset($msg[0])){
	if($msg[0] == "success"){
	  $status1 = "success";
	  $status2 = "Success";
	}
	if($msg[0] == "error"){
	  $status1 = "danger";
	  $status2 = "Error";
	}
	echo '<div class="alert alert-'.$status1.'">
  <strong>'.$status2.'!</strong>  '.$msg[1].'
</div>';
  }
  ?>
  <form action="" method="POST">
	<div class="form-group">
	  <label for="email">Name :</label>
		<input type="text" name="sname" placeholder="Name" class="form-control" required>
	</div>
	<div class="form-group">
	  <label for="reg">Registration number :</label>
		<input type="text" name="reg" placeholder="Registration number" class="form-control" required>
	</div>
	<div class="form-group">
	  <label for="tid">PayTM transaction ID :</label>
		<input type="text" name="tid" placeholder="PayTM transcation ID" class="form-control" required>
	</div>
	<button type="submit" class="btn btn-primary">Register</button>
  </form>
</div>

</body>
</html>

