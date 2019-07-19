## API Response

Package for standardizing the responses from the API of your **Symfony based** applications.

![api response](https://user-images.githubusercontent.com/10347617/41526643-83080b9c-72ed-11e8-9fc7-9780546e0255.png)

<p align="center">
    <a href="https://styleci.io/repos/82566268"><img src="https://styleci.io/repos/82566268/shield" alt="StyleCI" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/api-response"><img src="https://img.shields.io/packagist/dt/andrey-helldar/api-response.svg?style=flat-square" alt="Total Downloads" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/api-response"><img src="https://poser.pugx.org/andrey-helldar/api-response/v/stable?format=flat-square" alt="Latest Stable Version" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/api-response"><img src="https://poser.pugx.org/andrey-helldar/api-response/v/unstable?format=flat-square" alt="Latest Unstable Version" /></a>
    <a href="LICENSE"><img src="https://poser.pugx.org/andrey-helldar/api-response/license?format=flat-square" alt="License" /></a>
</p>


## Installation

To get the latest version of `API Response`, simply require the project using [Composer](https://getcomposer.org/):

```bash
$ composer require andrey-helldar/api-response
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "andrey-helldar/api-response": "^4.0"
    }
}
```

If you don't use auto-discovery, add the ServiceProvider to the providers array in `config/app.php`:

    Helldar\ApiResponse\ServiceProvider::class,

If you use a package outside the Laravel framework, you only need to connect the file `src/helpers.php`:

```php
require_once 'src/helpers.php';
```

Alright! Use `api_response()` helper.


## Using

### returned NULL with code:
```php
return api_response(null, 304);
```
returned with code 304:
```json
null
```

### returned integer with default code:
```php
return api_response(304);
```
returned with code 200:
```json
304
```

### returned string with default code:
```php
return api_response('qwerty');
```
returned with code 200:
```json
"qwerty"
```

### returned string with code:
```php
return api_response('qwerty', 400);
```
returned with code 400:
```json
{
  "error": {
    "code": 400,
    "msg": "qwerty"
  }
}
```

### returned integer with code:
```php
return api_response(304, 400);
```
returned with code 400:
```json
{
  "error": {
    "code": 400,
    "msg": 304
  }
}
```

### returned array:
```php
$content = [
    [
        'title' => 'Title #1',
        'description' => 'Description #1',
    ],
    [
        'title' => 'Title #2',
        'description' => 'Description #2',
    ],
];
```

#### as error
```php
return api_response($content, 400);
```
returned with code 400:
```json
{
  "error": {
    "code": 400,
    "msg": [
      {
        "title": "Title #1",
        "description": "Description #1"
      },
      {
        "title": "Title #2",
        "description": "Description #2"
      }
    ]
  }
}
```

#### as success
```php
return api_response($content, 200);
```
returned with code 200:
```json
[
  {
    "title": "Title #1",
    "description": "Description #1"
  },
  {
    "title": "Title #2",
    "description": "Description #2"
  }
]
```
    
If the first parameter is a number, then the decryption of the error by code will be returned. In other cases, the value of the passed variable will be returned.

### Using in Laravel 5+ framework

To use you need to add three methods to the file `app/Exceptions/Handler.php`:

```php
protected function unauthenticated($request, AuthenticationException $exception)
{
    if ($this->isJson($request)) {
        return api_response(__('Unauthorized'), 401);
    }

    return redirect()->guest(route('login'));
}

protected function invalidJson($request, ValidationException $exception)
{
    return api_response($exception->errors(), $exception->status ?: 400);
}

protected function isJson($request): bool
{
    return $request->expectsJson() || $request->isJson() || $request->is('api/');
}
```


## Copyright and License

ApiResponse was written by Andrey Helldar, and is licensed under [The MIT License](LICENSE).


## Translation

Translations of text and comment by Google Translate.

Help with translation +1 in karma :)
