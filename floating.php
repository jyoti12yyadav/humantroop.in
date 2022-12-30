<?php
if(isset($_POST['submit'])) {
 
    $email_to = "support@humantroop.in";
    
    $email_subject = "Contact Us Form ";
 
    function died($error) {
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 
 
    if(!isset($_POST['float-name']) ||
        !isset($_POST['float-company']) ||
        !isset($_POST['float-city']) ||
        !isset($_POST['float-contact']) ||
       
        !isset($_POST['msg'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 

    $ip = $_SERVER['REMOTE_ADDR']; 
    $name = $_POST['float-name']; 
    $company = $_POST['float-company']; 
    $city = $_POST['float-city']; 
    $contact = $_POST['float-contact'];
    $comments = $_POST['msg']; 
    
 

 
    $email_message = "Form details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
    $email_message .= "Senders IP: ".clean_string($ip)."\n\n"; 
    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Company Name: ".clean_string($company)."\n";
    $email_message .= "City: ".clean_string($city)."\n";
    $email_message .= "Contact Number: ".clean_string($contact)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";
    
      
    
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
    		alert('Message failed. Please, send an email to sales@humantroop.in');
    		window.location = 'index.html';
    	</script>
    <?php
    }
   }
?>