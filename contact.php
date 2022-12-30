<?php
if(isset($_POST['email'])) {
 
    $email_to = "support@humantroop.in";
    $email_subject = "Contact Us Form (HumanTroop Ventures)";
 
    function died($error) {
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 
 
    if( 
    !isset($_POST['name']) ||
    
       
        !isset($_POST['email']) ||
        !isset($_POST['phone']) ||
        !isset($_POST['subject']) ||
        !isset($_POST['message'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 

     
    
    $name = $_POST['name']; 
   
    $email_from = $_POST['email']; 
    $phone = $_POST['phone'];
    $sub = $_POST['subject']; 
    $msg = $_POST['message']; 
 
    $ip = $_SERVER['REMOTE_ADDR']; 
 

 
    $email_message = "Form details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
    $email_message .= "Senders IP: ".clean_string($ip)."\n\n"; 
    $email_message .= "Name: ".clean_string($name)."\n";
   
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Phone: ".clean_string($phone)."\n";
    $email_message .= "Subject: ".clean_string($sub)."\n";
   
    $email_message .= "Message: ".clean_string($msg)."\n";
   
    
      
    
$headers = 'From: noreply@humantroop.in'."\r\n";
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();

if (@mail($email_to, $email_subject, $email_message, $headers))
	  {
         ?>
    	<script language="javascript" type="text/javascript">
    		alert('Thank you for the message. We will contact you shortly.');
    		window.location = 'index.html';
    	</script>
    <?php
    }
    else { ?>
    	<script language="javascript" type="text/javascript">
    		alert('Message failed. Please, send an email to support@humantroop.in');
    		window.location = 'index.html';
    	</script>
    <?php
    }
   }
?>