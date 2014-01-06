Silex webapplication
=============================

This a web application that logs the user
with the Google Plus id

Installation instructions
----------------------------------

 * Register the application in google Plus and set 
   the client_id, client_secret and other parameters


 * Add inside the lighttpd.conf configuration
 the following snippet:

```
 
 $HTTP["host"]  == "www.devbox.example2.com" {
  server.document-root = "/home/user/Documents/my_documents/thesis_authentication2/src/google_plus_example/web"
  accesslog.filename         = "/home/user/tmp/oauth2GooglePlus/access.log"
  fastcgi.server = ( ".php" =>
        ((
            "bin-path" => "/opt/phpfarm/inst/current-bin/php-cgi -c /home/user/software/php/5_5_1/cgi/php.ini",
            "socket" => "/tmp/php.socket",
        ))
    )

    url.rewrite-if-not-file = (
    "^(/[^\?]*)(\?.*)?" => "/index.php$1$2"
                )
}

 ```
 

  * Add in the hosts file the following code :

```
127.0.0.1 www.devbox.example2.com
```

  * Run the file deploy/db.sql to create the database

  * Config the composer.json to use the library for example the autload
    attribute should look like:
  
  ```
  "autoload": {
        "psr-0": {
            "ArComMiura":"src/",
            "ArComMiuraOAuth2Component":"/home/user/Documents/my_documents/thesis_authentication2/src/oauth_component/src/"
        }
    }
  ```
  Where the path "/home/user/Documents/my_documents/thesis_authentication2/src/oauth_component/src/"
  points to a directory that contains the directory "ArComMiuraOAuth2Component" 

 * Inside the database used run the following sql 
 to create the table to store the sessions:

 ```
 CREATE TABLE `session` (
    `session_id` varchar(255) NOT NULL,
    `session_value` text NOT NULL,
    `session_time` int(11) NOT NULL,
    PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 ```

Bugs
----------------------------------

 * If i don't use the pdo sessions there are problems 
  with the sessions because in the  /login when i store
  the antiforgery token named "state" . If i want
  to retrieve it in the /oauth2callback the session
  says it does not exist.
  
