<?php

		require 'PHPMailer/PHPMailerAutoload.php';
		$mail = new PHPMailer;

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers ;smtp2.example.com
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'support@nevergrind.com';                 // SMTP username
		$mail->Password = '!M6a1e8l2f4y6n';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to 587 tls or 465 ssl
		$mail->SMTPDebug = 1;
		$mail->Debugoutput = 'html';
		$mail->From = 'support@nevergrind.com';
		$mail->FromName = 'Neverworks LLC';
		$mail->addAddress('joemattleonard@gmail.com');
		$mail->isHTML(true);

		$mail->Subject = 'Thank you for your sheckles';
		$mail->Body    = '<p>Neverworks would like to thank you for the one-million dollar purchase of Never Crystals from the website <a href="http://www.nevergrind.com">nevergrind.com</a> Your Federal Reserve Notes are appreciated and will be used to save polar bears from not drowning. This is not a ponzi scheme or a virtual casino. Have a nice day.</p>';
		 $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message has been sent';
		}
		/*
		// send email confirmation
		require 'PHPMailer/PHPMailerAutoload.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'support@nevergrind.com';
		$mail->Password = '!M6a1e8l2f4y6n'; 
		$mail->SMTPSecure = 'tls'; 
		$mail->Port = 587;  
		$mail->From = 'support@nevergrind.com';
		$mail->FromName = 'Neverworks LLC';
		if($_POST['host']=="nevergrind.com"){
			$mail->addAddress($_SESSION['email']);
		}
		$mail->addAddress('joemattleonard@gmail.com');
		$mail->isHTML(true);
		$mail->Subject = 'Purchase Confirmation';
		$amount = $amount/100;
		$mail->Body = '<p>Dear Customer,</p>
			<p>This is an automated email is to confirm your purchase of '.$_POST['crystals'].' Never Crystals for $'.$amount.' from the website <a href="http://www.nevergrind.com">nevergrind.com</a>. If you did not purchase Never Crystals, please respond to this email and we will address this problem immediately. Otherwise, thank you for your business and we hope you enjoy your purchase!</p>
			<p>
				Neverworks LLC
			</p>';
		$mail->send();
		
		*/
		
		
		$salt = rand_str(rand(100,200));
?>