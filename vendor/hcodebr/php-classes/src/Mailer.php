<?php 

namespace Hcode;

use Rain\Tpl;


class Mailer {

	const USERNAME = "resetefabrica@gmail.com";
	const PASSWORD = "Senh@123";
	const NAME_FROM = "Rodrigo";

	private $mail;
	
	public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
	{	

		$config = array(
		    "base_url"      => null,
		    "tpl_dir"       => $_SERVER['DOCUMENT_ROOT']."/views/email/",
		    "cache_dir"     => $_SERVER['DOCUMENT_ROOT']."/views-cache/",
		    "debug"         => false
		);

		Tpl::configure( $config );

		$tpl = new Tpl();

		foreach ($data as $key => $value) {
			$tpl->assign($key, $value);
		}

		$html = $tpl->draw($tplName, true);
		
		$this->mail = new \PHPMailer;

		$this->mail->isSMTP();

		$this->mail->SMTPDebug = 0; // 0 = off (for production use)	1 = client messages 	2 = client and server messages

		$this->mail->Host = 'smtp.gmail.com';
		
		//use
		//$this->mail->Host = gethostbyname('smtp.gmail.com');
		//if your network does not support SMTP over IPv6

		$this->mail->Port = 587; // Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission

		$this->mail->SMTPSecure = 'tls'; //Set the encryption system to use - ssl (deprecated) or tls

		$this->mail->SMTPAuth = true; //Whether to use SMTP authentication

		$this->mail->Username = Mailer::USERNAME; //Username to use for SMTP authentication - use full email address for gmail

		$this->mail->Password = Mailer::PASSWORD; //Password to use for SMTP authentication

		$this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM); //Set who the message is to be sent from

		//Set an alternative reply-to address
		//$this->mail->addReplyTo('replyto@example.com', 'First Last');
		
		$this->mail->addAddress($toAddress, $toName); //Set who the message is to be sent to	

		$this->mail->Subject = $subject; //Set the subject line

		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body	
		$this->mail->msgHTML($html); //$this->mail->msgHTML(file_get_contents('contents.html'), __DIR__);

		$this->mail->AltBody = 'This is a plain-text message body'; //Replace the plain text body with one created manually

		//$this->mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file

		$this->mail->CharSet = "UTF-8";
	}

	public function send()
	{

		return $this->mail->send();

	}

}

 ?>