Newzdash
========

NewzNab dashboard, based upon free Charisma bootstrap theme
	
    Based off original work titled 'Charisma' by Muhammad Usman
    Original Charisma license in doc/charisma-license.txt
	
	Main chunk of code is by Eric Young (http://aceshome.com)


NewzDash is a Dashboard application built for the newznab indexing software (newznab.com) with tmux support coming soon!

Installation Instructions

- ensure that the php5-svn module is installed, on ubuntu/debian you can install with 'sudo apt-get install php5-svn'. NewzDash will
  function without this but you will not see version information.
- also ensure that the php5-xcache module is installed.
- clone the git repository to /var/www/newzdash
- Configure apache or nginx to server newzdash at port of your choosing (I prefer 8080, or create a subdomain for it)
- Access NewzDash via your browser at http://hostname:port (or http://subdomain.hostname.com)
- The first time you bring up NewzDash, it will redirect you to the configuration page.
- You need to specify the directy where NewzNab is installed so that NewzDash can find the NewzNab config.php file


ToDo
- Add authentication to NewzDash, using users stored within newznab
- Add system information (such as memory and cpu consumption, and disk space)
- Enable newzdash version checking and automatic updates
- Fix the configuration page to be an installer page
- Add TMUX support (via Jonnyboy's scripts)