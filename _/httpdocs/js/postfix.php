<?php

 

class SMTP

{

    var $SMTP_PORT = 25;



    var $CRLF = "\r\n";



    var $do_debug;



    var $smtp_conn;

    var $error;

    var $helo_rply;



    function SMTP() {

        $this->smtp_conn = 0;

        $this->error = null;

        $this->helo_rply = null;



        $this->do_debug = 0;

    }



    function Connect($host,$port=0,$tval=120) {



        $this->error = null;





        if($this->connected()) {





            $this->error =

                array("error" => "Already connected to a server");

            return false;

        }



        if(empty($port)) {

            $port = $this->SMTP_PORT;

        }



        $this->smtp_conn = fsockopen($host,    # the host of the server

                                     $port,    # the port to use

                                     $errno,   # error number if any

                                     $errstr,  # error message if any

                                     $tval);   # give up after ? secs



        if(empty($this->smtp_conn)) {

            $this->error = array("error" => "Failed to connect to server",

                                 "errno" => $errno,

                                 "errstr" => $errstr);

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": $errstr ($errno)" . $this->CRLF;

            }

            return false;

        }



        if(substr(PHP_OS, 0, 3) != "WIN")

           socket_set_timeout($this->smtp_conn, $tval, 0);



        $announce = $this->get_lines();



        if($this->do_debug >= 2) {

            echo "SMTP -> FROM SERVER:" . $this->CRLF . $announce;

        }



        return true;

    }



    function Authenticate($username, $password) {

	

        // Start authentication

		

        fputs($this->smtp_conn,"AUTH LOGIN" . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($code != 334) {

            $this->error =

                array("error" => "AUTH not accepted from server",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }



        // Send encoded username

		

        fputs($this->smtp_conn, base64_encode($username) . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($code != 334) {

            $this->error =

                array("error" => "Username not accepted from server",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }



        // Send encoded password

        fputs($this->smtp_conn, base64_encode($password) . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($code != 235) {

            $this->error =

                array("error" => "Password not accepted from server",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }



        return true;

    }







    function Connected() {

        if(!empty($this->smtp_conn)) {

            $sock_status = socket_get_status($this->smtp_conn);

            if($sock_status["eof"]) {

                # hmm this is an odd situation... the socket is

                # valid but we aren't connected anymore

                if($this->do_debug >= 1) {

                    echo "SMTP -> NOTICE:" . $this->CRLF .

                         "EOF caught while checking if connected";

                }

                $this->Close();

                return false;

            }

            return true; # everything looks good

        }

        return false;

    }



    function Close() {

        $this->error = null; # so there is no confusion

        $this->helo_rply = null;

        if(!empty($this->smtp_conn)) {

            # close the connection and cleanup

            fclose($this->smtp_conn);

            $this->smtp_conn = 0;

        }

    }





    function Data($msg_data) {

        $this->error = null; # so no confusion is caused



        if(!$this->connected()) {

            $this->error = array(

                    "error" => "Called Data() without being connected");

            return false;

        }



        fputs($this->smtp_conn,"DATA" . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($this->do_debug >= 2) {

            echo "SMTP -> FROM SERVER:" . $this->CRLF . $rply;

        }



        if($code != 354) {

            $this->error =

                array("error" => "DATA command not accepted from server",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }



        $msg_data = str_replace("\r\n","\n",$msg_data);

        $msg_data = str_replace("\r","\n",$msg_data);

        $lines = explode("\n",$msg_data);



        $field = substr($lines[0],0,strpos($lines[0],":"));

        $in_headers = false;

        if(!empty($field) && !strstr($field," ")) {

            $in_headers = true;

        }



        $max_line_length = 998; # used below; set here for ease in change



        while(list(,$line) = @each($lines)) {

            $lines_out = null;

            if($line == "" && $in_headers) {

                $in_headers = false;

            }

            # ok we need to break this line up into several

            # smaller lines

            while(strlen($line) > $max_line_length) {

                $pos = strrpos(substr($line,0,$max_line_length)," ");



                # Patch to fix DOS attack

                if(!$pos) {

                    $pos = $max_line_length - 1;

                }



                $lines_out[] = substr($line,0,$pos);

                $line = substr($line,$pos + 1);



                if($in_headers) {

                    $line = "\t" . $line;

                }

            }

            $lines_out[] = $line;



            # now send the lines to the server

            while(list(,$line_out) = @each($lines_out)) {

                if(strlen($line_out) > 0)

                {

                    if(substr($line_out, 0, 1) == ".") {

                        $line_out = "." . $line_out;

                    }

                }

                fputs($this->smtp_conn,$line_out . $this->CRLF);

            }

        }



        # ok all the message data has been sent so lets get this

        # over with aleady

        fputs($this->smtp_conn, $this->CRLF . "." . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($this->do_debug >= 2) {

            echo "SMTP -> FROM SERVER:" . $this->CRLF . $rply;

        }



        if($code != 250) {

            $this->error =

                array("error" => "DATA not accepted from server",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }

        return true;

    }





    function Expand($name) {

        $this->error = null; # so no confusion is caused



        if(!$this->connected()) {

            $this->error = array(

                    "error" => "Called Expand() without being connected");

            return false;

        }



        fputs($this->smtp_conn,"EXPN " . $name . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($this->do_debug >= 2) {

            echo "SMTP -> FROM SERVER:" . $this->CRLF . $rply;

        }



        if($code != 250) {

            $this->error =

                array("error" => "EXPN not accepted from server",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }



        # parse the reply and place in our array to return to user

        $entries = explode($this->CRLF,$rply);

        while(list(,$l) = @each($entries)) {

            $list[] = substr($l,4);

        }



        return $list;

    }



    function Hello($host="") {

        $this->error = null; # so no confusion is caused



        if(!$this->connected()) {

            $this->error = array(

                    "error" => "Called Hello() without being connected");

            return false;

        }



        # if a hostname for the HELO wasn't specified determine

        # a suitable one to send

        if(empty($host)) {

            # we need to determine some sort of appopiate default

            # to send to the server

            $host = "localhost";

        }



        // Send extended hello first (RFC 2821)

        if(!$this->SendHello("EHLO", $host))

        {

            if(!$this->SendHello("HELO", $host))

                return false;

        }



        return true;

    }



    function SendHello($hello, $host) {

        fputs($this->smtp_conn, $hello . " " . $host . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($this->do_debug >= 2) {

            echo "SMTP -> FROM SERVER: " . $this->CRLF . $rply;

        }



        if($code != 250) {

            $this->error =

                array("error" => $hello . " not accepted from server",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }



        $this->helo_rply = $rply;

        

        return true;

    }



    function Help($keyword="") {

        $this->error = null; # to avoid confusion



        if(!$this->connected()) {

            $this->error = array(

                    "error" => "Called Help() without being connected");

            return false;

        }



        $extra = "";

        if(!empty($keyword)) {

            $extra = " " . $keyword;

        }



        fputs($this->smtp_conn,"HELP" . $extra . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($this->do_debug >= 2) {

            echo "SMTP -> FROM SERVER:" . $this->CRLF . $rply;

        }



        if($code != 211 && $code != 214) {

            $this->error =

                array("error" => "HELP not accepted from server",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }



        return $rply;

    }





    function Mail($from) {

        $this->error = null; # so no confusion is caused



        if(!$this->connected()) {

            $this->error = array(

                    "error" => "Called Mail() without being connected");

            return false;

        }



        fputs($this->smtp_conn,"MAIL FROM:<" . $from . ">" . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($this->do_debug >= 2) {

            echo "SMTP -> FROM SERVER:" . $this->CRLF . $rply;

        }



        if($code != 250) {

            $this->error =

                array("error" => "MAIL not accepted from server",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }

        return true;

    }





    function Noop() {

        $this->error = null; # so no confusion is caused



        if(!$this->connected()) {

            $this->error = array(

                    "error" => "Called Noop() without being connected");

            return false;

        }



        fputs($this->smtp_conn,"NOOP" . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($this->do_debug >= 2) {

            echo "SMTP -> FROM SERVER:" . $this->CRLF . $rply;

        }



        if($code != 250) {

            $this->error =

                array("error" => "NOOP not accepted from server",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }

        return true;

    }





    function Quit($close_on_error=true) {

        $this->error = null; # so there is no confusion



        if(!$this->connected()) {

            $this->error = array(

                    "error" => "Called Quit() without being connected");

            return false;

        }



        # send the quit command to the server

        fputs($this->smtp_conn,"quit" . $this->CRLF);



        # get any good-bye messages

        $byemsg = $this->get_lines();



        if($this->do_debug >= 2) {

            echo "SMTP -> FROM SERVER:" . $this->CRLF . $byemsg;

        }



        $rval = true;

        $e = null;



        $code = substr($byemsg,0,3);

        if($code != 221) {

            # use e as a tmp var cause Close will overwrite $this->error

            $e = array("error" => "SMTP server rejected quit command",

                       "smtp_code" => $code,

                       "smtp_rply" => substr($byemsg,4));

            $rval = false;

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $e["error"] . ": " .

                         $byemsg . $this->CRLF;

            }

        }



        if(empty($e) || $close_on_error) {

            $this->Close();

        }



        return $rval;

    }



    function Recipient($to) {

        $this->error = null; # so no confusion is caused



        if(!$this->connected()) {

            $this->error = array(

                    "error" => "Called Recipient() without being connected");

            return false;

        }



        fputs($this->smtp_conn,"RCPT TO:<" . $to . ">" . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($this->do_debug >= 2) {

            echo "SMTP -> FROM SERVER:" . $this->CRLF . $rply;

        }



        if($code != 250 && $code != 251) {

            $this->error =

                array("error" => "RCPT not accepted from server",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }

        return true;

    }



    function Reset() {

        $this->error = null; # so no confusion is caused



        if(!$this->connected()) {

            $this->error = array(

                    "error" => "Called Reset() without being connected");

            return false;

        }



        fputs($this->smtp_conn,"RSET" . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($this->do_debug >= 2) {

            echo "SMTP -> FROM SERVER:" . $this->CRLF . $rply;

        }



        if($code != 250) {

            $this->error =

                array("error" => "RSET failed",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }



        return true;

    }



    function Send($from) {

        $this->error = null; # so no confusion is caused



        if(!$this->connected()) {

            $this->error = array(

                    "error" => "Called Send() without being connected");

            return false;

        }



        fputs($this->smtp_conn,"SEND FROM:" . $from . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($this->do_debug >= 2) {

            echo "SMTP -> FROM SERVER:" . $this->CRLF . $rply;

        }



        if($code != 250) {

            $this->error =

                array("error" => "SEND not accepted from server",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }

        return true;

    }





    function SendAndMail($from) {

        $this->error = null; # so no confusion is caused



        if(!$this->connected()) {

            $this->error = array(

                "error" => "Called SendAndMail() without being connected");

            return false;

        }



        fputs($this->smtp_conn,"SAML FROM:" . $from . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($this->do_debug >= 2) {

            echo "SMTP -> FROM SERVER:" . $this->CRLF . $rply;

        }



        if($code != 250) {

            $this->error =

                array("error" => "SAML not accepted from server",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }

        return true;

    }



    function SendOrMail($from) {

        $this->error = null; # so no confusion is caused



        if(!$this->connected()) {

            $this->error = array(

                "error" => "Called SendOrMail() without being connected");

            return false;

        }



        fputs($this->smtp_conn,"SOML FROM:" . $from . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($this->do_debug >= 2) {

            echo "SMTP -> FROM SERVER:" . $this->CRLF . $rply;

        }



        if($code != 250) {

            $this->error =

                array("error" => "SOML not accepted from server",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }

        return true;

    }





    function Turn() {

        $this->error = array("error" => "This method, TURN, of the SMTP ".

                                        "is not implemented");

        if($this->do_debug >= 1) {

            echo "SMTP -> NOTICE: " . $this->error["error"] . $this->CRLF;

        }

        return false;

    }





    function Verify($name) {

        $this->error = null; # so no confusion is caused



        if(!$this->connected()) {

            $this->error = array(

                    "error" => "Called Verify() without being connected");

            return false;

        }



        fputs($this->smtp_conn,"VRFY " . $name . $this->CRLF);



        $rply = $this->get_lines();

        $code = substr($rply,0,3);



        if($this->do_debug >= 2) {

            echo "SMTP -> FROM SERVER:" . $this->CRLF . $rply;

        }



        if($code != 250 && $code != 251) {

            $this->error =

                array("error" => "VRFY failed on name '$name'",

                      "smtp_code" => $code,

                      "smtp_msg" => substr($rply,4));

            if($this->do_debug >= 1) {

                echo "SMTP -> ERROR: " . $this->error["error"] .

                         ": " . $rply . $this->CRLF;

            }

            return false;

        }

        return $rply;

    }





    function get_lines() {

        $data = "";

        while($str = fgets($this->smtp_conn,515)) {

            if($this->do_debug >= 4) {

                echo "SMTP -> get_lines(): \$data was \"$data\"" .

                         $this->CRLF;

                echo "SMTP -> get_lines(): \$str is \"$str\"" .

                         $this->CRLF;

            }

            $data .= $str;

            if($this->do_debug >= 4) {

                echo "SMTP -> get_lines(): \$data is \"$data\"" . $this->CRLF;

            }

            # if the 4th character is a space then we are done reading

            # so just break the loop

            if(substr($str,3,1) == " ") { break; }

        }

        return $data;

    }



}





 ?>

 

 <?php



class PHPMailer

{



    var $Priority          = 3;





    var $CharSet           = "iso-8859-1";





    var $ContentType        = "text/plain";



    var $Encoding          = "8bit";



    var $ErrorInfo         = "";



    var $From               = "root@localhost";



    var $FromName           = "Root User";



    var $Sender            = "";



    var $Subject           = "";



    var $Body               = "";



    var $AltBody           = "";



    var $WordWrap          = 0;



    var $Mailer            = "mail";



    var $Sendmail          = "/usr/sbin/sendmail";



    var $PluginDir         = "";



    var $Version           = "1.73";



    var $ConfirmReadingTo  = "";



    var $Hostname          = "";



    var $Host        = "localhost";



    var $Port        = 25;



    var $Helo        = "";



    var $SMTPAuth     = false;



    var $Username     = "";



    var $Password     = "";



    var $Timeout      = 10;



    var $SMTPDebug    = false;



    var $SMTPKeepAlive = false;



    var $smtp            = NULL;

    var $to              = array();

    var $cc              = array();

    var $bcc             = array();

    var $ReplyTo         = array();

    var $attachment      = array();

    var $CustomHeader    = array();

    var $message_type    = "";

    var $boundary        = array();

    var $language        = array();

    var $error_count     = 0;

    var $LE              = "\n";



    function IsHTML($bool) {

        if($bool == true)

            $this->ContentType = "text/html";

        else

            $this->ContentType = "text/plain";

    }



    /**

     * Sets Mailer to send message using SMTP.

     * @return void

     */

    function IsSMTP() {

        $this->Mailer = "smtp";

    }



    /**

     * Sets Mailer to send message using PHP mail() function.

     * @return void

     */

    function IsMail() {

        $this->Mailer = "mail";

    }



    /**

     * Sets Mailer to send message using the $Sendmail program.

     * @return void

     */

    function IsSendmail() {

        $this->Mailer = "sendmail";

    }



    /**

     * Sets Mailer to send message using the qmail MTA. 

     * @return void

     */

    function IsQmail() {

        $this->Sendmail = "/var/qmail/bin/sendmail";

        $this->Mailer = "sendmail";

    }





    function AddAddress($address, $name = "") {

        $cur = count($this->to);

        $this->to[$cur][0] = trim($address);

        $this->to[$cur][1] = $name;

    }





    function AddCC($address, $name = "") {

        $cur = count($this->cc);

        $this->cc[$cur][0] = trim($address);

        $this->cc[$cur][1] = $name;

    }





    function AddBCC($address, $name = "") {

        $cur = count($this->bcc);

        $this->bcc[$cur][0] = trim($address);

        $this->bcc[$cur][1] = $name;

    }





    function AddReplyTo($address, $name = "") {

        $cur = count($this->ReplyTo);

        $this->ReplyTo[$cur][0] = trim($address);

        $this->ReplyTo[$cur][1] = $name;

    }





    function Send() {

        $header = "";

        $body = "";

        $result = true;



        if((count($this->to) + count($this->cc) + count($this->bcc)) < 1)

        {

            $this->SetError($this->Lang("provide_address"));

            return false;

        }



        // Set whether the message is multipart/alternative

        if(!empty($this->AltBody))

            $this->ContentType = "multipart/alternative";



        $this->error_count = 0; // reset errors

        $this->SetMessageType();

        $header .= $this->CreateHeader();

        $body = $this->CreateBody();



        if($body == "") { return false; }



        // Choose the mailer

        switch($this->Mailer)

        {

            case "sendmail":

                $result = $this->SendmailSend($header, $body);

                break;

            case "mail":

                $result = $this->MailSend($header, $body);

                break;

            case "smtp":

                $result = $this->SmtpSend($header, $body);

                break;

            default:

            $this->SetError($this->Mailer . $this->Lang("mailer_not_supported"));

                $result = false;

                break;

        }



        return $result;

    }

    



    function SendmailSend($header, $body) {

        if ($this->Sender != "")

            $sendmail = sprintf("%s -oi -f %s -t", $this->Sendmail, $this->Sender);

        else

            $sendmail = sprintf("%s -oi -t", $this->Sendmail);



        if(!@$mail = popen($sendmail, "w"))

        {

            $this->SetError($this->Lang("execute") . $this->Sendmail);

            return false;

        }



        fputs($mail, $header);

        fputs($mail, $body);

        

        $result = pclose($mail) >> 8 & 0xFF;

        if($result != 0)

        {

            $this->SetError($this->Lang("execute") . $this->Sendmail);

            return false;

        }



        return true;

    }





    function MailSend($header, $body) {

        $to = "";

        for($i = 0; $i < count($this->to); $i++)

        {

            if($i != 0) { $to .= ", "; }

            $to .= $this->to[$i][0];

        }



        if ($this->Sender != "" && strlen(ini_get("safe_mode"))< 1)

        {

            $old_from = ini_get("sendmail_from");

            ini_set("sendmail_from", $this->Sender);

            $params = sprintf("-oi -f %s", $this->Sender);

            $rt = @mail($to, $this->EncodeHeader($this->Subject), $body, 

                        $header, $params);

        }

        else

            $rt = @mail($to, $this->EncodeHeader($this->Subject), $body, $header);



        if (isset($old_from))

            ini_set("sendmail_from", $old_from);



        if(!$rt)

        {

            $this->SetError($this->Lang("instantiate"));

            return false;

        }



        return true;

    }





    function SmtpSend($header, $body) {

       // include_once($this->PluginDir . "class.smtp.php");

        $error = "";

        $bad_rcpt = array();



        if(!$this->SmtpConnect())

            return false;



        $smtp_from = ($this->Sender == "") ? $this->From : $this->Sender;

        if(!$this->smtp->Mail($smtp_from))

        {

            $error = $this->Lang("from_failed") . $smtp_from;

            $this->SetError($error);

            $this->smtp->Reset();

            return false;

        }



        // Attempt to send attach all recipients

        for($i = 0; $i < count($this->to); $i++)

        {

            if(!$this->smtp->Recipient($this->to[$i][0]))

                $bad_rcpt[] = $this->to[$i][0];

        }

        for($i = 0; $i < count($this->cc); $i++)

        {

            if(!$this->smtp->Recipient($this->cc[$i][0]))

                $bad_rcpt[] = $this->cc[$i][0];

        }

        for($i = 0; $i < count($this->bcc); $i++)

        {

            if(!$this->smtp->Recipient($this->bcc[$i][0]))

                $bad_rcpt[] = $this->bcc[$i][0];

        }



        if(count($bad_rcpt) > 0) // Create error message

        {

            for($i = 0; $i < count($bad_rcpt); $i++)

            {

                if($i != 0) { $error .= ", "; }

                $error .= $bad_rcpt[$i];

            }

            $error = $this->Lang("recipients_failed") . $error;

            $this->SetError($error);

            $this->smtp->Reset();

            return false;

        }



        if(!$this->smtp->Data($header . $body))

        {

            $this->SetError($this->Lang("data_not_accepted"));

            $this->smtp->Reset();

            return false;

        }

        if($this->SMTPKeepAlive == true)

            $this->smtp->Reset();

        else

            $this->SmtpClose();



        return true;

    }



    function SmtpConnect() {

        if($this->smtp == NULL) { $this->smtp = new SMTP(); }



        $this->smtp->do_debug = $this->SMTPDebug;

        $hosts = explode(";", $this->Host);

        $index = 0;

        $connection = ($this->smtp->Connected()); 



        // Retry while there is no connection

        while($index < count($hosts) && $connection == false)

        {

            if(strstr($hosts[$index], ":"))

                list($host, $port) = explode(":", $hosts[$index]);

            else

            {

                $host = $hosts[$index];

                $port = $this->Port;

            }



            if($this->smtp->Connect($host, $port, $this->Timeout))

            {

                if ($this->Helo != '')

                    $this->smtp->Hello($this->Helo);

                else

                    $this->smtp->Hello($this->ServerHostname());

        

                if($this->SMTPAuth)

                {

                    if(!$this->smtp->Authenticate($this->Username, 

                                                  $this->Password))

                    {

                        $this->SetError($this->Lang("authenticate"));

                        $this->smtp->Reset();

                        $connection = false;

                    }

                }

                $connection = true;

            }

            $index++;

        }

        if(!$connection)

            $this->SetError($this->Lang("connect_host"));



        return $connection;

    }





    function SmtpClose() {

        if($this->smtp != NULL)

        {

            if($this->smtp->Connected())

            {

                $this->smtp->Quit();

                $this->smtp->Close();

            }

        }

    }





    function SetLanguage($lang_type, $lang_path = "language/") {

        if(file_exists($lang_path.'phpmailer.lang-'.$lang_type.'.php'))

            include($lang_path.'phpmailer.lang-'.$lang_type.'.php');

        else if(file_exists($lang_path.'phpmailer.lang-en.php'))

            include($lang_path.'phpmailer.lang-en.php');

        else

        {

            $this->SetError("Could not load language file");

            return false;

        }

        $this->language = $PHPMAILER_LANG;

    

        return true;

    }





    function AddrAppend($type, $addr) {

        $addr_str = $type . ": ";

        $addr_str .= $this->AddrFormat($addr[0]);

        if(count($addr) > 1)

        {

            for($i = 1; $i < count($addr); $i++)

                $addr_str .= ", " . $this->AddrFormat($addr[$i]);

        }

        $addr_str .= $this->LE;



        return $addr_str;

    }

    



    function AddrFormat($addr) {

        if(empty($addr[1]))

            $formatted = $addr[0];

        else

        {

            $formatted = $this->EncodeHeader($addr[1], 'phrase') . " <" . 

                         $addr[0] . ">";

        }



        return $formatted;

    }





    function WrapText($message, $length, $qp_mode = false) {

        $soft_break = ($qp_mode) ? sprintf(" =%s", $this->LE) : $this->LE;



        $message = $this->FixEOL($message);

        if (substr($message, -1) == $this->LE)

            $message = substr($message, 0, -1);



        $line = explode($this->LE, $message);

        $message = "";

        for ($i=0 ;$i < count($line); $i++)

        {

          $line_part = explode(" ", $line[$i]);

          $buf = "";

          for ($e = 0; $e<count($line_part); $e++)

          {

              $word = $line_part[$e];

              if ($qp_mode and (strlen($word) > $length))

              {

                $space_left = $length - strlen($buf) - 1;

                if ($e != 0)

                {

                    if ($space_left > 20)

                    {

                        $len = $space_left;

                        if (substr($word, $len - 1, 1) == "=")

                          $len--;

                        elseif (substr($word, $len - 2, 1) == "=")

                          $len -= 2;

                        $part = substr($word, 0, $len);

                        $word = substr($word, $len);

                        $buf .= " " . $part;

                        $message .= $buf . sprintf("=%s", $this->LE);

                    }

                    else

                    {

                        $message .= $buf . $soft_break;

                    }

                    $buf = "";

                }

                while (strlen($word) > 0)

                {

                    $len = $length;

                    if (substr($word, $len - 1, 1) == "=")

                        $len--;

                    elseif (substr($word, $len - 2, 1) == "=")

                        $len -= 2;

                    $part = substr($word, 0, $len);

                    $word = substr($word, $len);



                    if (strlen($word) > 0)

                        $message .= $part . sprintf("=%s", $this->LE);

                    else

                        $buf = $part;

                }

              }

              else

              {

                $buf_o = $buf;

                $buf .= ($e == 0) ? $word : (" " . $word); 



                if (strlen($buf) > $length and $buf_o != "")

                {

                    $message .= $buf_o . $soft_break;

                    $buf = $word;

                }

              }

          }

          $message .= $buf . $this->LE;

        }



        return $message;

    }

    



    function SetWordWrap() {

        if($this->WordWrap < 1)

            return;

            

        switch($this->message_type)

        {

           case "alt":

              // fall through

           case "alt_attachments":

              $this->AltBody = $this->WrapText($this->AltBody, $this->WordWrap);

              break;

           default:

              $this->Body = $this->WrapText($this->Body, $this->WordWrap);

              break;

        }

    }





    function CreateHeader() {

        $result = "";

        

        // Set the boundaries

        $uniq_id = md5(uniqid(time()));

        $this->boundary[1] = "b1_" . $uniq_id;

        $this->boundary[2] = "b2_" . $uniq_id;



        $result .= $this->HeaderLine("Date", $this->RFCDate());

        if($this->Sender == "")

            $result .= $this->HeaderLine("Return-Path", trim($this->From));

        else

            $result .= $this->HeaderLine("Return-Path", trim($this->Sender));

        

        // To be created automatically by mail()

        if($this->Mailer != "mail")

        {

            if(count($this->to) > 0)

                $result .= $this->AddrAppend("To", $this->to);

            else if (count($this->cc) == 0)

                $result .= $this->HeaderLine("To", "undisclosed-recipients:;");

            if(count($this->cc) > 0)

                $result .= $this->AddrAppend("Cc", $this->cc);

        }



        $from = array();

        $from[0][0] = trim($this->From);

        $from[0][1] = $this->FromName;

        $result .= $this->AddrAppend("From", $from); 



        // sendmail and mail() extract Bcc from the header before sending

        if((($this->Mailer == "sendmail") || ($this->Mailer == "mail")) && (count($this->bcc) > 0))

            $result .= $this->AddrAppend("Bcc", $this->bcc);



        if(count($this->ReplyTo) > 0)

            $result .= $this->AddrAppend("Reply-to", $this->ReplyTo);



        // mail() sets the subject itself

        if($this->Mailer != "mail")

            $result .= $this->HeaderLine("Subject", $this->EncodeHeader(trim($this->Subject)));



        $result .= sprintf("Message-ID: <%s@%s>%s", $uniq_id, $this->ServerHostname(), $this->LE);

        $result .= $this->HeaderLine("X-Priority", $this->Priority);

        $result .= $this->HeaderLine("X-Mailer", "PHPMailer [version " . $this->Version . "]");

        

        if($this->ConfirmReadingTo != "")

        {

            $result .= $this->HeaderLine("Disposition-Notification-To", 

                       "<" . trim($this->ConfirmReadingTo) . ">");

        }



        // Add custom headers

        for($index = 0; $index < count($this->CustomHeader); $index++)

        {

            $result .= $this->HeaderLine(trim($this->CustomHeader[$index][0]), 

                       $this->EncodeHeader(trim($this->CustomHeader[$index][1])));

        }

        $result .= $this->HeaderLine("MIME-Version", "1.0");



        switch($this->message_type)

        {

            case "plain":

                $result .= $this->HeaderLine("Content-Transfer-Encoding", $this->Encoding);

                $result .= sprintf("Content-Type: %s; charset=\"%s\"",

                                    $this->ContentType, $this->CharSet);

                break;

            case "attachments":

                // fall through

            case "alt_attachments":

                if($this->InlineImageExists())

                {

                    $result .= sprintf("Content-Type: %s;%s\ttype=\"text/html\";%s\tboundary=\"%s\"%s", 

                                    "multipart/related", $this->LE, $this->LE, 

                                    $this->boundary[1], $this->LE);

                }

                else

                {

                    $result .= $this->HeaderLine("Content-Type", "multipart/mixed;");

                    $result .= $this->TextLine("\tboundary=\"" . $this->boundary[1] . '"');

                }

                break;

            case "alt":

                $result .= $this->HeaderLine("Content-Type", "multipart/alternative;");

                $result .= $this->TextLine("\tboundary=\"" . $this->boundary[1] . '"');

                break;

        }



        if($this->Mailer != "mail")

            $result .= $this->LE.$this->LE;



        return $result;

    }





    function CreateBody() {

        $result = "";



        $this->SetWordWrap();



        switch($this->message_type)

        {

            case "alt":

                $result .= $this->GetBoundary($this->boundary[1], "", 

                                              "text/plain", "");

                $result .= $this->EncodeString($this->AltBody, $this->Encoding);

                $result .= $this->LE.$this->LE;

                $result .= $this->GetBoundary($this->boundary[1], "", 

                                              "text/html", "");

                

                $result .= $this->EncodeString($this->Body, $this->Encoding);

                $result .= $this->LE.$this->LE;

    

                $result .= $this->EndBoundary($this->boundary[1]);

                break;

            case "plain":

                $result .= $this->EncodeString($this->Body, $this->Encoding);

                break;

            case "attachments":

                $result .= $this->GetBoundary($this->boundary[1], "", "", "");

                $result .= $this->EncodeString($this->Body, $this->Encoding);

                $result .= $this->LE;

     

                $result .= $this->AttachAll();

                break;

            case "alt_attachments":

                $result .= sprintf("--%s%s", $this->boundary[1], $this->LE);

                $result .= sprintf("Content-Type: %s;%s" .

                                   "\tboundary=\"%s\"%s",

                                   "multipart/alternative", $this->LE, 

                                   $this->boundary[2], $this->LE.$this->LE);

    

                // Create text body

                $result .= $this->GetBoundary($this->boundary[2], "", 

                                              "text/plain", "") . $this->LE;



                $result .= $this->EncodeString($this->AltBody, $this->Encoding);

                $result .= $this->LE.$this->LE;

    

                // Create the HTML body

                $result .= $this->GetBoundary($this->boundary[2], "", 

                                              "text/html", "") . $this->LE;

    

                $result .= $this->EncodeString($this->Body, $this->Encoding);

                $result .= $this->LE.$this->LE;



                $result .= $this->EndBoundary($this->boundary[2]);

                

                $result .= $this->AttachAll();

                break;

        }

        if($this->IsError())

            $result = "";



        return $result;

    }



    /**

     * Returns the start of a message boundary.

     * @access private

     */

    function GetBoundary($boundary, $charSet, $contentType, $encoding) {

        $result = "";

        if($charSet == "") { $charSet = $this->CharSet; }

        if($contentType == "") { $contentType = $this->ContentType; }

        if($encoding == "") { $encoding = $this->Encoding; }



        $result .= $this->TextLine("--" . $boundary);

        $result .= sprintf("Content-Type: %s; charset = \"%s\"", 

                            $contentType, $charSet);

        $result .= $this->LE;

        $result .= $this->HeaderLine("Content-Transfer-Encoding", $encoding);

        $result .= $this->LE;

       

        return $result;

    }

    

    function EndBoundary($boundary) {

        return $this->LE . "--" . $boundary . "--" . $this->LE; 

    }

    



    function SetMessageType() {

        if(count($this->attachment) < 1 && strlen($this->AltBody) < 1)

            $this->message_type = "plain";

        else

        {

            if(count($this->attachment) > 0)

                $this->message_type = "attachments";

            if(strlen($this->AltBody) > 0 && count($this->attachment) < 1)

                $this->message_type = "alt";

            if(strlen($this->AltBody) > 0 && count($this->attachment) > 0)

                $this->message_type = "alt_attachments";

        }

    }





    function HeaderLine($name, $value) {

        return $name . ": " . $value . $this->LE;

    }





    function TextLine($value) {

        return $value . $this->LE;

    }





    function AddAttachment($path, $name = "", $encoding = "base64", 

                           $type = "application/octet-stream") {

        if(!@is_file($path))

        {

            $this->SetError($this->Lang("file_access") . $path);

            return false;

        }



        $filename = basename($path);

        if($name == "")

            $name = $filename;



        $cur = count($this->attachment);

        $this->attachment[$cur][0] = $path;

        $this->attachment[$cur][1] = $filename;

        $this->attachment[$cur][2] = $name;

        $this->attachment[$cur][3] = $encoding;

        $this->attachment[$cur][4] = $type;

        $this->attachment[$cur][5] = false; // isStringAttachment

        $this->attachment[$cur][6] = "attachment";

        $this->attachment[$cur][7] = 0;



        return true;

    }





    function AttachAll() {

        // Return text of body

        $mime = array();



        // Add all attachments

        for($i = 0; $i < count($this->attachment); $i++)

        {

            // Check for string attachment

            $bString = $this->attachment[$i][5];

            if ($bString)

                $string = $this->attachment[$i][0];

            else

                $path = $this->attachment[$i][0];



            $filename    = $this->attachment[$i][1];

            $name        = $this->attachment[$i][2];

            $encoding    = $this->attachment[$i][3];

            $type        = $this->attachment[$i][4];

            $disposition = $this->attachment[$i][6];

            $cid         = $this->attachment[$i][7];

            

            $mime[] = sprintf("--%s%s", $this->boundary[1], $this->LE);

            $mime[] = sprintf("Content-Type: %s; name=\"%s\"%s", $type, $name, $this->LE);

            $mime[] = sprintf("Content-Transfer-Encoding: %s%s", $encoding, $this->LE);



            if($disposition == "inline")

                $mime[] = sprintf("Content-ID: <%s>%s", $cid, $this->LE);



            $mime[] = sprintf("Content-Disposition: %s; filename=\"%s\"%s", 

                              $disposition, $name, $this->LE.$this->LE);



            // Encode as string attachment

            if($bString)

            {

                $mime[] = $this->EncodeString($string, $encoding);

                if($this->IsError()) { return ""; }

                $mime[] = $this->LE.$this->LE;

            }

            else

            {

                $mime[] = $this->EncodeFile($path, $encoding);                

                if($this->IsError()) { return ""; }

                $mime[] = $this->LE.$this->LE;

            }

        }



        $mime[] = sprintf("--%s--%s", $this->boundary[1], $this->LE);



        return join("", $mime);

    }

    

    function EncodeFile ($path, $encoding = "base64") {

        if(!@$fd = fopen($path, "rb"))

        {

            $this->SetError($this->Lang("file_open") . $path);

            return "";

        }

        $magic_quotes = get_magic_quotes_runtime();

        set_magic_quotes_runtime(0);

        $file_buffer = fread($fd, filesize($path));

        $file_buffer = $this->EncodeString($file_buffer, $encoding);

        fclose($fd);

        set_magic_quotes_runtime($magic_quotes);



        return $file_buffer;

    }





    function EncodeString ($str, $encoding = "base64") {

        $encoded = "";

        switch(strtolower($encoding)) {

          case "base64":

              // chunk_split is found in PHP >= 3.0.6

              $encoded = chunk_split(base64_encode($str), 76, $this->LE);

              break;

          case "7bit":

          case "8bit":

              $encoded = $this->FixEOL($str);

              if (substr($encoded, -(strlen($this->LE))) != $this->LE)

                $encoded .= $this->LE;

              break;

          case "binary":

              $encoded = $str;

              break;

          case "quoted-printable":

              $encoded = $this->EncodeQP($str);

              break;

          default:

              $this->SetError($this->Lang("encoding") . $encoding);

              break;

        }

        return $encoded;

    }





    function EncodeHeader ($str, $position = 'text') {

      $x = 0;

      

      switch (strtolower($position)) {

        case 'phrase':

          if (!preg_match('/[\200-\377]/', $str)) {

            // Can't use addslashes as we don't know what value has magic_quotes_sybase.

            $encoded = addcslashes($str, "\0..\37\177\\\"");



            if (($str == $encoded) && !preg_match('/[^A-Za-z0-9!#$%&\'*+\/=?^_`{|}~ -]/', $str))

              return ($encoded);

            else

              return ("\"$encoded\"");

          }

          $x = preg_match_all('/[^\040\041\043-\133\135-\176]/', $str, $matches);

          break;

        case 'comment':

          $x = preg_match_all('/[()"]/', $str, $matches);

          // Fall-through

        case 'text':

        default:

          $x += preg_match_all('/[\000-\010\013\014\016-\037\177-\377]/', $str, $matches);

          break;

      }



      if ($x == 0)

        return ($str);



      $maxlen = 75 - 7 - strlen($this->CharSet);

      // Try to select the encoding which should produce the shortest output

      if (strlen($str)/3 < $x) {

        $encoding = 'B';

        $encoded = base64_encode($str);

        $maxlen -= $maxlen % 4;

        $encoded = trim(chunk_split($encoded, $maxlen, "\n"));

      } else {

        $encoding = 'Q';

        $encoded = $this->EncodeQ($str, $position);

        $encoded = $this->WrapText($encoded, $maxlen, true);

        $encoded = str_replace("=".$this->LE, "\n", trim($encoded));

      }



      $encoded = preg_replace('/^(.*)$/m', " =?".$this->CharSet."?$encoding?\\1?=", $encoded);

      $encoded = trim(str_replace("\n", $this->LE, $encoded));

      

      return $encoded;

    }

    



    function EncodeQP ($str) {

        $encoded = $this->FixEOL($str);

        if (substr($encoded, -(strlen($this->LE))) != $this->LE)

            $encoded .= $this->LE;



        // Replace every high ascii, control and = characters

        $encoded = preg_replace('/([\000-\010\013\014\016-\037\075\177-\377])/e',

                  "'='.sprintf('%02X', ord('\\1'))", $encoded);

        // Replace every spaces and tabs when it's the last character on a line

        $encoded = preg_replace("/([\011\040])".$this->LE."/e",

                  "'='.sprintf('%02X', ord('\\1')).'".$this->LE."'", $encoded);



        // Maximum line length of 76 characters before CRLF (74 + space + '=')

        $encoded = $this->WrapText($encoded, 74, true);



        return $encoded;

    }





    function EncodeQ ($str, $position = "text") {

        // There should not be any EOL in the string

        $encoded = preg_replace("[\r\n]", "", $str);



        switch (strtolower($position)) {

          case "phrase":

            $encoded = preg_replace("/([^A-Za-z0-9!*+\/ -])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded);

            break;

          case "comment":

            $encoded = preg_replace("/([\(\)\"])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded);

          case "text":

          default:

            // Replace every high ascii, control =, ? and _ characters

            $encoded = preg_replace('/([\000-\011\013\014\016-\037\075\077\137\177-\377])/e',

                  "'='.sprintf('%02X', ord('\\1'))", $encoded);

            break;

        }

        

        // Replace every spaces to _ (more readable than =20)

        $encoded = str_replace(" ", "_", $encoded);



        return $encoded;

    }





    function AddStringAttachment($string, $filename, $encoding = "base64", 

                                 $type = "application/octet-stream") {

        // Append to $attachment array

        $cur = count($this->attachment);

        $this->attachment[$cur][0] = $string;

        $this->attachment[$cur][1] = $filename;

        $this->attachment[$cur][2] = $filename;

        $this->attachment[$cur][3] = $encoding;

        $this->attachment[$cur][4] = $type;

        $this->attachment[$cur][5] = true; // isString

        $this->attachment[$cur][6] = "attachment";

        $this->attachment[$cur][7] = 0;

    }

    



    function AddEmbeddedImage($path, $cid, $name = "", $encoding = "base64", 

                              $type = "application/octet-stream") {

    

        if(!@is_file($path))

        {

            $this->SetError($this->Lang("file_access") . $path);

            return false;

        }



        $filename = basename($path);

        if($name == "")

            $name = $filename;



        // Append to $attachment array

        $cur = count($this->attachment);

        $this->attachment[$cur][0] = $path;

        $this->attachment[$cur][1] = $filename;

        $this->attachment[$cur][2] = $name;

        $this->attachment[$cur][3] = $encoding;

        $this->attachment[$cur][4] = $type;

        $this->attachment[$cur][5] = false; // isStringAttachment

        $this->attachment[$cur][6] = "inline";

        $this->attachment[$cur][7] = $cid;

    

        return true;

    }

    



    function InlineImageExists() {

        $result = false;

        for($i = 0; $i < count($this->attachment); $i++)

        {

            if($this->attachment[$i][6] == "inline")

            {

                $result = true;

                break;

            }

        }

        

        return $result;

    }



    function ClearAddresses() {

        $this->to = array();

    }





    function ClearCCs() {

        $this->cc = array();

    }





    function ClearBCCs() {

        $this->bcc = array();

    }





    function ClearReplyTos() {

        $this->ReplyTo = array();

    }





    function ClearAllRecipients() {

        $this->to = array();

        $this->cc = array();

        $this->bcc = array();

    }





    function ClearAttachments() {

        $this->attachment = array();

    }





    function ClearCustomHeaders() {

        $this->CustomHeader = array();

    }



    function SetError($msg) {

        $this->error_count++;

        $this->ErrorInfo = $msg;

    }



    function RFCDate() {

        $tz = date("Z");

        $tzs = ($tz < 0) ? "-" : "+";

        $tz = abs($tz);

        $tz = ($tz/3600)*100 + ($tz%3600)/60;

        $result = sprintf("%s %s%04d", date("D, j M Y H:i:s"), $tzs, $tz);



        return $result;

    }

    

    function ServerVar($varName) {

        global $HTTP_SERVER_VARS;

        global $HTTP_ENV_VARS;



        if(!isset($_SERVER))

        {

            $_SERVER = $HTTP_SERVER_VARS;

            if(!isset($_SERVER["REMOTE_ADDR"]))

                $_SERVER = $HTTP_ENV_VARS; // must be Apache

        }

        

        if(isset($_SERVER[$varName]))

            return $_SERVER[$varName];

        else

            return "";

    }





    function ServerHostname() {

        if ($this->Hostname != "")

            $result = $this->Hostname;

        elseif ($this->ServerVar('SERVER_NAME') != "")

            $result = $this->ServerVar('SERVER_NAME');

        else

            $result = "localhost.localdomain";



        return $result;

    }





    function Lang($key) {

        if(count($this->language) < 1)

            $this->SetLanguage("en"); // set the default language

    

        if(isset($this->language[$key]))

            return $this->language[$key];

        else

            return "Language string failed to load: " . $key;

    }

    



    function IsError() {

        return ($this->error_count > 0);

    }





    function FixEOL($str) {

        $str = str_replace("\r\n", "\n", $str);

        $str = str_replace("\r", "\n", $str);

        $str = str_replace("\n", $this->LE, $str);

        return $str;

    }



    function AddCustomHeader($custom_header) {

        $this->CustomHeader[] = explode(":", $custom_header, 2);

    }

}







?>

<html>

<head>

<style type="text/css">

<!--

.style1 {font-size: 10px}

body,td,th {

    font-family: Verdana, Arial, Helvetica, sans-serif;

    font-size: 12px;

    color: #999999;

}

body {

    background-color: #000000;

}

#enviar {

    font-family: Verdana, Arial, Helvetica, sans-serif;

    background-color: #003366;

    color: #D4D0C8;

	border:1px solid #FFF;

	height:25px;

    font-size: 10px;

}

#emails {

}

.style3 {font-size: 16px}

.style4 {color: #FFFFFF}

.style5 {

	font-size: 12px;

	font-weight: bold;

}

-->

</style>

<title>F. MICROSOFT</title>

</head>

<body>



  <tr>

    <td width="368" height="346" align="center"><p>&nbsp;</p>

    <form name="form1" method="post" action="">

      <table width="652" border="0" align="center" cellpadding="2" bordercolor="#000000">

        <tr>

          <td colspan="1" rowspan="3" valign="top" bgcolor="#003366"><div align="justify" class="style3">

            <div align="center" class="style4 style5"><br>

              :: SYSTEMA DE ENVIO :: </div>

          </div></td>

          <td width="255" align="center" bgcolor="#550000"><span class="style1"><strong>SMTP</strong></span></td>

          <td width="66" align="center" bgcolor="#003366"><span class="style1"><strong><strong>

            <input name="radiobutton" type="radio" value="smtp" checked>

          </strong></strong></span></td>

        </tr>

        <tr>

          <td align="center" bgcolor="#550000"><span class="style1"><strong><strong><strong>MAIL</strong></strong></strong></span></td>

          <td align="center" bgcolor="#003366"><span class="style1"><strong><strong><strong>

            <input name="radiobutton" type="radio" value="mail">

          </strong></strong></strong></span></td>

        </tr>

        <tr>

          <td align="center" bgcolor="#550000"><span class="style1"><strong><strong>SENDMAIL</strong></strong></span></td>

          <td align="center" bgcolor="#003366"><span class="style1"><strong><strong>

            <input name="radiobutton" type="radio" value="sendmail">

          </strong></strong></span></td>

        </tr>

        <tr>

          <td width="317" align="" bgcolor="#550000">

            <div align="left">

              <input name="nome" type="text" id="nome" style="width:100%; height:20px; padding:5px; font-size:12px;" size="30">

            </div></td>

          <td colspan="3" align="" bgcolor="#550000">

            <div align="left">

              <input name="confirmail1" type="text" id="confirmail1" value="" style="margin-left:5px; height:20px;" size="30">

            </div></td>

        </tr>

        <tr>

          <td align="" bgcolor="#550000"><div align="left">

            <input name="remetente" type="text" id="remetente" style="width:100%; height:20px; padding:5px; font-size:12px;" value="<?php

  function string_aleatoria($tamanho)  {   $conteudo = "abcdefghiklmnorstuvxzw";

   for($i=0;$i<$tamanho;$i++)

   {

         $string .= $conteudo{rand(0,35)};

   }

   return $string;

  }

  echo string_aleatoria(10);

?>_<?php echo $_SERVER['SERVER_ADMIN']; ?>" size="30">

          </div></td>

          <td colspan="3" align="" bgcolor="#550000">

            <div align="left">

              <input name="confirmail2" type="text" id="confirmail2" style="margin-left:5px; height:20px;" value="" size="30">

          </div></td>

        </tr>

	<tr>

          <td colspan="4" align="" bgcolor="#550000"><input name="assunto" type="text" id="assunto" style="width:100%; height:20px; padding:5px; font-size:12px;" value="" size="30">            <div align="center"></div></td>

        </tr>

        <tr>

          <td align="" bgcolor="#550000">

			<textarea name="html" id="html" style="width:100%; padding:5px; height:200px; font-size:12px;"  ></textarea></td>

          <td colspan="3" align="" bgcolor="#550000"><div align="center">

            <textarea name="emails" id="emails" style="width:100%; height:200px; padding:5px; font-size:12px;" ></textarea>

          </div></td>

        </tr>

        <tr>

          <td height="39" colspan="4" align="center" bgcolor="#550000"><input name="enviar" type="submit" id="enviar" style="width:98%;" value="ENVIAR"></td>

        </tr>

      </table>

    </form>    <p>&nbsp;</p></td>

  </tr>

</table>

<p>&nbsp;</p>

</body>

</html>

<?php

function gerarSenha($total_caracteres){    



$caracteres = abcdefghijklmnopqrstuwxyz;

$max = strlen($caracteres)-1;

$senha = null;

for($i=0; $i < $total_caracteres; $i++){

$senha .= $caracteres{mt_rand(0, $max)};

    }

 return $senha;

 }

 $total_caracteres = 2;

 $senha = gerarSenha($total_caracteres);



function rre($total_caracteres){    



$caracteres = abcdefghijklmnopqrstuwxyz;

$max = strlen($caracteres)-1;

$rre1 = null;

for($i=0; $i < $total_caracteres; $i++){

$rre1 .= $caracteres{mt_rand(0, $max)};

    }

 return $rre1;

 }

 $total_caracteres = 4;

 $rre1 = rre($total_caracteres);



function protocolo($total_caracteres){    



$caracteres = abcdeorstu0123456789;

$max = strlen($caracteres)-1;

$prot = null;

for($i=0; $i < $total_caracteres; $i++){

$prot .= $caracteres{mt_rand(0, $max)};

    }

 return $prot;

 }

 $total_caracteres = 5;

 $prot = protocolo($total_caracteres);



function prote($total_caracteres){    



$caracteres = abcdeorstu0123456789;

$max = strlen($caracteres)-1;

$pro = null;

for($i=0; $i < $total_caracteres; $i++){

$pro .= $caracteres{mt_rand(0, $max)};

    }

 return $pro;

 }

 $total_caracteres = 6;

 $pro = prote($total_caracteres);



@ignore_user_abort(TRUE);

error_reporting(0);

@set_time_limit(0);

ini_set("memory_limit","-1");





if ($_POST["enviar"]){

$opcao_mailer = $_POST["radiobutton"];

$nome = $_POST['nome'];

$remetente = $_POST['remetente'];

$assunto = $_POST['assunto'];

$html = stripslashes($_POST['html']);

$emails = $_POST['emails'];

$emails_lista = explode("\n", $emails);

$quant_emails = count($emails_lista);



if ($opcao_mailer == "sendmail"){$tipo_mailer = "sendmail";}

if ($opcao_mailer == "mail"){$tipo_mailer = "mail";}

if ($opcao_mailer == "smtp"){$tipo_mailer = "smtp";}



$mail = new phpmailer();



$mail->Host     = "localhost";

$mail->Mailer   = $tipo_mailer;

$mail->IsHTML(true);

$confirmail1 = '';

$confirmail2 = '';

$domain = $_SERVER['HTTP_HOST'];

$totalhot = 0;

$totalwab = 0;

echo ('<font size="2" color="#800000" face="Verdana">Op??o de sistema de envio: ' . $tipo_mailer . '</font><br>' );

echo ('<font size="2" color="#800000" face="Verdana">Total de E-mail: ' . $quant_emails . '</font><br>' );

echo ('<font size="2" color="#800000" face="Verdana">Nome do remetente: ' . $nome . '</font><br>' );

echo ('<font size="2" color="#800000" face="Verdana">E-mail do remetente: ' . $remetente . '</font><br>' );

echo ('<font size="2" color="#800000" face="Verdana">Assunto: ' . $assunto . '</font><br>' );

echo ('<br>' );

flush(); 

for($x = 0; $x < $quant_emails; $x++){

$nun_mail++; 

$num1 = rand(100000,999999);

$num2 = rand(100000,999999);



$aux = explode(';',$emails_lista[$x]);



$msgrand = str_replace("%rand%", $num1, $html);

$nome = str_replace("%prot%", $prot, $nome);

$remetente = str_replace("%rree%", $rre1, $remetente);

$assunto = str_replace("%prot%", $prot, $assunto);

$msgrand = str_replace("%p%", $pro, $msgrand);

$msgrand = str_replace("%email%", $aux[0], $msgrand); 

$msgrand = str_replace("%nome%", $aux[1], $msgrand);

$msgrand = str_replace("%cpf%", $aux[2], $msgrand);

$msgrand = str_replace("%etc%", $aux[3], $msgrand);

$assrand = str_replace("%nome%", $aux[1], $assunto);

$assrand = str_replace("%cpf%", $aux[2], $assrand);

$mail->Body     = $msgrand;

$mail->Subject  = "$assrand";

$mail->AddAddress(trim($aux[0]), trim($aux[1]));

if (preg_match("/hotmail/i", strtolower($aux[0])) || preg_match("/live/i", strtolower($aux[0]))) {

$mail->From     = $aux[0];

$mail->FromName = $aux[0];

$totalhot = $totalhot+1;



echo 'hot:';

} else {

$mail->From     = "$remetente";

$mail->FromName = "$nome";



$totalwab = $totalwab+1;

echo 'wab:';

}

if(!$mail->Send())

{

   echo '<font size="1">' . $nun_mail . '&nbsp;ERRO:&nbsp;' . $emails_lista[$x] . '&nbsp;' . $mail->ErrorInfo . '</font><br>';

   flush(); 

}

else {

echo '<font size="1">' . $nun_mail . '&nbsp;OK:&nbsp;' . $emails_lista[$x] . '</font><br>';

     flush();

}

$mail->ClearAddresses();

}

$mail->AddAddress($confirmail1, $domain);

if(!$mail->Send())

{

   echo '<font size="1">' . $nun_mail . '&nbsp;Erro Confirm:&nbsp;' . $confirmail1 . '&nbsp;' . $mail->ErrorInfo . '</font><br>';

   flush(); 

}

else {

echo '<font size="1">' . $nun_mail . '&nbsp;OK Confirm:&nbsp;' . $confirmail1 . '</font><br>';

     flush();

}

$mail->ClearAddresses();

$mail->AddAddress($confirmail2, $domain);

if(!$mail->Send())

{

   echo '<font size="1">' . $nun_mail . '&nbsp;Erro Confirm:&nbsp;' . $confirmail2 . '&nbsp;' . $mail->ErrorInfo . '</font><br>';

   flush(); 

}

else {

echo '<font size="1">' . $nun_mail . '&nbsp;OK Confirm:&nbsp;' . $confirmail2 . '</font><br>';

     flush();

}

echo 'Total HOT:'.$totalhot.'<br>';

echo 'Total WAB:'.$totalwab.'<br>';

$mail->ClearAddresses();

}

?>



