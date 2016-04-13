Simple QrCode
========================

[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode)
[![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)

- [简介](#docs-introduction)
- [翻译](#docs-translations)
- [配置](#docs-configuration)
- [简例](#docs-ideas)
- [使用说明](#docs-usage)
- [辅助用法](#docs-helpers)
- [QrCode 常规用法](#docs-common-usage)
- [在Laravel外的调用方式](#docs-outside-laravel)

<a id="docs-introduction"></a>
## 简介
Simple QrCode 是基于强大的[Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode)库开发的适用于当前最流行的Laravel框架的一个扩展库.便于Laravel用户可以很方便地使用.

<a id="docs-translations"></a>
## 翻译
我们在寻找可以将本文档翻译成韩语或日语的伙伴加入,将本文档翻译成当地语言.愿意翻译的朋友们欢迎pull给我.

<a id="docs-configuration"></a>
## 配置

#### Composer 设置

首先,添加 QrCode 包到你的 `composer.json` 文件的 `require` 里:

	"require": {
		"simplesoftwareio/simple-qrcode": "~1"
	}

然后,运行 `composer update` .

#### 添加 Service Provider

###### Laravel 4
注册 `SimpleSoftwareIO\QrCode\QrCodeServiceProvider` 至 `app/config/app.php` 的 `providers` 数组里.

###### Laravel 5
注册 `SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class` 至 `config/app.php` 的 `providers` 数组里.

#### 添加 Aliases

###### Laravel 4
最后,注册 `'QrCode' => 'SimpleSoftwareIO\QrCode\Facades\QrCode'` 至 `app/config/app.php` 的 `aliases` 数组里.

###### Laravel 5
最后,注册 `'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class` 至 `config/app.php` 的 `aliases` 数组里.

<a id="docs-ideas"></a>
## 简例

#### 打印视图

一个重要的应用是在打印页面添加的来源二维码.这里我们只需要在 footer.blade.php 文件里添加如下代码即可!

	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>Scan me to return to the original page.</p>
	</div>

#### 嵌入二维码

你可以嵌入一个二维码在你的Email里,让收信的用户可以快速扫描.以下是使用 Laravel 实现的一个例子:

	//Inside of a blade template.
	<img src="{!!$message->embedData(QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png')!!}">

<a id="docs-usage"></a>
## 使用说明

#### 基本使用
使用QrCode的Generator非常方便. 多数情况下只要这样:

	QrCode::generate('Make me into a QrCode!');

这就能创建一个内容是:"Make me into a QrCode!" 的二维码了.

#### 生成二维码

`Generate` 是用来创建二维码的方法.

	QrCode::generate('Make me into a QrCode!');

>注意:要创建二维码必须使用此方法

`Generate` 默认返回一个 SVG 格式的图片文本. 你可以在Laravel 的 Blade 系统中把它显示到浏览器中,使用方式如下:

	{!! QrCode::generate('Make me into a QrCode!'); !!}

`generate` 方法的第二个参数是指定要存储图片数据的文件地址.

	QrCode::generate('Make me into a QrCode!', '../public/qrcodes/qrcode.svg');

#### 自己定义输出图片格式

>QrCode Generator 默认输出SVG格式的图片.

>注意! `format` 方法必须第一个被设置, 其它的设置如: `size`, `color`, `backgroundColor`, 和 `margin` 的设置必须在它的后边.

支持 PNG，EPS，SVG 三种格式,设置方式如下:

	QrCode::format('png');  //Will return a PNG image
	QrCode::format('eps');  //Will return a EPS image
	QrCode::format('svg');  //Will return a SVG image

#### 尺寸设置

>QrCode 的 Generator 默认返回可能最小像素单位的二维码.

你可以使用 `size` 方法去设置它的尺寸.下方是设置像素尺寸的实例:

	QrCode::size(100);

#### 颜色设置

>注意改变颜色后,可能会导致某些设备难以识别.

颜色设置的格式必须是RBG格式. 设置方式如下:

	QrCode::color(255,0,255);

设置背景色的方法也是一样的:

	QrCode::backgroundColor(255,255,0);

#### 边距设置

也支持设置边距. 设置方式如下:

	QrCode::margin(100);

#### 容错级别设置

改变二维码的容错级别也很方便.  只要这么设置:

	QrCode::errorCorrection('H');

下方是 `errorCorrection` 方法支持的容错级别设置.

| 容错级别 | 说明 |
| --- | --- |
| L | 7% 的字节码恢复率. |
| M | 15% 的字节码恢复率. |
| Q | 25% 的字节码恢复率. |
| H | 30% 的字节码恢复率. |

>容错级别越高,二维码里能存储的数据越少. 详情见: [error correction](http://en.wikipedia.org/wiki/QR_code#Error_correction).

#### 编码

QrCode 创建二维码时可以使用不同的编码.  默认使用 `ISO-8859-1`.  详情见 [character encoding](http://en.wikipedia.org/wiki/Character_encoding) 你可以使用以下的任一种编码:

	QrCode::encoding('UTF-8')->generate('Make me a QrCode with special symbols ♠♥!!');

| 编码 |
| --- |
| ISO-8859-1 |
| ISO-8859-2 |
| ISO-8859-3 |
| ISO-8859-4 |
| ISO-8859-5 |
| ISO-8859-6 |
| ISO-8859-7 |
| ISO-8859-8 |
| ISO-8859-9 |
| ISO-8859-10 |
| ISO-8859-11 |
| ISO-8859-12 |
| ISO-8859-13 |
| ISO-8859-14 |
| ISO-8859-15 |
| ISO-8859-16 |
| SHIFT-JIS |
| WINDOWS-1250 |
| WINDOWS-1251 |
| WINDOWS-1252 |
| WINDOWS-1256 |
| UTF-16BE |
| UTF-8 |
| ASCII |
| GBK |
| EUC-KR |

> 若抛出 `Could not encode content to ISO-8859-1` 意味着使用了错误的编码.  我们建议你使用 `UTF-8`.

#### 合并

The `merge` method merges an image over a QrCode.  This is commonly used to placed logos within a QrCode.

	QrCode::merge($filename, $percentage, $absolute);

	//Generates a QrCode with an image centered in the middle.
	QrCode::format('png')->merge('path-to-image.png')->generate();

	//Generates a QrCode with an image centered in the middle.  The inserted image takes up 30% of the QrCode.
	QrCode::format('png')->merge('path-to-image.png', .3)->generate();

	//Generates a QrCode with an image centered in the middle.  The inserted image takes up 30% of the QrCode.
	QrCode::format('png')->merge('http://www.google.com/someimage.png', .3, true)->generate();

>The `merge` method only supports PNG at this time.
>The filepath is relative to app base path if `$absolute` is set to `false`.  Change this variable to `true` to use absolute paths.

>You should use a high level of error correction when using the `merge` method to ensure that the QrCode is still readable.  We recommend using `errorCorrection('H')`.

![Merged Logo](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### Merge Binary String

The `mergeString` method can be used to achieve the same as the `merge` call, except it allows you to provide a string representation of the file instead of the filepath. This is usefull when working with the `Storage` facade. It's interface is quite similar to the `merge` call.

	QrCode::mergeString(Storage::get('path/to/image.png'), $percentage);

	//Generates a QrCode with an image centered in the middle.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'))->generate();

	//Generates a QrCode with an image centered in the middle.  The inserted image takes up 30% of the QrCode.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'), .3)->generate();

>As with the normal `merge` call, only PNG is supported at this time. The same applies for error correction, high levels are recommened.

#### Advance Usage

All methods support chaining.  The `generate` method must be called last and any `format` change must be called first.  For example you could run any of the following:

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Make me a QrCode!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('Make me a QrCode!');

You can display a PNG image without saving the file by providing a raw string and encoding with `base64_encode`.

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) !!} ">

<a id="docs-helpers"></a>
## 辅助用法

#### What are helpers?

Helpers are an easy way to create QrCodes that cause a reader to perform a certain action when scanned.

#### E-Mail

This helper generates an e-mail qrcode that is able to fill in the e-mail address, subject, and body.

	QrCode::email($to, $subject, $body);

	//Fills in the to address
	QrCode::email('foo@bar.com');

	//Fills in the to address, subject, and body of an e-mail.
	QrCode::email('foo@bar.com', 'This is the subject.', 'This is the message body.');

	//Fills in just the subject and body of an e-mail.
	QrCode::email(null, 'This is the subject.', 'This is the message body.');

#### Geo

This helper generates a latitude and longitude that a phone can read and open the location up in Google Maps or similar app.

	QrCode::geo($latitude, $longitude);

	QrCode::geo(37.822214, -122.481769);

#### Phone Number

This helper generates a QrCode that can be scanned and then dials a number.

	QrCode::phoneNumber($phoneNumber);

	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');

#### SMS (Text Messages)

This helper makes SMS messages that can be prefilled with the send to address and body of the message.

	QrCode::SMS($phoneNumber, $message);

	//Creates a text message with the number filled in.
	QrCode::SMS('555-555-5555');

	//Creates a text message with the number and message filled in.
	QrCode::SMS('555-555-5555', 'Body of the message');

#### WiFi

This helpers makes scannable QrCodes that can connect a phone to a WiFI network.

	QrCode::wiFi([
		'encryption' => 'WPA/WEP',
		'ssid' => 'SSID of the network',
		'password' => 'Password of the network',
		'hidden' => 'Whether the network is a hidden SSID or not.'
	]);

	//Connects to an open WiFi network.
	QrCode::wiFi([
		'ssid' => 'Network Name',
	]);

	//Connects to an open, hidden WiFi network.
	QrCode::wiFi([
		'ssid' => 'Network Name',
		'hidden' => 'true'
	]);

	//Connects to an secured, WiFi network.
	QrCode::wiFi([
		'ssid' => 'Network Name',
		'encryption' => 'WPA',
		'password' => 'myPassword'
	]);

>WiFi scanning is not currently supported on Apple Products.

<a id="docs-common-usage"></a>
##QrCode 常规用法

You can use a prefix found in the table below inside the `generate` section to create a QrCode to store more advanced information:

	QrCode::generate('http://www.simplesoftware.io');


| Usage | Prefix | Example |
| --- | --- | --- |
| Website URL | http:// | http://www.simplesoftware.io |
| Secured URL | https:// | https://www.simplesoftware.io |
| E-mail Address | mailto: | mailto:support@simplesoftware.io |
| Phone Number | tel: | tel:555-555-5555 |
| Text (SMS) | sms: | sms:555-555-5555 |
| Text (SMS) With Pretyped Message | sms: | sms::I am a pretyped message |
| Text (SMS) With Pretyped Message and Number | sms: | sms:555-555-5555:I am a pretyped message |
| Geo Address | geo: | geo:-78.400364,-85.916993 |
| MeCard | mecard: | MECARD:Simple, Software;Some Address, Somewhere, 20430;TEL:555-555-5555;EMAIL:support@simplesoftware.io; |
| VCard | BEGIN:VCARD | [See Examples](https://en.wikipedia.org/wiki/VCard) |
| Wifi | wifi: | wifi:WEP/WPA;SSID;PSK;Hidden(True/False) |

<a id="docs-outside-laravel"></a>
##在Laravel外的调用方式

You may use this package outside of Laravel by instantiating a new `BaconQrCodeGenerator` class.

	use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

	$qrcode = new BaconQrCodeGenerator;
	$qrcode->size(500)->generate('Make a qrcode without Laravel!');
