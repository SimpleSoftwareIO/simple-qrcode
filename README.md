Simple QrCode
========================

[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode)
[![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Simple Ideas](#ideas)
- [Usage](#usage)
- [Common QrCode Usage](#common-usage)

<a name="introduction"></a>
## Introduction
Simple QrCode is an easy to use wrapper for the popular Laravel framework based on the great work provided by [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode).  We created an interface that is familiar and easy to install for Laravel users.

<a name="configuration"></a>
## Configuration

#### Composer

First, add the Simple QrCode package to your `require` in your `composer.json` file:

	"require": {
        "simplesoftwareio/simple-qrcode": "0.0.3-beta"
    }
    
Next, run the `composer update -o` command.

#### Service Provider

After that, register the `SimpleSoftwareIO\QrCode\QrCodeServiceProvider` in your `app/conifg/app.cphp` configuration file within the `providers` array.

#### Aliases

Finally, register the `'QrCode' => 'SimpleSoftwareIO\QrCode\Facades\QrCode'` in your `app/config/app.php` configuration file within the `aliases` array.

<a name="ideas"></a>
## Simple Ideas

#### Print View

One of the main items that we use this package for is to have QrCodes in all of our print views.  This allows our customers to return to the original page after it is printed by simply scanning the code.  We achieved this by adding the following into our footer.blade.php file.

    <div class="visible-print text-center">
        {{ QrCode::size(100)->generate(Request::url()); }}
        <p>Scan me to return to the original page.</p>
    </div>

<a name="usage"></a>
## Usage

#### Basic Usage

Using the QrCode Generator is very easy.  The most basic syntax is:

    QrCode::generate('Make me into a QrCode!');

This will make a QrCode that says "Make me into a QrCode!"

#### Generate

`Generate` is used to make the QrCode.

    QrCode::generate('Make me into a QrCode!');

>Heads up! This method must be called last if using within a chain.

`Generate` by default will return a SVG image string.  You can print this directly into a modern browser within Laravel's Blade system with the following:

    {{ QrCode::generate('Make me into a QrCode!'); }}

The `generate` method has a second parameter that will accept a filename and path to save the QrCode.

    QrCode::generate('Make me into a QrCode!', '../public/qrcodes/qrcode.svg');

#### Format Change

>QrCode Generator is setup to return a SVG image by default.

>Watch out! The `format` method must be called before any other formatting options such as `size`, `color`, `backgroundColor`, and `margin`.

Three formats are currently supported; PNG, EPS, and SVG.  To change the format use the following code:

    QrCode::format('png');  //Will return a PNG image
    QrCode::format('eps');  //Will return a EPS image
    QrCode::format('svg');  //Will return a SVG image

#### Size Change

>QrCode Generator will by default return the smallest size possible in pixels to create the QrCode.

You can change the size of a QrCode by using the `size` method. Simply specify the size desired in pixels using the following syntax:

    QrCode::size(100);

#### Color Change

>Be careful when changing the color of a QrCode.  Some readers have a very difficult time reading QrCodes in color.

All colors must be expressed in RGB (Red Green Blue).  You can change the color of a QrCode by using the following:

    QrCode::color(255,0,255);

Background color changes are also supported and be expressed in the same manner.

    QrCode::backgroundColor(255,255,0);

#### Margin Change

The ability to change the margin around a QrCode is also supported.  Simply specify the margin desired in pixels using the following syntax:

    QrCode::margin(100);

#### Error Correction

Changing the level of error correction is easy.  Just use the following syntax:

    QrCode::errorCorrection('H');

The following are supported options for the `errorCorrection` method.

| Error Correction | Assurance Provided |
| --- | --- |
| L | 7% of codewords can be restored. |
| M | 15% of codewords can be restored. |
| Q | 25% of codewords can be restored. |
| H | 30% of codewords can be restored. |

>The more error correction used; the bigger the QrCode becomes and the less data it can store. Read more about [error correction](http://en.wikipedia.org/wiki/QR_code#Error_correction).

#### Advance Usage

All methods support chaining.  The `generate` method must be called last and any `format` change must be called first.  For example you could run any of the following:

    QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Make me a QrCode!');
    QrCode::format('png')->size(399)->color(40,40,40)->generate('Make me a QrCode!');

You can display a PNG image without saving the file by providing a raw string and encoding with `base64_encode`.

    echo '<img src="data:image/png;base64,' . base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) . '" />';

<a name="common-usage"></a>
##Common QrCode Usage

You can use a prefix found in the table below inside the `generate` section to create a QrCode to store more advanced information:

    QrCode::generate('http://www.simplesoftware.io');


| Usage | Prefix | Example |
| --- | --- | --- |
| Website URL | http:// | http://www.simplesoftware.io |
| Secured URL | https:// | https://www.simplesoftware.io |
| E-mail Address | mailto: | mailto:support@simplesoftware.io |
| Phone Number | tel: | tel:555-555-5555 |
| Text (SMS) | sms: | sms:555-555-5555 |
| Text (SMS) With Pretyped Message | smsto: | smsto::I am a pretyped message |
| Text (SMS) With Pretyped Message and Number | smsto: | smsto:555-555-5555:I am a pretyped message |
| Geo Address | geo: | geo:-78.400364,-85.916993 |
| Contact Information | mecard: | MECARD:Simple, Software;Some Address, Somewhere, 20430;TEL:555-555-5555;EMAIL:support@simplesoftware.io; |
| Wifi | wifi: | wifi:WEP/WPA;SSID;PSK;Hidden(True/False) |
