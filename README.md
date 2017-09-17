# Paytm Payment Verification (PHP)

This script allows user registration only only for people with valid PayTM Transaction ID. While registration the PayTM transaction ID and payment amount is matched so allow user registattion.

## How does it work ?

When a transaction is made both the sender and the receiver receives an email which has the same transaction id. This script takes the transaction id from the participant and verifies it from the receiver's inbox. If the amount and transaction id matches the user's name and registration number gets registered in the database.

## Information to be added by you in the script ?
1. Gmail credentials
2. Database details
3. The amount that the user must have paid to register

## Important points :

1. mysql dump has should be imported first
2. then the script should be edited with databse and gmail credentials
3. gmail account should be set to allow access to less secure apps through this link : https://myaccount.google.com/lesssecureapps
