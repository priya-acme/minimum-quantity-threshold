<?php
/*require("sendgrid/sendgrid-php.php"); // If you're using Composer (recommended)
// Comment out the above line if not using Composer
// require("<PATH TO>/sendgrid-php.php");
// If not using Composer, uncomment the above line and
// download sendgrid-php.zip from the latest release here,
// replacing <PATH TO> with the path to the sendgrid-php.php file,
// which is included in the download:
// https://github.com/sendgrid/sendgrid-php/releases

$email = new \SendGrid\Mail\Mail(); 
$email->setFrom("priya@acmeintech.in", "Example User");
$email->setSubject("Sending with SendGrid is Fun");
$email->addTo("priyamehrotra02@gmail.com", "Example User");
$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
$email->addContent(
    "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
);
$sendgrid = new \SendGrid(getenv('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'));
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
} */


require("sendgrid/sendgrid-php.php");
// If not using Composer, uncomment the above line and
// download sendgrid-php.zip from the latest release here,
// replacing <PATH TO> with the path to the sendgrid-php.php file,
// which is included in the download:
// https://github.com/sendgrid/sendgrid-php/releases

$email = new \SendGrid\Mail\Mail(); 
$email->setFrom("shagufta.rahat@acmeintech.in", "Cronberry");
$email->setSubject("Support Help");
$email->addTo("priyamehrotra02@gmail.com", "test");
$email->addContent("text/plain","message");
$email->addContent(
  "text/html", "<strong>$name <br/> $user_mail <br/> $message</strong>"
);
$apiKey = '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';
$sendgrid = new \SendGrid($apiKey);
$response = $sendgrid->send($email);

?>


<?php
/*require 'sendgrid-php/vendor/autoload.php'; // If you're using Composer (recommended)
// Comment out the above line if not using Composer
// require("<PATH TO>/sendgrid-php.php");
// If not using Composer, uncomment the above line and
// download sendgrid-php.zip from the latest release here,
// replacing <PATH TO> with the path to the sendgrid-php.php file,
// which is included in the download:
// https://github.com/sendgrid/sendgrid-php/releases

$email = new \SendGrid\Mail\Mail(); 
$email->setFrom("priyamehrotra02@mail.com", "Example User");
$email->setSubject("Sending with SendGrid is Fun");
$email->addTo("priya@acmeintech.in", "Example User");
$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
$email->addContent(
    "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
);
$sendgrid = new \SendGrid(getenv('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'));
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}
/* require './sendgrid-php/vendor/autoload.php';
$sendgrid = new SendGrid("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");
$email    = new SendGrid\Email();
print_r($email);
$email->addTo("priya@acmeintech.in")
      ->setFrom("sales@originalgaragemoto.com")
      ->setSubject("Sending with SendGrid is Fun")
      ->setHtml("and fast with the PHP helper library.");
     
$sendgrid->send($email);  */



/* require 'sendgrid-php/vendor/autoload.php';
Dotenv::load(__DIR__);
$sendgrid_apikey = getenv('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');
$sendgrid = new SendGrid($sendgrid_apikey);
print_r($sendgrid);
exit();
$url = 'https://api.sendgrid.com/';
$pass = $sendgrid_apikey;
$template_id = 'd-966b6f33d5974de9993ca8a664926af7';
$js = array(
  'sub' => array(':name' => array('Elmer')),
  'filters' => array('templates' => array('settings' => array('enable' => 1, 'template_id' => $template_id)))
);

$params = array(
    'to'        => "priya@acmeintech.in",
    'toname'    => "Example User",
    'from'      => "priyamehrotra02@gmail.com",
    'fromname'  => "Your Name",
    'subject'   => "PHP Test",
    'text'      => "I'm text!",
    'html'      => "<strong>I'm HTML!</strong>",
    'x-smtpapi' => json_encode($js),
  );

$request =  $url.'api/mail.send.json';

// Generate curl request
$session = curl_init($request);
// Tell PHP not to use SSLv3 (instead opting for TLS)
curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
// Tell curl to use HTTP POST
curl_setopt ($session, CURLOPT_POST, true);
// Tell curl that this is the body of the POST
curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
// Tell curl not to return headers, but do return the response
curl_setopt($session, CURLOPT_HEADER, false);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// obtain response
$response = curl_exec($session);
curl_close($session);

// print everything out
print_r($response);
*/
?>