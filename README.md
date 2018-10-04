# WHMCS-Scorecoin-Payment-Module
WHMCS-Scorecoin-Payment-Module
Move files in public_html into your WHMCS installation root.
File found at modules/gateways/callback/scorecoin.php should be ran as a cron job.  Run it as frequently as you want to check for payments.  When payments match invoice amount, invoice is marked as Paid. Scorecoin receiving address is marked on invoice as transaction.

Features unique payment address and account (accounts are named after %userid%-%invoiceid%) for each invoice.
Connects to scored rpc instance.  Currently only over http.

Future developments:
WHMCS scorecoin module add on for reviewing scorecoin wallet and sending credits back to clients from admin.

