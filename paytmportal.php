<?php

$username = $_POST[user]; // or set your username here : $username = "USERNAME";
$password = $_POST[pass]; // or set your password here : $password = "PASSWORD";
$api = "YOUR-SECRET-API"; // set your api key here

if(isset($_POST[key]) && $_POST[key]==$api){
  
$transid = $_POST[id];

// Connect to gmail

$imapPath = '{imap.gmail.com:993/imap/ssl}INBOX';

function get_string_between($string, $start, $end)
  {
  $string = " " . $string;
  $ini = strpos($string, $start);
  if ($ini == 0) return "";
  $ini+= strlen($start);
  $len = strpos($string, $end, $ini) - $ini;
  return substr($string, $ini, $len);
  }

// try to connect

$inbox = imap_open($imapPath, $username, $password) or die('Cannot connect to Gmail: ' . imap_last_error());
/* ALL - return all messages matching the rest of the criteria
ANSWERED - match messages with the \\ANSWERED flag set
BCC "string" - match messages with "string" in the Bcc: field
BEFORE "date" - match messages with Date: before "date"
BODY "string" - match messages with "string" in the body of the message
CC "string" - match messages with "string" in the Cc: field
DELETED - match deleted messages
FLAGGED - match messages with the \\FLAGGED (sometimes referred to as Important or Urgent) flag set
FROM "string" - match messages with "string" in the From: field
KEYWORD "string" - match messages with "string" as a keyword
NEW - match new messages
OLD - match old messages
ON "date" - match messages with Date: matching "date"
RECENT - match messages with the \\RECENT flag set
SEEN - match messages that have been read (the \\SEEN flag is set)
SINCE "date" - match messages with Date: after "date"
SUBJECT "string" - match messages with "string" in the Subject:
TEXT "string" - match messages with text "string"
TO "string" - match messages with "string" in the To:
UNANSWERED - match messages that have not been answered
UNDELETED - match messages that are not deleted
UNFLAGGED - match messages that are not flagged
UNKEYWORD "string" - match messages that do not have the keyword "string"
UNSEEN - match messages which have not been read yet*/

// search and get unseen emails, function will return email ids

$emails = imap_search($inbox, 'SUBJECT "You have received"');
$output = '';

foreach($emails as $mail)
  {
  $message = imap_fetchbody($inbox, $mail, 1.1);
  $headerInfo = imap_headerinfo($inbox, $mail);
  $output.= $headerInfo->subject . '<br/>';
  $output.= $headerInfo->toaddress . '<br/>';
  $output.= $headerInfo->date . '<br/>';
  $output.= $headerInfo->fromaddress . '<br/>';
  $output.= $headerInfo->reply_toaddress . '<br/>';

  // --------------------------------------------------

  $fullstring = $message;
  $parsed_amount = get_string_between($fullstring, "sent you Rs. ", "to your Paytm wallet");
  $parsed_1 = get_string_between($fullstring, "your transaction id is ", "You can use the ");
  $parsed_2 = str_replace(" .</p>", '', $parsed_1);
  $parsed_3 = str_replace("<p>", '', $parsed_2);
  $parsed_id = preg_replace('/\s+/', '', $parsed_3);

  // --------------------------------------------------

  $emailStructure = imap_fetchstructure($inbox, $mail);
  if (!isset($emailStructure->parts))
    {
    $output.= imap_body($inbox, $mail, FT_PEEK);
    }

  $arr[] = array(
    $parsed_amount,
    $parsed_id,
    $headerInfo->date
  );
  }

imap_expunge($inbox);
imap_close($inbox);

foreach($arr as $value)
  {
  if ($value[1] == $transid)
    {
    $arr_result = array(
      status => "valid",
      id => $value[1],
      amount => $value[0],
      date => $value[2]
    );
    echo json_encode($arr_result);
    }
  }

if (!isset($arr_result))
  {
  $notfound = array(
    status => "invalid",
  );
  echo json_encode($notfound);
  }
}
?>
