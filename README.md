Stanley Gibbons API assessment.  
Author: Colin Craig
  
Setup:
- vagrant up
- curl -H "Content-Type: application/json" -X POST -d '{"numbers":[5,6,8,7,5]}' http://192.168.33.12/mmmr

About:
- I purposely refrained from using External libraries.
- Since I have experiance building API frameworks, I took the liberty of building a small framework for this application.
- This IS a technical assessment, so why not do something cool?!

To use the framework:  
```php
// run your autoloader...  
// Autoload();  
  
// use the Api Framework.  
use api\Api as Api;  
  
// Instantiate the API  
$api = new Api();  
  
// Instantiate a Controller, with static methods.  
// ExampleController has the static methods:  
// ExampleController::test1  
// ExampleController::test2  
// ExampleController::test3  
// ExampleController::test4  
  
$example = new ExampleController();  
  
// Define all of your routes!  
// API->setRoute accepts (/route, array(class, method), HTTP_REQUEST_TYPE)  
  
$api->setRoute('/testroute1', array($example,'test1'), 'POST');  
$api->setRoute('/testroute2', array($example,'test2'), 'POST');  
$api->setRoute('/testroute3', array($example,'test3'), 'POST');  
$api->setRoute('/testroute4', array($example,'test4'), 'POST');  
  
// Dispatch the request!  
$api->dispatch();  
  
// The following routes will now work:  
// API_ROOT/testroute1 [POST]  
// API_ROOT/testroute2 [POST]  
// API_ROOT/testroute3 [POST]  
// API_ROOT/testroute4 [POST]  
// Anything else will return a HTTP 404 error.  
```