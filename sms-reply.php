<?php
require $_SERVER['DOCUMENT_ROOT'].'/smtp-stuff.php';

/*
This code will only work if curl, php5-curl and php5-imap are all installed and enabled with the following (on Debian
based systems):
sudo apt-get install curl
sudo apt-get install php5-curl
sudo php5enmod curl
sudo apt-get install php5-imap
sudo php5enmod imap
sudo service apache2 restart

Make a CRON JOB "curl http://<PBX_OR_WEB_SERVER_ADDRESS>/sms-reply.php >/dev/null 2>&1"

The IMAP access/retrieval is a resource intensive process and takes longer when there are lots of messages in the
mailbox. Use a dedicated email account for this purpose. PLEASE DO NOT USE YOUR MAIN EMAIL ACCOUNT AS A GATEWAY!
*/

$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to imap mailbox: '.imap_last_error());

$check = imap_mailboxmsginfo($inbox);

$emails = imap_search($inbox,'ALL');

if($emails) {

	rsort($emails);
	
	foreach($emails as $email_number) {
	
		$email_headers = imap_fetch_overview($inbox,$email_number,0);
		$email_text = imap_fetchbody($inbox,$email_number,1);
		
		# If one or the other of the phone numbers is missing, the gateway can't process the email
		# and will simply delete it and exit:
		if ($Subject_Line_Array['SMS_FROM'] == "") {
			imap_delete($inbox, $email_number);
			echo "<br>Email number ".$email_number." has been deleted without further processing as SMS_FROM was missing.<br>";
			break;
		}
		if ($Subject_Line_Array['SMS_TO'] == "") {
			imap_delete($inbox, $email_number);
			echo "<br>Email number ".$email_number." has been deleted without further processing as SMS_TO was missing.<br>";
			break;
		}

		
		$sms_text = substr(strip_tags($email_text),0,150);

		if ($sms_text == "") {
			imap_delete($inbox, $email_number);
			break;
		}

		# curl command execution via curl php - works well:
		$ch = curl_init( $BulkvsSmsTransmitterUrl );
		$payload = json_encode( array(	"apikey" => $BulkvsPersonalApiKey,
						"apisecret" => $BulkvsPersonalApiSecret,
						"from" => $Subject_Line_Array['SMS_TO'],
						"to" => $Subject_Line_Array['SMS_FROM'],
						"message" => $sms_text,
                                             ) );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$result = curl_exec($ch);
		curl_close($ch);

		imap_delete($inbox, $email_number);
	}
} 

imap_close($inbox);
echo "<br>sms queue processed, exiting.<br>";
?>
