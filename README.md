#Paytm-Payment-Gateway
Works on email sent via Paytm to your gmail account via IMAP.
A perfect payment gateway for small businesses.

The API

Request URL:

curl -X GET -d '{"user":"gmail_username","pass":"gmail_password","id":"transaction_id"}' "http://yourdomain.com/paytome.php?user=[gmail_username]&pass=[gmail_password]&id=[transaction_id]"


Request Body:

{
"user":"gmail_username",
"pass":"gmail_password",
"id":"transaction_id"
}


To get the status of an transaction id, send a GET request to http://yourdomain.com/paytome.php.

The response will be a JSON object with a key called droplet. This will be set to a JSON object that contains the transaction id details:

Response Body:

{
"status":"valid",
"id":"TD71625FG72",
"amount":"1000",
"date":"Mon, 23 Mar 2015 22:24:22 +0530 (IST)"
}


status - Transaction id is valid or invalid
id - The transaction id.
amount - The transaction amount.
date - Date and time of transact

NOTE :
Do not delete any email from paytm in your gmail account.
