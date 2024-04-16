<?php
    $filenameee =  $_FILES['file']['name'];
    $fileName = $_FILES['file']['tmp_name']; 
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $position = $_POST['position'];
    $years = $_POST['years'];
    $cctc = $_POST['cctc'];
    $ectc = $_POST['ectc'];
    $remark = $_POST['remark'];


    $message = "Form details below.\n\n";
    
    
    $message .="Full Name = ". $name . "\r\nEmail ID = " . $email . "\r\nContact Numbar =" . $phone . "\r\nPosition Applied For =" .$position . "\r\nTotal Years of Experience = " .$years ."\r\nCurrent CTC = ".$cctc . "\r\nExpected CTC = " .$ectc. "\r\nRemark = " .$remark ; 
    
    $subject ="Candidate Registration Details (HumanTroop Ventures)";
    //$fromname ="Humantroop Venture";
    $fromemail = 'noreply@humantroop.in';  //if u dont have an email create one on your cpanel
    $mailto = 'support@humantroop.in';  //the email which u want to recv this email
    $content = file_get_contents($fileName);
    $content = chunk_split(base64_encode($content));
    // a random hash will be necessary to send mixed content
    $separator = md5(time());
    // carriage return type (RFC)
    $eol = "\r\n";
    // main header (multipart mandatory)
    $headers = "From: ".$fromname." <".$fromemail.">" . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
    $headers .= "This is a MIME encoded message." . $eol;
    // message
    $body = "--" . $separator . $eol;
    $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
    $body .= "Content-Transfer-Encoding: 8bit" . $eol;
    $body .= $message . $eol;
    // attachment
    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: application/octet-stream; name=\"" . $filenameee . "\"" . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol;
    $body .= "Content-Disposition: attachment" . $eol;
    $body .= $content . $eol;
    $body .= "--" . $separator . "--";
    //SEND Mail
    if (@mail($mailto, $subject, $body, $headers)) 
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
           alert('Message failed. Please, send an email to customercare@prixim.co.uk');
           window.location = 'index.html';
       </script>
   <?php
   }
   ?>




