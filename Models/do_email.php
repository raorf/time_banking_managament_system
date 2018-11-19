<?php

include_once "../Properties/configuration.php";

class do_email{
    function constructActivationLink($UserCaptcha, $UserName){
        $link = "http://".$_SERVER['REMOTE_ADDR']."/time_banking_management_system/Views/activation.php?UserCaptcha=$UserCaptcha&UserName=$UserName";
        return $link;
    }

    function sendActivationEmail($recipient_mail, $activation_link){
        $sender = configuration::PORTAL_NAME;
        $phone = configuration::PORTAL_PHONE;
        $email = configuration::PORTAL_EMAIL;
        $message = configuration::PORTAL_ACTIVATION_MESSAGE;

        $formcontent=" From: $sender \n Phone: $phone \n Message: $message \n Activation link: $activation_link";
        $recipient = "$recipient_mail";
        $subject = "User account activation";
        $mailheader = "From: $email \r\n";
        mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
        echo "Email with verification link has been sent. Thank You!";
    }
}
?>