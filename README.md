Newzdash
========

** Ruhllatio's Change 02/13/2013 - **

    Changing p= to page= which is the default configuration for newznab.  Censor
    chose to deploy the mod_rewrite for flag p=.  If you're using Apache, this is fine because
    censor included the .htaccess file that Apache uses for the rewrite.
    This should automatically fix everyone's current issues with newzdash deployed
    on nginx.  If you find it still isn't working for you, do a fresh clone and install.
    Then ensure that your nginx rewrite looks something like this:
    
    rewrite ([^/.]+)?$ /index.php?page=$1? last;
    
    Adapt as necessary if you deployed newzdash as a subdir off newznab

NewzNab dashboard, based upon free Charisma bootstrap theme
	
    Based off original work titled 'Charisma' by Muhammad Usman
    Original Charisma license in doc/charisma-license.txt


NewzDash is a Dashboard application built for the newznab indexing software (newznab.com)

Installation Instructions

- ensure that the php5-svn module is installed, on ubuntu/debian you can install with 'sudo apt-get install php5-svn'. NewzDash will
  function without this but you will not see version information.
- You may also install a PHP Caching module to greatly decrease the bandwidth usage of Newzdash, Supported modules are: APC, Memcache and XCache.
- clone the git repository: 'git clone https://github.com/AlienXAXS/newzdash.git /var/www/newzdash'.
- Configure your web server to either: Run NewzDash on a subdomain (ref #1), or run NewzDash in a sub folder (ref #2).
- Access NewzDash via your browser and start the install process.

TMUX Configuration (If you want tmux to talk to newzdash)
1) On step three of the installer, you are provided with a TMUX Shared Secret, input this into your defaults.sh file near the bottom


ToDo
- Add authentication to NewzDash, using users stored within newznab
- Add system information (such as memory and cpu consumption, and disk space)
- Enable newzdash version checking and automatic updates

Ref #1
------

	Create a new vhost file, for apache thats:
	/etc/apache2/sites-enabled
	


Ref #2
------

	If you are wanting to put newzdash in a sub directory of newznab, you will have to modify the .htaccess file of Newznab.

	Find:
	RewriteRule ^(admin|install).*$ - [L]

	Change to:
	RewriteRule ^(admin|install|newzdash).*$ - [L]



People who have helped
======================

** Ruhllatio's Change 02/13/2013 - **

    Changing some JS script and font import (CSS) sources around 
    for people (like me) using HTTPS and having insecure content errors

** jangrewe (aka censor) **
   
   Changing CSS stuff, and other things I forget :P
   And for being awesum!
   
