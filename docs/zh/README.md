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

首先,添加 QrCode 包添加到你的 `composer.json` 文件的 `require` 里:

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

#### 加LOGO图

 `merge` 方法可以让QrCode为生成结果加上LOGO图片.  下方是常见的为二维码加LOGO图片的使用方式.

	QrCode::merge($filename, $percentage, $absolute);

	//生成一个中间有LOGO图片的二维码
	QrCode::format('png')->merge('path-to-image.png')->generate();

	//生成一个中间有LOGO图片的二维码,且LOGO图片占整个二维码图片的30%.
	QrCode::format('png')->merge('path-to-image.png', .3)->generate();

	//使用绝对路径的LOGO图片地址创建二维码,LOGO图片占整个二维码图片的30%.
	QrCode::format('png')->merge('http://www.google.com/someimage.png', .3, true)->generate();

> `merge` 方法当前只支持PNG格式的图片
> 默认使用相对于应用程序的根路径,把第三个参数设置为 `true` 就能切换到使用绝对路径

> 为了让二维码保持高可识别度,建议在使用 `merge` 方法时把二维码的容错级别提高. 我们默认使用: `errorCorrection('H')`.

![Merged Logo](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### 加二进制LOGO图片

 `mergeString` 方法与 `merge` 方法类似, 不同的是它允许你使用一个二进制的String代替LOGO文件路径. 这在使用 `Storage` 存储时,会显得很方便. 它的参数与 `merge` 类似.

	QrCode::mergeString(Storage::get('path/to/image.png'), $percentage);

	//使用中间件读取的图片数据作为LOGO图片来创建二维码.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'))->generate();

	//使用中间件读取的图片数据作为LOGO图片来创建二维码, 且LOGO图片占整个二维码图片的30%.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'), .3)->generate();

> 和 `merge` 方法一样,当前只支持PNG格式. 同样建议将二维码的容错级别提高.

#### 高级用法

所有的方法都支持连贯操作.  `generate` 方法必须在最后 `format` 必须在第一个.  例如:

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Make me a QrCode!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('Make me a QrCode!');

你还能不存储图片,而使用 `base64_encode` 来将二进制数据直接显示成二维码图片.

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) !!} ">

<a id="docs-helpers"></a>
## 辅助用法

#### 什么是辅助方法?

辅助方法是为了便于开发者在常见的二维码使用场景中更高效地使用本库.

#### E-Mail

这个辅助方法可以生成一个直接发E-mail的二维码.包含了发邮件的地址,标题,和内容

	QrCode::email($to, $subject, $body);

	//加入一个邮件地址
	QrCode::email('foo@bar.com');

	//加一个邮件地址、标题、内容至二维码.
	QrCode::email('foo@bar.com', 'This is the subject.', 'This is the message body.');

	//只加标题和内容.
	QrCode::email(null, 'This is the subject.', 'This is the message body.');

#### 位置

这个辅助方法能创建一个包含一个经纬度的位置二维码.

	QrCode::geo($latitude, $longitude);

	QrCode::geo(37.822214, -122.481769);

#### 手机号

这个辅助方法能创建一个包含自己手机号的二维码.

	QrCode::phoneNumber($phoneNumber);

	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');

#### 短信

这个辅助方法能创建能创建一个包含发送短信目标手机号和内容的二维码.

	QrCode::SMS($phoneNumber, $message);

	//创建一个只有手机号的短信二维码.
	QrCode::SMS('555-555-5555');

	//创建一个包含手机号和文字内容的短信二维码.
	QrCode::SMS('555-555-5555', 'Body of the message');

#### WIFI

这个辅助方法能创建扫一下能连接WIFI的二维码.

	QrCode::wiFi([
		'encryption' => 'WPA/WEP',
		'ssid' => '网络的SSID',
		'password' => '网络的密码',
		'hidden' => '是否是一个隐藏SSID的网络'
	]);

	//连接一个开放的网络
	QrCode::wiFi([
		'ssid' => '网络名称',
	]);

	//连接一个开放并隐藏的网络.
	QrCode::wiFi([
		'ssid' => '网络名称',
		'hidden' => 'true'
	]);

	//连接一个加密的WIFI网络.
	QrCode::wiFi([
		'ssid' => '网络名称',
		'encryption' => 'WPA',
		'password' => '密码'
	]);

> WIFI扫描目前不支持在苹果产品。

<a id="docs-common-usage"></a>
##QrCode 常规用法

你还能通过下面表中的前缀信息创建适合更多场合的二维码

	QrCode::generate('http://www.simplesoftware.io');


| 使用场景 | 前缀 | 例子 |
| --- | --- | --- |
| 网址 | http:// | http://www.simplesoftware.io |
| 加密网址 | https:// | https://www.simplesoftware.io |
| E-mail 地址 | mailto: | mailto:support@simplesoftware.io |
| 电话号码 | tel: | tel:555-555-5555 |
| 文字短信 | sms: | sms:555-555-5555 |
| 文字短信内容 | sms: | sms::I am a pretyped message |
| 文字短信同时附带手机号和短信内容 | sms: | sms:555-555-5555:I am a pretyped message |
| 坐标 | geo: | geo:-78.400364,-85.916993 |
| MeCard名片 | mecard: | MECARD:Simple, Software;Some Address, Somewhere, 20430;TEL:555-555-5555;EMAIL:support@simplesoftware.io; |
| VCard名片 | BEGIN:VCARD | [See Examples](https://en.wikipedia.org/wiki/VCard) |
| Wifi | wifi: | wifi:WEP/WPA;SSID;PSK;Hidden(True/False) |

<a id="docs-outside-laravel"></a>
##在Laravel外的调用方式

你还可以在Laravel框架之外调用,只需要实例化 `BaconQrCodeGenerator` 类.

	use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

	$qrcode = new BaconQrCodeGenerator;
	$qrcode->size(500)->generate('Make a qrcode without Laravel!');
