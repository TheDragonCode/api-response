# API Response

<img src="https://preview.dragon-code.pro/TheDragonCode/api-response.svg?brand=php" alt="API Response"/>

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]

> Package for standardizing the responses from the API of your **Symfony based** applications.

## Getting Started

### Upgrade guides

* [To 9.x From 8.x and from the `andrey-helldar/api-response` package](.upgrading/8.x_9.x.md)
* [To 8.x From 7.x](.upgrading/7.x_8.x.md)
* [To 7.x From 6.x](.upgrading/6.x_7.x.md)
* [To 6.x From 5.x](.upgrading/5.x_6.x.md)

[[ to top ]](#api-response)


### Installation

To get the latest version of `API Response`, simply require the project using [Composer](https://getcomposer.org/):

```bash
$ composer require dragon-code/api-response
```

This command will automatically install the latest version of the package for your environment.

Instead, you may of course manually update your `require` block and run `composer update` if you so choose:

```json
{
    "require": {
        "dragon-code/api-response": "^9.1"
    }
}
```

Alright! Use `api_response()` helper.


### Compatibility table

| Package version | PHP min version | Symfony version  | Support                               | Links                                  |
|:---------------:|:---------------:|:----------------:|:--------------------------------------|:---------------------------------------|
|      ^9.0       |      7.2.5      | ^4.0, ^5.0, ^6.0 | ![Supported][badge_supported]         | [Upgrade guide](.upgrading/8.x_9.x.md) |
|      ^8.0       |      7.2.5      |    ^4.0, ^5.0    | ![Not Supported][badge_not_supported] | [Upgrade guide](.upgrading/7.x_8.x.md) |
|      ^7.0       |      7.2.5      |    ^4.0, ^5.0    | ![Not Supported][badge_not_supported] | [Upgrade guide](.upgrading/6.x_7.x.md) |
|      ^6.0       |       7.3       |    ^4.0, ^5.0    | ![Not Supported][badge_not_supported] | [Upgrade guide](.upgrading/5.x_6.x.md) |
|      ^5.0       |      7.1.3      |    ^4.0, ^5.0    | ![Not Supported][badge_not_supported] | ---                                    |
|     ^4.4.1      |      5.6.9      | ^3.0, ^4.0, ^5.0 | ![Not Supported][badge_not_supported] | ---                                    |
|      ^4.0       |      5.6.9      |    ^3.0, ^4.0    | ![Not Supported][badge_not_supported] | ---                                    |

[[ to top ]](#api-response)


## Using

### Use with `data` key

#### as NULL with code:

```php
// php 7.4 and below
return api_response(null, 304);

// php 8.0
return api_response( status_code: 304 );
```

return with code 304:

```json
{
    "data": null
}
```

[[ to top ]](#api-response)

#### as integer with default code:

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

#### as string with default code:

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

#### as string with code:

```php
return api_response('qwerty', 400);
```

return with code 400:

```json
{
    "error": {
        "type": "Exception",
        "data": "qwerty"
    }
}
```

[[ to top ]](#api-response)

#### as integer with code:

```php
return api_response(304, 400);
```

return with code 400:

```json
{
    "error": {
        "type": "Exception",
        "data": 304
    }
}
```

[[ to top ]](#api-response)

#### as array:

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
        "type": "Exception",
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
return api_response($data);
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

#### with additional content

```php
// php 7.4 and below
return api_response('title', 200, ['foo' => 'bar']);
// or
return api_response('title', null, ['foo' => 'bar']);

// php 8.0
return api_response('title', with: ['foo' => 'bar']);
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
        "type": "Exception",
        "data": "ok"
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
        "type": "Exception",
        "data": "foo"
    },
    "bar": "baz"
}
```

[[ to top ]](#api-response)


### Use without `data` key

Since the goal of the package is to unify all the answers, we moved the variable definitions into a static function. So, for example, to enable or disable wrapping content in
the `data` key, you need to call the `wrapped` or `withoutWrap` method:

```php
use DragonCode\ApiResponse\Services\Response;

Response::withoutWrap();
```

#### as NULL with code and without `data` key:

```php
// php 7.4 and below
return api_response(null, 304);

// php 8.0
return api_response( status_code: 304 );
```

return with code 304:

```json
[]
```

[[ to top ]](#api-response)

#### as integer with default code and without `data` key:

```php
return api_response(304, 200);
```

return with code 200:

```json
304
```

[[ to top ]](#api-response)

#### as string with default code and without `data` key:

```php
return api_response('qwerty', 200);
```

return with code 200:

```json
"qwerty"
```

[[ to top ]](#api-response)

#### as string with code and without `data` key:

```php
return api_response('qwerty', 400);
```

return with code 400:

```json
{
    "error": {
        "type": "Exception",
        "data": "qwerty"
    }
}
```

[[ to top ]](#api-response)

#### as integer with code and without `data` key:

```php
return api_response(304, 400);
```

return with code 400:

```json
{
    "error": {
        "type": "Exception",
        "data": 304
    }
}
```

[[ to top ]](#api-response)

#### as array and without `data` key:

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
return api_response($data, 400);
```

return with code 400:

```json
{
    "error": {
        "type": "Exception",
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
return api_response($data, 200);
// or
return api_response($data);
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
// php 7.4 and below
return api_response('title', 200, ['foo' => 'bar']);

// php 8.0
return api_response('title', with: ['foo' => 'bar']);
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
        "type": "Exception",
        "data": "ok"
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
        "type": "Exception",
        "data": "foo"
    },
    "bar": "baz"
}
```

[[ to top ]](#api-response)


### No extra data

In some cases, when returning answers, you must also give additional data. Such as stack trace, for example.

To prevent this data from getting in response to production, you can globally set a label to show or hide this data:

```php
use DragonCode\ApiResponse\Services\Response;

env('APP_DEBUG')
    ? Response::allowWith()
    : Response::withoutWith();
```

Now all responses will not contain the additional data being passed.

For example:

```php
// php 7.4 and below
return api_response('title', 200, ['foo' => 'bar']);
// or
return api_response('title', null, ['foo' => 'bar']);

// php 8.0
return api_response('title', with: ['foo' => 'bar']);
```

return with code 200:

```json
{
    "data": "title"
}
```

return with code 400:

```json
{
    "error": {
        "type": "Exception",
        "data": "ok"
    }
}
```

#### Server Errors

> Note: The `$with` parameter is also responsible for displaying server-side error messages.
>
> In this case, Http errors will be displayed without masking.

For example:

```php
use DragonCode\ApiResponse\Services\Response;

Response::allowWith();

$e = new Exception('Foo', 0);

return api_response($e);
```

return with code 500:

```json
{
    "error": {
        "type": "Exception",
        "data": "Foo"
    }
}
```

and

```php
use DragonCode\ApiResponse\Services\Response;

Response::withoutWith();

$e = new Exception('Foo', 0);

return api_response($e);
```

return with code 500:

```json
{
    "error": {
        "type": "Exception",
        "data": "Whoops! Something went wrong."
    }
}
```

return with if code >=400 and < 500:

```json
{
    "error": {
        "type": "Exception",
        "data": "Foo"
    }
}
```

[[ to top ]](#api-response)


### Returning exception instances

```php
class FooException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Foo', 405);
    }
}

class BarException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Bar');
    }
}

$foo = new FooException();
$bar = new BarException();
```

```php
return api_response($foo);
```

return with code 405:

```json
{
    "error": {
        "type": "FooException",
        "data": "Foo"
    }
}
```

```php
return api_response($foo, 408);
```

return with code 408:

```json
{
    "error": {
        "type": "FooException",
        "data": "Foo"
    }
}
```

```php
return api_response($bar);
```

return with code 400:

```json
{
    "error": {
        "type": "BarException",
        "data": "Bar"
    }
}
```

```php
return api_response($bar, 408);
```

return with code 408:

```json
{
    "error": {
        "type": "BarException",
        "data": "Bar"
    }
}
```

You can also add additional data:

```php
return api_response($foo, 405, ['foo' => 'Bar']);
// or
return api_response($foo, 0, ['foo' => 'Bar']);
```

return with code 405:

```json
{
    "error": {
        "type": "FooException",
        "data": "Foo"
    },
    "foo": "Bar"
}
```

[[ to top ]](#api-response)


### Best practice use with the Laravel and Lumen Frameworks

If you use the Laravel or Lumen framework, you can update the `extends` in the `app\Exceptions\Handler.php` file depending on your application version and needs:

| Version \ Type | API + WEB                                                                     | Only API                                                                         |
|:--------------:|:------------------------------------------------------------------------------|:---------------------------------------------------------------------------------|
|      9.x       | `DragonCode\ApiResponse\Exceptions\Laravel\Nine\Handler as ExceptionHandler`  | `DragonCode\ApiResponse\Exceptions\Laravel\Nine\ApiHandler as ExceptionHandler`  |
|      8.x       | `DragonCode\ApiResponse\Exceptions\Laravel\Eight\Handler as ExceptionHandler` | `DragonCode\ApiResponse\Exceptions\Laravel\Eight\ApiHandler as ExceptionHandler` |
|      7.x       | `DragonCode\ApiResponse\Exceptions\Laravel\Seven\Handler as ExceptionHandler` | `DragonCode\ApiResponse\Exceptions\Laravel\Seven\ApiHandler as ExceptionHandler` |

If you did not add anything to this file, then delete everything properties and methods.

For example, as a result, a clean file will look like this:

```php
<?php

namespace App\Exceptions;

use DragonCode\ApiResponse\Exceptions\Laravel\Nine\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    //
}
```

More examples:

```php
<?php

namespace App\Exceptions;

// use DragonCode\ApiResponse\Exceptions\Laravel\Nine\Handler as ExceptionHandler;
use DragonCode\ApiResponse\Exceptions\Laravel\Nine\ApiHandler as ExceptionHandler;

// use DragonCode\ApiResponse\Exceptions\Laravel\Eight\Handler as ExceptionHandler;
// use DragonCode\ApiResponse\Exceptions\Laravel\Eight\ApiHandler as ExceptionHandler;

// use DragonCode\ApiResponse\Exceptions\Laravel\Seven\Handler as ExceptionHandler;
// use DragonCode\ApiResponse\Exceptions\Laravel\Seven\ApiHandler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    //
}
```

[[ to top ]](#api-response)


#### Json Resources

Now, if you pass a resource object or validator object, it will also be rendered beautifully:

```php
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Tests\Fixtures\Laravel\Model */
final class Resource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'foo' => $this->foo,
            'bar' => $this->bar,
        ];
    }

    public function with($request)
    {
        return ['baz' => 'Baz'];
    }
}
```

```php
$model = Model::first();
$resource = MyResource::make($model);

return api_response($resource);
```

return with code 200:

```json
{
    "data": {
        "foo": "Foo",
        "bar": "Bar"
    },
    "baz": "Baz"
}
```

If `Response::withoutWrap()`

```json
{
    "foo": "Foo",
    "bar": "Bar",
    "baz": "Baz"
}
```

If `Response::withoutWith()`

```json
{
    "data": {
        "foo": "Foo",
        "bar": "Bar"
    }
}
```

If `Response::withoutWith()` and `Response::withoutWrap()`

```json
{
    "foo": "Foo",
    "bar": "Bar"
}
```

[[ to top ]](#api-response)


#### Validation

```php
$data = [
    'foo' => 'Foo',
    'bar' => 123,
    'baz' => 'https://foo.example'
];

$rules = [
    'foo' => ['required'],
    'bar' => ['integer'],
    'baz' => ['sometimes', 'url'],
];
```

```php
$validator = Validator::make($data, $rules);

return $validator->fails()
    ? new ValidationException($validator)
    : $validator->validated();
```

If success:

```json
{
    "data": {
        "foo": "Foo",
        "bar": 123,
        "baz": "https://foo.example"
    }
}
```

If failed:

```json
{
    "error": {
        "type": "ValidationException",
        "data": {
            "foo": ["The foo field is required."],
            "bar": ["The bar must be an integer."],
            "baz": ["The baz format is invalid."]
        }
    }
}
```

[[ to top ]](#api-response)


## License

This package is licensed under the [MIT License](LICENSE).

[[ to top ]](#api-response)


[badge_build]:          https://img.shields.io/github/workflow/status/TheDragonCode/api-response/coverage?style=flat-square

[badge_coverage]:       https://img.shields.io/scrutinizer/coverage/g/dragon-code/api-response.svg?style=flat-square

[badge_downloads]:      https://img.shields.io/packagist/dt/dragon-code/api-response.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/dragon-code/api-response.svg?style=flat-square

[badge_not_supported]:  https://img.shields.io/badge/not--supported-lightgrey?style=flat-square

[badge_quality]:        https://img.shields.io/scrutinizer/g/dragon-code/api-response.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/TheDragonCode/api-response?label=stable&style=flat-square

[badge_supported]:      https://img.shields.io/badge/supported-green?style=flat-square

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_build]:           https://github.com/TheDragonCode/api-response/actions

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/dragon-code/api-response

[link_scrutinizer]:     https://scrutinizer-ci.com/g/dragon-code/api-response
