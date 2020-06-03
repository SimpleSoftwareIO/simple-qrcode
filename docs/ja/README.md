[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode) [![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)


#### [Español](https://www.simplesoftware.io/simple-qrcode/es) | [Français](https://www.simplesoftware.io/simple-qrcode/fr) | [Italiano](https://www.simplesoftware.io/simple-qrcode/it) | [Português](https://www.simplesoftware.io/simple-qrcode/pt-br) | [Русский](https://www.simplesoftware.io/simple-qrcode/ru) | [हिंदी](https://www.simplesoftware.io/simple-qrcode/hi) | [汉语](https://www.simplesoftware.io/simple-qrcode/zh)

- [Introduction](#docs-introduction)
- [Translations](#docs-translations)
- [Configuration](#docs-configuration)
- [Simple Ideas](#docs-ideas)
- [Usage](#docs-usage)
- [Helpers](#docs-helpers)
- [Common QrCode Usage](#docs-common-usage)
- [Usage Outside of Laravel](#docs-outside-laravel)

<a id="docs-introduction"></a>
## イントロダクション
Simple QrCode は [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode)を元に作られた 人気のあるLaravelフレームワークで簡単に使う事のできるラッパーです。


Simple QrCode is an easy to use wrapper for the popular Laravel framework based on the great work provided by [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode).  We created an interface that is familiar and easy to install for Laravel users.

<a id="docs-translations"></a>
## 翻訳
この文書の翻訳を手伝ってくれるアラビア語、スペイン語、フランス語、韓国語、日本語を話すユーザーを探しています。 翻訳が可能な場合はプルリクエストを作成してください。

We are looking for users who speak Arabic, Spanish, French, Korean or Japanese to help translate this document.  Please create a pull request if you are able to make a translation!

<a id="docs-configuration"></a>
## 設定

#### Composer
最初にあなたの `composer.json` に Simple QrCode パッケージを追加する必要があります。

	"require": {
		"simplesoftwareio/simple-qrcode": "~2"
	}
追加したら `composer update` コマンドを実行します。

#### サービスプロバイダー

###### Laravel <= 5.4
(あなたが Simple QrCode を入れる laravelの) `config/app.php` の `providers`配列 に `SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class` を登録します。

#### Aliases

###### Laravel <= 5.4
最後に `config/app.php` の `aliases`配列に `'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class` を登録します。

<a id="docs-ideas"></a>
## かんたんに使う

#### 画面に表示する

このパッケージの主なアイテムは 画面に表示する機能です。
カスタマーはコードをスキャンするだけで 画面に戻ることが出来ます。以下の内容をfooter.blade.php に追加しました。
	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>Scan me to return to the original page.</p>
	</div>

#### QrCodeを埋め込む

ユーザーがすばやくスキャンできるように、電子メールの中にqrcodeを埋め込むことができます。 以下はLaravelでこれを行う方法の例です。

	//Inside of a blade template.
	<img src="{!!$message->embedData(QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png')!!}">

<a id="docs-usage"></a>
## Usage

#### 基本的な使い方

QrCode Generatorを使うのはとても簡単です。 最も基本的な構文は次のとおりです。

	QrCode::generate('Make me into a QrCode!');

これで「Make me into a QrCode!」というQrCodeが作成されます。

#### 生成する

`Generate`はQrCodeを作るのに使われます。

	QrCode::generate('Make me into a QrCode!');

>要注意： チェーン内で使用する場合は、このメソッドを最後に呼び出す必要があります。

`Generate`はデフォルトで SVG イメージ文字列を返します。
Laravel Bladeに以下の様に書くことで モダンなブラウザに表示することができます。

	{!! QrCode::generate('Make me into a QrCode!'); !!}

`generate`メソッドの第二引数はQrCodeを保存するパスとファイルネームです。

	QrCode::generate('Make me into a QrCode!', '../public/qrcodes/qrcode.svg');

#### フォーマットを変える

>QrCode Generator のデフォルトフォーマットはSVGイメージです。

>要注意: `format`メソッドは` size`、 `color`、` backgroundColor`、 `margin`のような他のフォーマットオプションの前に呼ばれなければなりません。

現在PNG、EPS、およびSVGの 3つのフォーマットがサポートされています。
フォーマットを変更するには、次のコードを使用します。

	QrCode::format('png');  //Will return a PNG image
	QrCode::format('eps');  //Will return a EPS image
	QrCode::format('svg');  //Will return a SVG image

#### サイズの変更

>QrCode GeneratorはデフォルトでQrCodeを作成するためにピクセルで可能な最小サイズを返します。

`size`メソッドを使うことでQrCodeのサイズを変えることができます。 次の構文を使用して、必要なサイズをピクセル単位で指定します。

	QrCode::size(100);

#### 色の変更

>要注意 色を変えるときには注意してください。QrCodeの読み込みが難しくなる 色が有ります。

すべての色はRGB (Red Green Blue)で表現する必要があります。 次のようにしてQrCodeの色を変更できます:

	QrCode::color(255,0,255);

背景色の変更もサポートされており、同じ方法で表現できます。

	QrCode::backgroundColor(255,255,0);

#### マージンの変更

QrCode周辺のマージンを変更する機能もサポートされています。 次の構文を使用してマージンを指定します:
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

#### Encoding

Change the character encoding that is used to build a QrCode.  By default `ISO-8859-1` is selected as the encoder.  Read more about [character encoding](http://en.wikipedia.org/wiki/Character_encoding) You can change this to any of the following:

	QrCode::encoding('UTF-8')->generate('Make me a QrCode with special symbols ♠♥!!');

| Character Encoder |
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

>An error of `Could not encode content to ISO-8859-1` means that the wrong character encoding type is being used.  We recommend `UTF-8` if you are unsure.

#### Merge

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
## Helpers

#### What are helpers?

Helpers are an easy way to create QrCodes that cause a reader to perform a certain action when scanned.  

#### BitCoin

This helpers generates a scannable bitcoin to send payments.  [More information](https://bitco.in/en/developer-guide#plain-text)

	QrCode::BTC($address, $amount);

	//Sends a 0.334BTC payment to the address
	QrCode::BTC('bitcoin address', 0.334);

	//Sends a 0.334BTC payment to the address with some optional arguments
	QrCode::size(500)->BTC('address', 0.0034, [
        'label' => 'my label',
        'message' => 'my message',
        'returnAddress' => 'https://www.returnaddress.com'
    ]);

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
## Common QrCode Usage

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
## Usage Outside of Laravel

You may use this package outside of Laravel by instantiating a new `BaconQrCodeGenerator` class.

	use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

	$qrcode = new BaconQrCodeGenerator;
	$qrcode->size(500)->generate('Make a qrcode without Laravel!');
