# Generate easy configuration profiles for your company mail server
Easy way to generate signed iOS MobileConfig files, for automatic email configuration on iPhone / Mac

1. Place on webserver
2. Check out the generate.php for variables you need to set
3. Make sure you set the paths to the certs properly
4. Change permissions of the 'profile' folder to allow the webserver to write to it (mind that files will be deleted after download).

# Easy usage by the end-user
1. Enter your full name as it should appear to a recipient
2. Enter your (company) email address
3. Click 'Continue'
4. A profile will download, install it. 
5. Upon installation, it will ask for your password as only remaining question
