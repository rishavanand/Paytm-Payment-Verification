# Paytm Payment Gateway (PHP)

Paytm has its own official api but to get acces to the api users need to have transactions of atleast Rs.10,000 / mo. To break this restriction here is a light PHP script that will help users to accept payments via Paytm on their sites even if they dont have monthly transactions of Rs.10,000 thus becoming a perfect payment gateway for small businesses.

## How does it work ?

1. A user wants to make a payment on your site.
2. You ask the user to send a money to your Paytm Wallet. (which is linked to your Gmail account)
3. After the user sends the amount to your wallet, the user and you receive an email from Paytm with the transaction id.
4. The user is asked to enter the transation id on your site.
5. The script takes the transaction id > then reads your email from Paytm > looks for the specific transaction id and then displays the details of the transaction.

You can now use this information to proceed with the transaction. 
Eg : if(transaction id and amount is correct)
else {output "Please try again"}

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

## Features that can be added as per your convinience.

1. Storing the transaction id in your database to prevent multiple usage of a single transaction id. 
