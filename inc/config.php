<?php
/* mysql read and write database*/
 $config['mysql']['rw']['user'] = "grolog"; //mysql unique username for the frontend
 $config['mysql']['rw']['pass'] = "grolog"; //mysql password for the frontend user
 $config['mysql']['rw']['db']   = "grolog";   //mysql database of system
 $config['mysql']['rw']['host'] = "localhost"; //mysql host address
 $config['mysql']['rw']['port'] = '3306'; //mysql server port

 
 
 /***************************
 * STOP! DO NOT EDIT BELOW! *
 ***************************/
 
  
 /* general settings */
 $config['pass']['length'] = 9; //minimum length of password
 $config['pass']['caps'] = 3; //minimum number of caps in password
 $config['pass']['numbers'] = 3; // minimum number of numbers in password
 $config['pass']['special'] = 3; // minimum number of special characters in password
 
  /* Configure the following */
 $config['main']['config']['siteLongName'] = "GroLog"; //full name of site
 $config['main']['config']['siteShortName'] = "GL"; //short name or abbrv.
 $config['main']['config']['url']       = "127.0.0.1";
 $config['main']['email']['noreply']    = "noreply@".$config['main']['config']['url'] ;
 $config['main']['email']['support']    = "support@".$config['main']['config']['url'];
 $config['main']['email']['alerts']     = "alerts@".$config['main']['config']['url'];
 $config['main']['email']['auth']     = "authentication@".$config['main']['config']['url']; //authentication of logins gets its own address so users can more easily track authentications
 $config['main']['email']['bcc']     = "bcc@".$config['main']['config']['url'];//blind carbon copy address for all emails
 $config['main']['email']['auth']     = "authentication@".$config['main']['config']['url'];
 
 
 
 
 ?>
