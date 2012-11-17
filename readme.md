## About
This repo is simply an experiment to use different libraries:
- Silex to manage the application
- Symfony Console to manage the task
- Guzzle to fetch data from instagram

## Installation

Follow this steps:

``` bash
clone this repo
curl -s http://getcomposer.org/installer | php)
php composer.phar install 
cd vendor && git clone git://github.com/guzzle/guzzle-silex-extension.git
```

## Configuration
You should register a new client from instagram and get "client_secret" and "access_token" (http://instagram.com/developer/clients/manage/)

Then change it directly in console.php execute function

## Execution

Now runnging

``` bash
php src/console.php 
```

``` bash
Usage:
  [options] command [arguments]

Options:
 ...

Available commands:
Instagram
  Instagram:sync   Synchronize /v1/users/<user_id>/media/recent/
  help             Displays help for a command
  list             Lists commands
```


You can run the Instagram:sync task that fetch the "/media/recent/" information from Instagram 
``` bash
$ php src/console.php Instagram:sync <user_id>
```

or, if you need, you can execute in the browser with 

```
http://your-installation/index.php/user/<user_id>
```

There is no implementation about data storage. Is a simply task to try different php libraries