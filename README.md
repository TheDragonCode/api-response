## ApiResponse for Laravel 5.5+

Package for standardizing the responses from the API of your applications.

![api response](https://cloud.githubusercontent.com/assets/10347617/23128374/0f02ede0-f7c2-11e6-8b9a-a7d0d265859b.jpg)

<p align="center">
<a href="https://travis-ci.org/andrey-helldar/api-response"><img src="https://travis-ci.org/andrey-helldar/api-response.svg?branch=master&style=flat-square" alt="Build Status" /></a>
<a href="https://packagist.org/packages/andrey-helldar/api-response"><img src="https://img.shields.io/packagist/dt/andrey-helldar/api-response.svg?style=flat-square" alt="Total Downloads" /></a>
<a href="https://packagist.org/packages/andrey-helldar/api-response"><img src="https://poser.pugx.org/andrey-helldar/api-response/v/stable?format=flat-square" alt="Latest Stable Version" /></a>
<a href="https://packagist.org/packages/andrey-helldar/api-response"><img src="https://poser.pugx.org/andrey-helldar/api-response/v/unstable?format=flat-square" alt="Latest Unstable Version" /></a>
<a href="https://github.com/andrey-helldar/api-response"><img src="https://poser.pugx.org/andrey-helldar/api-response/license?format=flat-square" alt="License" /></a>
</p>


<p align="center">
<a href="https://github.com/andrey-helldar/api-response"><img src="https://img.shields.io/scrutinizer/g/andrey-helldar/api-response.svg?style=flat-square" alt="Quality Score" /></a>
<a href="https://styleci.io/repos/82566268"><img src="https://styleci.io/repos/82566268/shield" alt="StyleCI" /></a>
<a href="https://php-eye.com/package/andrey-helldar/api-response"><img src="https://php-eye.com/badge/andrey-helldar/api-response/tested.svg?style=flat-square" alt="PHP-Eye" /></a>
</p>

#### For **Laravel <= 5.4** use [v2.x](https://github.com/andrey-helldar/api-response/tree/v2.x) version.

## Installation

To get the latest version of ApiResponse, simply require the project using [Composer](https://getcomposer.org/):

```bash
$ composer require andrey-helldar/api-response
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "andrey-helldar/api-response": "^3.0"
    }
}
```

If you don't use auto-discovery, add the ServiceProvider to the providers array in `config/app.php`:

* `Helldar\ApiResponse\ServiceProvider::class,`

Next, call `php artisan vendor:publish`.

Alright! Use `api_response()` helper.


## Documentation

    return api_response(null, 304);
    // return {null} with code 304

    return api_response(304);
    // return {"Not Modified"} with code 200

    return api_response('qwerty');
    // return {"qwerty"} with code 200
    
    return api_response('qwerty', 400);
    // return {"error":{"code":400,"msg":"qwerty"}} with code 400
    
    return api_response(304, 400);
    // return {"Not Modified"} with code 400
    
    $content = array(
        array(
            'title' => 'Title #1',
            'description' => 'Description #1',
        ),
        array(
            'title' => 'Title #2',
            'description' => 'Description #2',
        ),
    );
    return api_response($content, 400);
    // {"error":{"code":0,"msg":[{"title":"Title #1","description":"Description #1"},{"title":"Title #2","description":"Description #2"}]}}
    
    return api_response($content, 200);
    // {[{"title":"Title #1","description":"Description #1"},{"title":"Title #2","description":"Description #2"}]}
    
If the first parameter is a number, then the decryption of the error by code will be returned. In other cases, the value of the passed variable will be returned.


## Support Languages

The possibility of the output status in various languages.


## Copyright and License

ApiResponse was written by Andrey Helldar for the Laravel framework 5.5 or later, and is licensed under [The MIT License](LICENSE).


## Translation

Translations of text and comment by Google Translate.

Help with translation +1 in karma :)
