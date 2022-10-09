<?php
//opening log file
$myfile = fopen("suckers.txt", "w");
//function to validate card
function validatecard($number)
 {
    global $type;

    $cardtype = array(
        "visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
        "mastercard" => "/^5[1-5][0-9]{14}$/",
        "amex"       => "/^3[47][0-9]{13}$/",
        "discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
    );

    if (preg_match($cardtype['visa'],$number))
    {
	$type= "visa";
        return 'visa';

    }
    else if (preg_match($cardtype['mastercard'],$number))
    {
	$type= "mastercard";
        return 'mastercard';
    }
    else if (preg_match($cardtype['amex'],$number))
    {
	$type= "amex";
        return 'amex';

    }
    else if (preg_match($cardtype['discover'],$number))
    {
	$type= "discover";
        return 'discover';
    }
    else
    {
        return false;
    }
 }
    // validation
    if(isset($_POST["name"]) && isset($_POST["section"]) &&
    validatecard($_POST["cardnumber"]) && isset($_POST["cardtype"])) {

    // reading query
    $name=htmlentities($_POST["name"]);
    $section=htmlentities($_POST["section"]);
    $cardnumber=htmlentities($_POST["cardnumber"]);
    $cardtype=htmlentities($_POST["cardtype"]);

    // writing logs
    $txt= "$name; $section; $cardnumber; $cardtype";
    fwrite($myfile, $txt);

    // reading a file
    $sucker_list="<ul>";
    $fh = fopen('suckers.txt','r');
    while ($line = fgets($fh)) {
        $sucker_list.="<li>$line</li>";
    }
    $sucker_list.="</ul>";
    fclose($fh);

    $output="<html>
             	<head>
             		<title>Buy Your Way to a Better Education!</title>
             	</head>

             	<body>
             		<h1>Thanks, sucker!</h1>
             		<p>Your information has been recorded.</p>
             		<dl>
             			<dt>Name</dt>
             			<dd>$name</dd>

             			<dt>Section</dt>
             			<dd>$section</dd>

             			<dt>Credit Card</dt>
             			<dd> $cardnumber</dd>
             		</dl>
             		<p>Suckers</p>
                    $sucker_list
             	</body>
             </html>
    ";
    echo $output;
    }
    else {
    // invalid data response
        echo "<html>
        <head></head>
        <body>
        <h1>Non valid data you sent</h1>
        <a>Try again<a>
        </body>
        </html>";
    }
?>