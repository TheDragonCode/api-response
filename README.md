## API Response

Package for standardizing the responses from the API of your **Symfony based** applications.

![api response](https://user-images.githubusercontent.com/10347617/41526643-83080b9c-72ed-11e8-9fc7-9780546e0255.png)

<p align="center">
    <a href="https://packagist.org/packages/andrey-helldar/api-response"><img src="https://img.shields.io/packagist/dt/andrey-helldar/api-response.svg?style=flat-square" alt="Total Downloads" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/api-response"><img src="https://poser.pugx.org/andrey-helldar/api-response/v/stable?format=flat-square" alt="Latest Stable Version" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/api-response"><img src="https://poser.pugx.org/andrey-helldar/api-response/v/unstable?format=flat-square" alt="Latest Unstable Version" /></a>
    <a href="LICENSE"><img src="https://poser.pugx.org/andrey-helldar/api-response/license?format=flat-square" alt="License" /></a>
</p>
<p align="center">
    <a href="https://styleci.io/repos/82566268"><img src="https://styleci.io/repos/82566268/shield" alt="StyleCI" /></a>
    <a href="https://scrutinizer-ci.com/g/andrey-helldar/api-response"><img src="https://scrutinizer-ci.com/g/andrey-helldar/api-response/badges/quality-score.png?b=master" alt="Code Quality" /></a>
    <a href="https://scrutinizer-ci.com/g/andrey-helldar/api-response"><img src="https://scrutinizer-ci.com/g/andrey-helldar/api-response/badges/build.png?b=master" alt="Build Quality" /></a>
</p>


## Content
* [Installation](#installation)
* [Using](#using)
    * [as NULL with code](#as-null-with-code)
    * [as integer with default code](#as-integer-with-default-code)
    * [as string with default code](#as-string-with-default-code)
    * [as string with code](#as-string-with-code)
    * [as integer with code](#as-integer-with-code)
    * [as array](#as-array)
    * [with additional content](#with-additional-content)
* [Use without `data` key](#use-without-data-key)
    * [as NULL with code](#as-null-with-code-and-without-data-key)
    * [as integer with default code](#as-integer-with-default-code-and-without-data-key)
    * [as string with default code](#as-string-with-default-code-and-without-data-key)
    * [as string with code](#as-string-with-code-and-without-data-key)
    * [as integer with code](#as-integer-with-code-and-without-data-key)
    * [as array](#as-array-and-without-data-key)
    * [with additional content](#with-additional-content-and-without-data-key)
* [Using in Laravel 5+ framework](#using-in-laravel-5-framework)
* [Copyright and License](#copyright-and-license)


## Installation

To get the latest version of `API Response`, simply require the project using [Composer](https://getcomposer.org/):

```bash
$ composer require andrey-helldar/api-response
```

This command will automatically install the latest version of the package for your environment.

Or you can manually set the required version, following the table:

| Package version | PHP version | Symfony version | Command |
|:---:|:---:|:---:|:---|
|  ^4.0 | 5.6.9+ | ^3.0, ^4.0 | `composer require andrey-helldar/api-response:^4.0` |
|  ^4.4.1 | 5.6.9+ | ^3.0, ^4.0, ^5.0 | `composer require andrey-helldar/api-response:^4.4` |
|  ^5.0 | 7.1.3+ | ^4.0, ^5.0 | `composer require andrey-helldar/api-response:^5.0` |
|  latest | 7.1.3+ | ^4.0, ^5.0 | `composer require andrey-helldar/api-response` |

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "andrey-helldar/api-response": "^5.0"
    }
}
```

Alright! Use `api_response()` helper.

[[ to top ]](#api-response)


## Using

### as NULL with code:
```php
return api_response(null, 304);
```
return with code 304:
```json
{
    "data": null
}
```

[[ to top ]](#api-response)

### as integer with default code:
```php
return api_response(304);
```
return with code 200:
```json
{
    "data": 304
}
```

[[ to top ]](#api-response)

### as string with default code:
```php
return api_response('qwerty');
```
return with code 200:
```json
{
    "data": "qwerty"
}
```

[[ to top ]](#api-response)

### as string with code:
```php
return api_response('qwerty', 400);
```
return with code 400:
```json
{
  "error": {
    "code": 400,
    "data": "qwerty"
  }
}
```

[[ to top ]](#api-response)

### as integer with code:
```php
return api_response(304, 400);
```
return with code 400:
```json
{
  "error": {
    "code": 400,
    "data": 304
  }
}
```

[[ to top ]](#api-response)

### as array:
```php
$data = [
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

[[ to top ]](#api-response)

#### as error
```php
return api_response($data, 400);
```
return with code 400:
```json
{
  "error": {
    "code": 400,
    "data": [
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

[[ to top ]](#api-response)

#### as success
```php
return api_response($data, 200);
```
return with code 200:
```json
{
    "data": [
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
```
    
If the first parameter is a number, then the decryption of the error by code will be return. In other cases, the value of the passed variable will be return.

[[ to top ]](#api-response)

### with additional content
```php
return api_response('title', 200, [], ['foo' => 'bar']);
```
return with code 200:
```json
{
  "data": "title",
  "foo": "bar"
}
```

return with code 400:
```json
{
  "error": {
    "code": 400,
    "data":"ok"
  },
  "foo": "bar"
}
```


```php
return api_response(['data' => 'foo', 'bar' => 'baz']);
```

return with code 200:
```json
{
  "data": "foo",
  "bar": "baz"
}
```

return with code 400:
```json
{
  "error": {
    "code": 400,
    "data":"foo"
  },
  "bar": "baz"
}
```

[[ to top ]](#api-response)


## Use without `data` key

If you do not want to wrap the response in the `data` key, then you need to pass the `false` value to the 5th parameter of the function:

```php
use Helldar\ApiResponse\Services\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Return a new response from the application.
 *
 * @param mixed|null $data
 * @param int $status_code
 * @param array $headers
 * @param array $with
 * @param bool $use_data
 *
 * @return JsonResponse
 */
function api_response(
    $data = null,
    int $status_code = 200,
    array $headers = [],
    array $with = [],
    bool $use_data = true
)
{
    return Response::init()
        ->headers($headers)
        ->data($data, $use_data)
        ->with($with)
        ->status($status_code)
        ->response();
}
```

### as NULL with code and without `data` key:
```php
return api_response(null, 304, [], [], false);
```
return with code 304:
```json
{}
```

[[ to top ]](#api-response)

### as integer with default code and without `data` key:
```php
return api_response(304, 200, [], [], false);
```
return with code 200:
```json
304
```

[[ to top ]](#api-response)

### as string with default code and without `data` key:
```php
return api_response('qwerty', 200, [], [], false);
```
return with code 200:
```json
"qwerty"
```

[[ to top ]](#api-response)

### as string with code and without `data` key:
```php
return api_response('qwerty', 400, [], [], false);
```
return with code 400:
```json
{
  "error": {
    "code": 400,
    "data": "qwerty"
  }
}
```

[[ to top ]](#api-response)

### as integer with code and without `data` key:
```php
return api_response(304, 400, [], [], false);
```
return with code 400:
```json
{
  "error": {
    "code": 400,
    "data": 304
  }
}
```

[[ to top ]](#api-response)

### as array and without `data` key:
```php
$data = [
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

#### as error and without `data` key
```php
return api_response($data, 400, [], [], false);
```
return with code 400:
```json
{
  "error": {
    "code": 400,
    "data": [
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

[[ to top ]](#api-response)

#### as success and without `data` key
```php
return api_response($data, 200, [], [], false);
```
return with code 200:
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
    
If the first parameter is a number, then the decryption of the error by code will be return. In other cases, the value of the passed variable will be return.

[[ to top ]](#api-response)

#### with additional content and without `data` key:
```php
return api_response('title', 200, [], ['foo' => 'bar'], false);
```
return with code 200:
```json
{
  "data": "title",
  "foo": "bar"
}
```

return with code 400:
```json
{
  "error": {
    "code": 400,
    "data":"ok"
  },
  "foo": "bar"
}
```


```php
return api_response(['data' => 'foo', 'bar' => 'baz'], 200, [], [], false);
```

return with code 200:
```json
{
  "data": "foo",
  "bar": "baz"
}
```

return with code 400:
```json
{
  "error": {
    "code": 400,
    "data":"foo"
  },
  "bar": "baz"
}
```

[[ to top ]](#api-response)


### Using in Laravel 5+ framework

To use you need to add three methods to the file `app/Exceptions/Handler.php`:

```php
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    public function render($request, Exception $exception)
    {
        $rendered = parent::render($request, $exception);

        return $this->isJson($request)
            ? api_response($rendered->getContent(), $rendered->getStatusCode())
            : $rendered;
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->isJson($request)
            ? api_response(__('errors.401', 401))
            : redirect()->guest(route('login'));
    }
    
    protected function invalidJson($request, ValidationException $exception)
    {
        return api_response($exception->errors(), $exception->status ?: 400);
    }
    
    protected function isJson($request): bool
    {
        return $request->expectsJson() || $request->isJson() || $request->is('api/');
    }
}
```

[[ to top ]](#api-response)


## Copyright and License

`API Response` was written by Andrey Helldar, and is licensed under the [MIT License](LICENSE).

[[ to top ]](#api-response)
