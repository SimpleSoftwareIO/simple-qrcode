Simple QrCode
========================

- [Introduction](#introduction)
- [Simple Ideas](#ideas)
- [Configuration](#configuration)
- [Usage](#usage)
- [Common QrCode Usage](#common-usage)

<a name="introduction"></a>
## Introduction
Simple QrCode is an easy to use wrapper for the popular Laravel framework based on the great work provided by [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode).  We created an interface that is familiar and easy to install for Laravel users.

<a name="configuration"></a>
## Configuration

#### Composer

First, add the Simple QrCode package to your `composer.json` file:

	"simplesoftwareio/simple-qrcode": "dev-master"
    
Then run `composer update` command.

#### Service Provider

Next, register the `SimpleSoftwareIO\QrCode\QrCodeServiceProvider` in your `app` configuration file within the `providers` array.

#### Aliases

Then, register the `'QrCode' => 'SimpleSoftwareIO\QrCode\Facades\QrCode'` in your `app` configuration file within the `aliases` array.

<a name="usage"></a>
## Simple Ideas

#### Print View

One of the main items that we use this package for is to have QrCodes in all of our print views.  This allows our customers to return to the visited page after it is printed by simply scanning the code.  We achieve this by adding the following into our footer.blade.php file.

    <div class="visible-print text-center">
        {{ QrCode::size(100)->generate(Request::url()); }}
        <p>Scan me to return to the original page.</p>
    </div>

<a name="usage"></a>
## Usage

#### Basic Usage

Using the QrCode Generator is very easy.  The most basic syntax is:

    QrCode::generator('Make me into a QrCode!');

This will make a QrCode that says "Make me into a QrCode!"

#### Format Change

>QrCode Generator is setup to return a SVG image by default.

>The `format` method must be called before any other formatting options such as Size, Color, and ColorChange.

Three formats are currently supported; PNG, EPS, and SVG.  To change the format use the following code:

    QrCode::format('png');  //Will return a PNG image
    QrCode::format('eps');  //Will return a EPS image
    QrCode::format('svg');  //Will return a SVG image

#### Size Change

>QrCode Generator will by default return the smallest size possible in pixels to create the QrCode.

You can change the size of a QrCode by using the `size` method.  Simply use the following code:

    QrCode::size(100);

The size should be expressed in pixels.

#### Color Change

>Be careful when changing the color of a QrCode.  Some readers have a very difficult time reading QrCodes in color.

All colors must be expressed in RGB (Red Green Blue).  You can change the color of a QrCode by using the following:

    QrCode::color(255,255,255);

Background color changes are also supported and be expressed in the same manner.

    QrCode::backgroundColor(255,255,255);

#### Error Correction

Changing the level of error correction is easy.  Just use the following syntax:

    QrCode::errorCorrection('H');

The following are supported options for the `errorCorrection` method.

| Error Correction | Assurance Provided |
| --- | --- |
| L | 7% |
| M | 15% |
| Q | 25% |
| H | 30% |

>The more error correction used; the bigger the QrCode becomes.  Mobile phones usually can only support QrCode of version 4 or below. Read more about the [format](http://en.wikipedia.org/wiki/QR_code#Storage).

#### Margin Change

The ability to change the margin around a QrCode is also supported.  Simply specify the margin desired in pixels using the following syntax:

    QrCode::margin(100);

#### Advance Usage

All methods support chaining.  The `generate` method must be called last.  For example you could run any of the following:

    QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Make me a QrCode!');
    QrCode::format('png')->size(399)->color(40,40,40)->generate('Make me a QrCode!');

<a name="common-usage"></a>
##Common QrCode Usage

The following is a table of some common uses of QrCodes.

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