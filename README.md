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
<a href="https://www.versioneye.com/php/andrey-helldar:api-response/dev-master"><img src="https://www.versioneye.com/php/andrey-helldar:api-response/dev-master/badge?style=flat-square" alt="Dependency Status" /></a>
<a href="https://styleci.io/repos/82566268"><img src="https://styleci.io/repos/82566268/shield" alt="StyleCI" /></a>
<a href="https://php-eye.com/package/andrey-helldar/api-response"><img src="https://php-eye.com/badge/andrey-helldar/api-response/tested.svg?style=flat" alt="PHP-Eye" /></a>
</p>


## Installation

1. Run command in console:

        composer require andrey-helldar/api-response

2. Use `api_response()` helper.

3. Profit!


## Documentation

    return api_response(0, 'qwerty', 200);
    // return {"response":"qwerty"} with code 200
    
    return api_response(0, 'qwerty', 400);
    // return {"response":"qwerty"} with code 400
    
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
    
This package using "response()" helper from Laravel Framework. 


## Support Languages

The possibility of the output status in various languages.


## Support Package

You can donate via [PayPal](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=94B8LCPAPJ5VG), [Yandex Money](https://money.yandex.ru/quickpay/shop-widget?account=410012608840929&quickpay=shop&payment-type-choice=on&mobile-payment-type-choice=on&writer=seller&targets=Andrey+Helldar%3A+Open+Source+Projects&targets-hint=&default-sum=&button-text=04&mail=on&successURL=), WebMoney (Z124862854284, R343524258966) and [Patreon](https://www.patreon.com/helldar)

## Copyright and License

ApiResponse was written by Andrey Helldar for the Laravel framework 5.3 or later, and is released under the MIT License. See the LICENSE file for details.

## Translation

Translations of text and comment by Google Translate.

Help with translation +1 in karma :)
