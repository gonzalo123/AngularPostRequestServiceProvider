# AngularPostRequestServiceProvider

[![Build Status](https://travis-ci.org/gonzalo123/AngularPostRequestServiceProvider.svg?branch=master)](https://travis-ci.org/gonzalo123/AngularPostRequestServiceProvider)

When we work with AngularJs Applications POST request uses Content-Type: application/json
Silex (and Symfony) assumes application/x-www-form-urlencoded
Here we can se how to handle those requests with Silex:
https://github.com/qandidate-labs/symfony-json-request-transformer

In this small project we are going to enclose this funcionality within a ServiceProvider

## Install Via Composer

```json
{
    "require": {
        "gonzalo123/angularpostrequestserviceprovider": "~1.0"
    }
}
```

## Usage

```php
use Silex\Application;
use G\AngularPostRequestServiceProvider;
use Symfony\Component\HttpFoundation\Request;

$app = new Application();
$app->register(new AngularPostRequestServiceProvider());

$app->post("/post", function (Application $app, Request $request) {
    return $app->json([
        'status' => true,
        'name'   => $request->get('name')
    ]);
});

$app->run();
```
