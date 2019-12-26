<?php

# -----------------------------------------------------------------------
# CONFIGURATION OPTIONS
# -----------------------------------------------------------------------

$CONFIG_NAME            = 'Company.mail.mobileconfig';

$IMAP_SERVER            = 'mail.example.com';
$SMTP_SERVER            = 'mail.example.com';

$IMAP_PORT              = '993';
$SMTP_PORT              = '465';
$HTTP_MODE              = 'https';
$PORTS_ARE_SSL          = 'true';

$COMPANY_NAME           = 'Company';
$WEBSITE                = 'https://example.com';

$SERVER_CRT             = 'mail.example.com.crt';          // Server Cert
$SERVER_KEY             = 'mail.example.com.key';          // Server Key
$CA_CRT                 = 'mail.example.com.ca.crt';       // CA Cert


# -----------------------------------------------------------------------
# CODE STARTS HERE
# -----------------------------------------------------------------------

$FULLNAME               = $_POST['fullname'];
$EMAIL                  = $_POST['email'];


$data = '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict> 
        <key>PayloadContent</key>
        <array>
                <dict>
                        <key>EmailAccountDescription</key>
                        <string>'. $COMPANY_NAME.'</string>
                        <key>EmailAccountName</key>
                        <string>'. $FULLNAME.'</string>
                        <key>EmailAccountType</key>
                        <string>EmailTypeIMAP</string>
                        <key>EmailAddress</key>
                        <string>' . $EMAIL . '</string>
                        <key>IncomingMailServerAuthentication</key>
                        <string>EmailAuthPassword</string>
                        <key>IncomingMailServerHostName</key>
                        <string>'. $IMAP_SERVER.'</string>
                        <key>IncomingMailServerPortNumber</key>
                        <integer>'. $IMAP_PORT.'</integer>
                        <key>IncomingMailServerUseSSL</key>
                        <'. $PORTS_ARE_SSL.'/>
                        <key>IncomingMailServerUsername</key>
                        <string>' . $EMAIL . '</string>
                        <key>OutgoingMailServerAuthentication</key>
                        <string>EmailAuthPassword</string>
                        <key>OutgoingMailServerHostName</key>
                        <string>'. $SMTP_SERVER.'</string>
                        <key>OutgoingMailServerPortNumber</key>
                        <integer>'. $SMTP_PORT.'</integer>
                        <key>OutgoingMailServerUseSSL</key>
                        <'. $PORTS_ARE_SSL.'/>
                        <key>OutgoingMailServerUsername</key>
                        <string>' . $EMAIL . '</string>
                        <key>OutgoingPasswordSameAsIncomingPassword</key>
                        <true/>
                        <key>PayloadDescription</key>
                        <string>Configures email account.</string>
                        <key>PayloadDisplayName</key>
                        <string>'. $COMPANY_NAME.'</string>
                        <key>PayloadIdentifier</key>
                        <string>com.mail.'. $COMPANY_NAME.'.email1</string>
                        <key>PayloadOrganization</key>
                        <string>'. $COMPANY_NAME.'</string>
                        <key>PayloadType</key>
                        <string>com.apple.mail.managed</string>
                        <key>PayloadUUID</key>
                        <string>F38922FD-'. $COMPANY_NAME.'-471A-9347-9E938144E8D4</string>
                        <key>PayloadVersion</key>
                        <integer>1</integer>
                        <key>PreventAppSheet</key>
                        <false/>
                        <key>PreventMove</key>
                        <false/>
                        <key>SMIMEEnabled</key>
                        <false/>
                        <key>disableMailRecentsSyncing</key>
                        <false/>
                </dict>
        </array>
        <key>PayloadDescription</key>
        <string>This will set up your '. $COMPANY_NAME.' mail account on your device.</string>
        <key>PayloadDisplayName</key>
        <string>'. $COMPANY_NAME.' </string>
        <key>PayloadIdentifier</key>
        <string>com.mail.'. $COMPANY_NAME.'</string>
        <key>PayloadOrganization</key>
        <string>'. $COMPANY_NAME.' </string>
        <key>PayloadRemovalDisallowed</key>
        <false/>
        <key>PayloadType</key>
        <string>Configuration</string>
        <key>PayloadUUID</key>
        <string>E19075EE-'. $COMPANY_NAME.'-41A7-8514-2F0B5ABB3567</string>
        <key>PayloadVersion</key>
        <integer>1</integer>
</dict>
</plist>
';

# Remove previously generated files
$remove1 = `rm unsigned.mobileconfig`;
$remove2 = `rm profile/$CONFIG_NAME`;

# Create the mobileconfig
$fp = fopen('unsigned.mobileconfig', 'w');
fwrite($fp, $data);
fclose($fp);


# Set header for downloading the file contents
header("Content-type: plain/text");
header("Content-Disposition: attachment; filename=". $CONFIG_NAME);

# Sign the mobileconfig
$signcmd = `openssl smime -sign -in unsigned.mobileconfig -out profile/$CONFIG_NAME -signer $SERVER_CRT -inkey $SERVER_KEY -certfile $CA_CRT -outform der -nodetach`;
$sign    = `$signcmd`;


# Get the file contents
$file = file_get_contents("profile/$CONFIG_NAME", true);
echo $file;

# Remove temporary files
$remove1 = `rm unsigned.mobileconfig`;
$remove2 = `rm profile/$CONFIG_NAME`;

 ?>

