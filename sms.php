<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require $_SERVER['DOCUMENT_ROOT'].'/phpmailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'].'/phpmailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'].'/phpmailer/src/SMTP.php';
require $_SERVER['DOCUMENT_ROOT'].'/smtp-stuff.php';
require $_SERVER['DOCUMENT_ROOT'].'/block-list.php';
if (empty($_GET)) {
} else {
		//sms values exist
		if (!empty($_GET['message'])){
			//make sure the sender is not on the block list
			if (!in_array($blocked,$_GET['from']))
			{
		//Send the incoming text to email
				$mail_sms = new PHPMailer(true);
				$mail_sms->isHTML(true);
				$mail_sms->CharSet = 'UTF-8';
				$mail_sms->Encoding = 'base64';
					
				if ($smtp_status == 'true') {
				$mail_sms->IsSMTP();
				$mail_sms->Host = $smtp_host;
				$mail_sms->Port = $smtp_port;
				$mail_sms->SMTPSecure = $smtp_protocol;
				$mail_sms->SMTPAuth = true;
				$mail_sms->Username = $smtp_email;
				$mail_sms->Password = $smtp_pass;
				$mail_sms->setFrom($smtp_email, $smtp_name);	
				} else {	
				$mail_sms->setFrom($smtp_email, $smtp_name);		
				}
				$mail_sms->addReplyTo($reply_to, $reply_to_name);
				$mail_sms->AddAddress($email);
				if (!empty($cc)){
			    	$mail_sms->AddCC($cc);
				}
				$mail_sms->Subject = 'INCOMING=SMS&SMS_FROM='.$_GET['from'].'&SMS_TO='.$_GET['to'];
				$mail_sms->Body = $_GET['message'];
				$mail_sms->Send();
				echo 'OK';
		}else{
				echo 'OK'; //send the expected reposnse so that bulkvs doesn't keep sending the same sms
			}
	}
}
//EOF
