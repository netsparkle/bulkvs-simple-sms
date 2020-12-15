# bulkvs-simple-sms
Simple script to relay an incoming text message to an email address on Bulkvs

Uses PHPMailer to send an email when a text message is received to a BulkVS DID that has SMS enabled on it.
Put this in your document root and then point BulkVS SMS settings on that DID to the [document-root]/sms.php address
Make sure to edit smtp-stuff.php so your emails work.
