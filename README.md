## Api Response

Package for standardizing the responses from the API of your applications.

![api response](https://user-images.githubusercontent.com/10347617/40197291-b736dece-5a1b-11e8-920e-28721a60999b.png)

<p align="center">
    <a href="https://styleci.io/repos/82566268"><img src="https://styleci.io/repos/82566268/shield" alt="StyleCI" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/api-response"><img src="https://img.shields.io/packagist/dt/andrey-helldar/api-response.svg?style=flat-square" alt="Total Downloads" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/api-response"><img src="https://poser.pugx.org/andrey-helldar/api-response/v/stable?format=flat-square" alt="Latest Stable Version" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/api-response"><img src="https://poser.pugx.org/andrey-helldar/api-response/v/unstable?format=flat-square" alt="Latest Unstable Version" /></a>
    <a href="LICENSE"><img src="https://poser.pugx.org/andrey-helldar/api-response/license?format=flat-square" alt="License" /></a>
</p>


## Installation

To get the latest version of ApiResponse, simply require the project using [Composer](https://getcomposer.org/):

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


## Support Languages

The possibility of the output status in various languages.


## Copyright and License

ApiResponse was written by Andrey Helldar, and is licensed under [The MIT License](LICENSE).


## Translation

Translations of text and comment by Google Translate.

Help with translation +1 in karma :)
