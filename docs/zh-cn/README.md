[![构建状态](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode) [![最新稳定版本](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![最新版本](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![许可](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![下载量](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)


- [介绍](#docs-introduction)
- [升级指南](#docs-upgrade)
- [配置](#docs-configuration)
- [简例](#docs-ideas)
- [使用说明](#docs-usage)
- [助手模板](#docs-helpers)
- [QrCode 常规用法](#docs-common-usage)
- [在Laravel外的调用方式](#docs-outside-laravel)

<a id="docs-introduction"></a>
## 介绍
Simple QrCode 是基于[Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode) 开发，适用于Laravel框架的软件包. 我们的目的是让二维码能更加便捷的使用在Laravel框架的项目里.

![Example 1](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/example-1.png?raw=true) ![Example 2](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/example-2.png?raw=true)

<a id="docs-upgrade"></a>
## 升级指南

从v2版本升到v3需要将 `composer.json` 文件中版本改为 `~3`

如果你需要使用 `png` 文件格式，那么你**必须**安装 `imagick` PHP扩展.

<a id="docs-configuration"></a>
## 配置

#### Composer安装

使用 `composer require simplesoftwareio/simple-qrcode "~3"` 安装软件包，

Laravel将会自动完成安装工作.

#### 添加 Service Provider

###### Laravel <= 5.4
注册 `SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class` 至 `config/app.php` 的 `providers` 数组里.

#### 添加 Aliases

###### Laravel <= 5.4
最后,注册 `'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class` 至 `config/app.php` 的 `aliases` 数组里.

<a id="docs-ideas"></a>
## 简例

#### 显示视图

一个重要的应用是在页面中添加来源二维码.这样我们的用户就可以通过扫码返回初始页.我们只需要在 footer.blade.php 文件里添加如下代码即可!

	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>扫我返回初始页</p>
	</div>

#### 嵌入二维码

你也可以嵌入二维码在你的邮件中，让收信的用户可以快速扫描.以下是在Laravel中实现的例子:

	//Inside of a blade template.
	<img src="{!!$message->embedData(QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png')!!}">

<a id="docs-usage"></a>
## 使用说明

#### 基本使用
使用QrCode的Generator非常方便. 多数情况下只要这样:

	QrCode::generate('Make me into a QrCode!');

这就能创建一个内容是:"Make me into a QrCode!" 的二维码了.

#### 生成 `generate(string $data, string $filename = null)`

`Generate` 是用来创建二维码的方法.

	QrCode::generate('Make me into a QrCode!');

>注意:要创建二维码必须使用此方法

`Generate` 默认返回一个 SVG 格式的图片文本. 你可以直接在Laravel 的 Blade页面 中使用,使用方式如下:

	{!! QrCode::generate('Make me into a QrCode!'); !!}

`generate` 方法的第二个参数是指定要存储图片数据的文件地址及命名.

	QrCode::generate('Make me into a QrCode!', '../public/qrcodes/qrcode.svg');

#### 格式  `format(string $format)`

现支持 PNG，EPS，SVG 三种格式,设置方式如下:

	QrCode::format('png');  //放回PNG图片
	QrCode::format('eps');  //放回EPS图片
	QrCode::format('svg');  //放回SVG图片

> 必须 `imagick` PHP扩展才能生成 `png` 图片.

#### 尺寸 `size(int $size)`

>QrCode 的 Generator 默认返回可能最小像素单位的二维码.

你可以使用 `size` 方法来设置二维码尺寸.下方是设置像素尺寸的方法:

	QrCode::size(100);

![200 像素](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/200-pixels.png?raw=true) ![250 像素](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/250-pixels.png?raw=true)

#### 颜色  `color(int $red, int $green, int $blue, int $alpha = null)`

>注意改变颜色后,可能会导致某些设备难以识别.

颜色设置的格式必须是RGBA格式. 设置方式如下:

QrCode::color(255, 0, 0); // 红色二维码
QrCode::color(255, 0, 0, 25); //红色二维码+25%透明度

![红色二维码](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-qrcode.png?raw=true) ![红色透明二维码](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-25-transparent.png?raw=true)


#### 背景颜色 `backgroundColor(int $red, int $green, int $blue, int $alpha = null)`

你可以使用`backgroundColor` 方法来设置背景颜色.

	QrCode::backgroundColor(255, 0, 0); // 红色背景二维码
	QrCode::backgroundColor(255, 0, 0, 25); // 红色25%透明背景二维码

![红色背景二维码](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-background.png?raw=true) ![红色透明背景二维码](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-25-transparent-background.png?raw=true)

#### 渐变 `gradient($startRed, $startGreen, $startBlue, $endRed, $endGreen, $endBlue, string $type)`

你可以使用 `gradient` 方法设置渐变.

支持以下渐变类型:

| 类型 | 范例 |
| --- | --- |
| `vertical`垂直 | ![垂直](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/vertical.png?raw=true) |
| `horizontal`水平 | ![水平](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/horizontal.png?raw=true) |
| `diagonal`对角 | ![对角](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/diagonal.png?raw=true) |
| `inverse_diagonal`反对角 | ![反对角](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/inverse_diagonal.png?raw=true) |
| `radial`迳向 | ![迳向](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/radial.png?raw=true) |

#### 定位颜色 `eyeColor(int $eyeNumber, int $innerRed, int $innerGreen, int $innerBlue, int $outterRed = 0, int $outterGreen = 0, int $outterBlue = 0)`

你可以使用 `eyeColor` 方法设置定位眼颜色.

| 数量 | 范例 |
| --- | --- |
| `0` | ![Eye 0](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/eye-0.png?raw=true) |
| `1` | ![Eye 1](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/eye-1.png?raw=true)|
| `2` | ![Eye 2](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/eye-2.png?raw=true) |

#### 风格 `style(string $style, float $size = 0.5)`

二维码风格可以轻易的使用 `square`, `dot` 或 `round`来调换. 这将改变二维码中的信息块风格. 第二个参数是设置dot'点'的大小和round的圆度.

| 风格 | 范例 |
| --- | --- |
| `sqaure`方 | ![方](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/200-pixels.png?raw=true) |
| `dot`点 | ![点](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/dot.png)|
| `round`圆 | ![圆](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/round.png?raw=true) |

#### 定位眼风格 `eyeStyle(string $style)`

二维码定位眼支持2个格式, `sqaure`方 和 `circle`圆.

| 风格 | 范例 |
| --- | --- |
| `sqaure`方 | ![方](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/200-pixels.png?raw=true) |
| `circle`圆 | ![圆](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/circle-eye.png?raw=true)|

#### 边距 `margin(int $margin)`

也支持设置边距. 设置方式如下:

	QrCode::margin(100);

#### 容错级别

改变二维码的容错级别也很方便.  只要这么设置:

	QrCode::errorCorrection('H');

下方是 `errorCorrection` 方法支持的容错级别设置.

| 容错级别 | 说明 |
| --- | --- |
| L | 7% 的字节码恢复率. |
| M | 15% 的字节码恢复率. |
| Q | 25% 的字节码恢复率. |
| H | 30% 的字节码恢复率. |

>容错级别越高,二维码越大且能存储的数据越少. 详情见: [error correction](http://en.wikipedia.org/wiki/QR_code#Error_correction).

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

#### 合并  `(string $filepath, float $percentage = .2, bool $absolute = false)`

 `merge` 方法可以让QrCode为生成结果加上图片.  常见的用法是在二维码上加Logo.

	//生成中间有图片的二维码
	QrCode::format('png')->merge('path-to-image.png')->generate();

	//生成中间有图片的二维码,且图片占整个二维码图片的30%.
	QrCode::format('png')->merge('path-to-image.png', .3)->generate();

	//生成中间有图片的二维码,且图片占整个二维码图片的30%.
	QrCode::format('png')->merge('http://www.google.com/someimage.png', .3, true)->generate();

> `merge` 方法当前只支持PNG格式的图片
> 默认使用相对于应用程序的根路径,把第三个参数设置为 `true` 就能切换到使用绝对路径

> 为了让二维码保持高可识别度,建议在使用 `merge` 方法时把二维码的容错级别提高. 我们推荐使用: `errorCorrection('H')`.

![合并Logo](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### 二进制合并 `(string $content, float $percentage = .2)`

 `mergeString` 方法与 `merge` 方法类似, 不同的是它允许你使用一个二进制的String代替图片文件. 这在使用 `Storage` 存储时,会显得很方便. 它的参数与 `merge` 类似.

	//生成中间有图片的二维码
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'))->generate();

	//生成中间有图片的二维码,且图片占整个二维码图片的30%.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'), .3)->generate();

> 和 `merge` 方法一样,当前只支持PNG格式. 同样建议将二维码的容错级别提高.

#### 高级用法

所有的方法都支持链式调用.  `generate` 方法必须在最后.  例如:

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Make me a QrCode!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('Make me a QrCode!');

你还能不存储图片,而使用 `base64_encode` 来将二进制数据直接显示成二维码图片.

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) !!} ">

<a id="docs-helpers"></a>
## 助手模板

#### 什么是助手模板?

助手模板生成一些简易二维码, 扫描二维码时会进行某些操作.

#### BitCoin比特币

这个模板生成可扫描二维码的来接受比特币支付. [详情](https://bitco.in/en/developer-guide#plain-text)

	QrCode::BTC($address, $amount);

	//发送0.334BTC到该地址
	QrCode::BTC('bitcoin address', 0.334);

	//发送0.334BTC到该地址和一些可选设置
	QrCode::size(500)->BTC('address', 0.0034, [
        'label' => 'my label',
        'message' => 'my message',
        'returnAddress' => 'https://www.returnaddress.com'
    ]);

#### E-Mail

这个模板可以生成一个直接发E-mail的二维码.包含了发邮件的地址,标题,和内容

	QrCode::email($to, $subject, $body);

	//加入一个邮件地址
	QrCode::email('foo@bar.com');

	//加一个邮件地址、标题、内容至二维码.
	QrCode::email('foo@bar.com', 'This is the subject.', 'This is the message body.');

	//只加标题和内容.
	QrCode::email(null, 'This is the subject.', 'This is the message body.');

#### 位置

这个模板能创建一个包含一个经纬度的位置二维码, 并在谷歌地图或类似应用中打开.

	QrCode::geo($latitude, $longitude);

	QrCode::geo(37.822214, -122.481769);

#### 手机号

这个模板能创建一个包含手机号的二维码, 并拨号.

	QrCode::phoneNumber($phoneNumber);

	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');

#### 短信

这个模板能创建能创建一个包含发送短信目标手机号和内容的二维码.

	QrCode::SMS($phoneNumber, $message);

	//创建一个只有手机号的短信二维码.
	QrCode::SMS('555-555-5555');

	//创建一个包含手机号和文字内容的短信二维码.
	QrCode::SMS('555-555-5555', 'Body of the message');

#### WiFi

这个模板能创建扫一下能连接WIFI的二维码.

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

> WIFI扫描目前苹果产品不支持.

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
| VCard名片 | BEGIN:VCARD | [更多范例](https://en.wikipedia.org/wiki/VCard) |
| Wifi | wifi: | wifi:WEP/WPA;SSID;PSK;Hidden(True/False) |

<a id="docs-outside-laravel"></a>
##在Laravel外的调用方式

你还可以在Laravel框架之外调用,只需要实例化 `BaconQrCodeGenerator` 类.

	use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

	$qrcode = new BaconQrCodeGenerator;
	$qrcode->size(500)->generate('Make a qrcode without Laravel!');
