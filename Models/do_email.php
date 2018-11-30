<?php

include_once "Properties/configuration.php";
include_once "../Properties/configuration.php";

class do_email{
    function constructActivationLink($UserCaptcha, $UserName){
        $link = "http://stuweb.cms.gre.ac.uk/~ma6912b/activation.php?UserCaptcha=$UserCaptcha&UserName=$UserName";
        return $link;
    }

    function sendActivationEmail($recipient_mail, $activation_link, $UserCaptcha){
        $sender = configuration::PORTAL_NAME;
        $phone = configuration::PORTAL_PHONE;
        $email = configuration::PORTAL_EMAIL;
        $message = configuration::PORTAL_ACTIVATION_MESSAGE;

        $formcontent=" From: $sender \n Phone: $phone \n Message: \n$message \n Activation link: $activation_link\n Alternatively, you can activate your account by proceeding to activation page and entering this code: \n <b>$UserCaptcha</b>";
        $recipient = "$recipient_mail";
        $subject = "User account activation";
        $mailheader = "From: $email \r\n";
        
        mail("$recipient", "$subject", "$formcontent", "From: ma6912b@gre.ac.uk\r\n") or die("Error sending email.");
        echo "Email with verification link has been sent. Thank You!";
    }
}
?>