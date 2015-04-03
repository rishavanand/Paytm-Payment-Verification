#Paytm-Payment-Gateway
A perfect payment gateway for small businesses.

How does it work ?
It works on email sent via Paytm to your gmail account via IMAP.
It reads those emails and gets the transaction id , amount , and date and then makes an array out of it. It then takes in transacion id from you and checks it from the array. In a way it uses gmail as a database.

So these two points are very important :
1. Your paytm account should be setup with Gmail only.
2. Do not delete any mails from paytm.

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
