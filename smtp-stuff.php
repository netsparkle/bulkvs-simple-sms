<?php
$date = date("Y-m-d H:i:s");
# SMTP GATEWAY ACCOUNT - DEDICATED TO SMS RELAYING ONLY (DO NOT use your normal email account, make a new one for this)
$smtp_email = 'email@gmail.com';
$smtp_pass = 'password123';
$smtp_host = 'smtp.gmail.com';
$smtp_port = 587;
$smtp_protocol = 'tls';
$smtp_name = 'JENGAS SMS RELAY';
#make sure SMS replies go to the SMS GATEWAY ACCOUNT to be processed.
$reply_to = $smtp_email;
$reply_to_name = 'SMS GATEWAY';
$smtp_status = 'true';
#set the recipients for incoming SMS. DO NOT PUT YOUR SMS GATEWAY EMAIL HERE!!
$email = 'recipient1@gmail.com';
$cc = 'recipient2@gmail.com';
# SMS GATEWAY ACCOUNT - only edit this if you are not using gmail:
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = $smtp_email;
$password = $smtp_pass;
# BulkVS SMS Settings:
$BulkvsSmsTransmitterUrl = "https://portal.bulkvs.com/sendSMS";
$BulkvsPersonalApiKey    = "xxx";
$BulkvsPersonalApiSecret = "xxx";
//EOF
