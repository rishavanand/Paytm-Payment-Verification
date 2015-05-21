# Paytm Payment Gateway (PHP)

Paytm has its own official api but to get acces to the api users need to have transactions of atleast Rs.10,000 / mo. To break this restriction here is a light PHP script that will help users to accept payments via Paytm on their sites even if they dont have monthly transactions of Rs.10,000 thus becoming a perfect payment gateway for small businesses.

## How does it work ?

It works on email sent via Paytm to your gmail account via IMAP.
It reads those emails and gets the transaction id , amount , and date and then makes an array out of it. It then takes in transacion id from you and checks it from the array. In a way it uses gmail as a database.

## So these two points are very important :

1. Your paytm account should be setup with Gmail only.
2. Do not delete any mails from paytm.

# The API

## Request URL:

```
curl -X GET -d '{"user":"gmail_username","pass":"gmail_password","id":"transaction_id"}' "http://yourdomain.com/paytome.php?user=[gmail_username]&pass=[gmail_password]&id=[transaction_id]&key=[api_key]"
```


## Request Body:

```
{
"user":"gmail_username",
"pass":"gmail_password",
"id":"transaction_id"
}
```


To get the status of an transaction id, send a GET request to http://yourdomain.com/paytmportal.php.

The response will be a JSON object with a key called droplet. This will be set to a JSON object that contains the transaction id details:

## Response Body:

```
{
"status":"valid",
"id":"TD71625FG72",
"amount":"1000",
"date":"Mon, 23 Mar 2015 22:24:22 +0530 (IST)"
}
```


status - Transaction id is valid or invalid
id - The transaction id.
amount - The transaction amount.
date - Date and time of transact

## NOTE :
Do not delete any emails from paytm from your gmail account.
