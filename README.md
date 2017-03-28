## ApiResponse for Laravel 5.3+

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


## Installation

To get the latest version of ApiResponse, simply require the project using [Composer](https://getcomposer.org/):

```bash
$ composer require andrey-helldar/api-response
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "andrey-helldar/api-response": "^1.0"
    }
}
```

Once Laravel ApiResponse is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

* `Helldar\ApiResponse\ApiResponseServiceProvider::class,`

Alright! Use `api_response()` helper.


## Documentation

    return api_response(200);
    // return {"response": "OK"} with code 200
    
    return api_response(0, 'qwerty', 200);
    // return {"response":"qwerty"} with code 200
    
    return api_response(0, 'qwerty', 400);
    // return {"error":{"error_code":400,"error_msg":"qwerty"}} with code 400
    
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
    return api_response(0, $content, 400);
    // {"error":{"error_code":0,"error_msg":[{"title":"Title #1","description":"Description #1"},{"title":"Title #2","description":"Description #2"}]}}
    
    return api_response(0, $content, 200);
    // {"response":[{"title":"Title #1","description":"Description #1"},{"title":"Title #2","description":"Description #2"}]}
    
This package using "response()->json()" helper from Laravel Framework.


## Support Languages

The possibility of the output status in various languages.


## Support Package

You can donate via [PayPal](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=94B8LCPAPJ5VG), [Yandex Money](https://money.yandex.ru/quickpay/shop-widget?account=410012608840929&quickpay=shop&payment-type-choice=on&mobile-payment-type-choice=on&writer=seller&targets=Andrey+Helldar%3A+Open+Source+Projects&targets-hint=&default-sum=&button-text=04&mail=on&successURL=), WebMoney (Z124862854284, R343524258966) and [Patreon](https://www.patreon.com/helldar)


## Copyright and License

ApiResponse was written by Andrey Helldar for the Laravel framework 5.3 or later, and is licensed under [The MIT License (MIT)](LICENSE).


## Translation

Translations of text and comment by Google Translate.

Help with translation +1 in karma :)
