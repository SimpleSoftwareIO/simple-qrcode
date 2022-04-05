[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode) [![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)

#### [Deutsch](http://www.simplesoftware.io/#/docs/simple-qrcode/de) | [Español](http://www.simplesoftware.io/#/docs/simple-qrcode/es) | [Français](http://www.simplesoftware.io/#/docs/simple-qrcode/fr) | [Italiano](http://www.simplesoftware.io/#/docs/simple-qrcode/it) | [Português](http://www.simplesoftware.io/#/docs/simple-qrcode/pt-br) | [Русский](http://www.simplesoftware.io/#/docs/simple-qrcode/ru) | [日本語](http://www.simplesoftware.io/#/docs/simple-qrcode/ja) | [한국어](http://www.simplesoftware.io/#/docs/simple-qrcode/kr) | [हिंदी](http://www.simplesoftware.io/#/docs/simple-qrcode/hi) | [简体中文](http://www.simplesoftware.io/#/docs/simple-qrcode/zh-cn) | [العربية](https://www.simplesoftware.io/#/docs/simple-qrcode/ar)

- [イントロダクション](#docs-introduction)
- [アップグレードガイド](#docs-upgrade)
- [翻訳](#docs-translations)
- [設定](#docs-configuration)
- [簡単な使い方](#docs-ideas)
- [使い方](#docs-usage)
- [ヘルパー](#docs-helpers)
- [よくあるQRコードの利用方法](#docs-common-usage)
- [Laravel外での使い方](#docs-outside-laravel)

<a id="docs-introduction"></a>
## イントロダクション
Simple QrCode は [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode) を元に作られた 人気のあるLaravelフレームワークで簡単に使う事のできるラッパーです。Laravelユーザーになじみのある使い方ができるように開発されました。

![Example 1](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/example-1.png?raw=true) ![Example 2](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/example-2.png?raw=true)

<a id="docs-translations"></a>
## 翻訳
この文書の翻訳を手伝ってくれるアラビア語、スペイン語、フランス語、韓国語、日本語を話すユーザーを探しています。 翻訳が可能な場合はプルリクエストを作成してください。

We are looking for users who speak Arabic, Spanish, French, Korean or Japanese to help translate this document.  Please create a pull request if you are able to make a translation!

<a id="docs-upgrade"></a>
## アップグレード

v2とv3からのアップデートは、`composer.json`ファイル内のバージョン指定を`~4`に変更してください。

PNG形式の画像を生成する場合は、**必ず**`imagick` PHP拡張をインストールしてください。

#### v4

> 4.1.0を作成するときのミスで、後方互換性が失われる変更がmasterブランチに入りました。
> `generate`メソッドは現在は `Illuminate\Support\HtmlString` のインスタンスを返します。
> 詳細は https://github.com/SimpleSoftwareIO/simple-qrcode/issues/205 を参照してください。

v3での読み込みに関する問題を引き起こすLaravelファサードの問題がありました。
この問題を解決するためには、後方互換性が失われる変更を加える必要があり、v4がリリースされるに至った経緯があります。
v2からのアップグレードの場合は既存コードの変更は必要ありません。
以下の説明はv3ユーザー向けです。

全ての`QrCode`ファサードへの参照は以下のように変更する必要があります:

```
use SimpleSoftwareIO\QrCode\Facades\QrCode;
```

<a id="docs-configuration"></a>
## 設定

#### Composer

`composer require simplesoftwareio/simple-qrcode "~4"` を実行してパッケージを追加します。

Laravelが自動的に必要なパッケージをインストールします。

<a id="docs-ideas"></a>
## 簡単な使い方

#### 画面に表示する

このパッケージの主なアイテムは 画面に表示する機能です。
カスタマーはコードをスキャンするだけで 画面に戻ることが出来ます。以下の内容を footer.blade.php に追加しました。

	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>スキャンして元のページに戻ります</p>
	</div>

#### QRコードを埋め込む

ユーザーがすばやくスキャンできるように、電子メールの中にQRコードを埋め込むことができます。 以下はLaravelでこれを行う方法の例です。

	// Bladeテンプレート内で以下のように書きます
	<img src="{!!$message->embedData(QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png')!!}">

<a id="docs-usage"></a>
## 使い方

#### 基本的な使い方

使い方はとても簡単です。 最も基本的な構文は次のとおりです。

	QrCode::generate('Make me into a QrCode!');

これで「Make me into a QrCode!」というQRコードが作成されます。

![QRコード生成例](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/make-me-into-a-qrcode.png?raw=true)

#### 生成する

`generate`はQRコードを生成するのに使われます。

	QrCode::generate('Make me into a QrCode!');

>要注意： チェーン内で使用する場合は、このメソッドを最後に呼び出す必要があります。

`generate`はデフォルトで SVG イメージ文字列を返します。
Laravel Blade に以下の様に書くことで モダンなブラウザに表示することができます。

	{!! QrCode::generate('Make me into a QrCode!'); !!}

`generate`メソッドの第二引数はQrCodeを保存するパスとファイルネームです。

	QrCode::generate('Make me into a QrCode!', '../public/qrcodes/qrcode.svg');

#### フォーマットを変える `(string$ format)`

>QrCode Generator のデフォルトフォーマットはSVGイメージです。

>要注意: `format`メソッドは` size`、 `color`、` backgroundColor`、 `margin`のような他のフォーマットオプションの前に呼ばれなければなりません。

現在PNG、EPS、およびSVGの 3つのフォーマットがサポートされています。
フォーマットを変更するには、次のコードを使用します。

	QrCode::format('png');  //Will return a PNG image
	QrCode::format('eps');  //Will return a EPS image
	QrCode::format('svg');  //Will return a SVG image

#### サイズの変更 `(int $size)`

>QrCode GeneratorはデフォルトでQRコードを作成するためにピクセルで可能な最小サイズを返します。

`size`メソッドを使うことでQrCodeのサイズを変えることができます。 次の構文を使用して、必要なサイズをピクセル単位で指定します。

	QrCode::size(100);

#### 色の変更 `(int $red, int $green, int $blue, int $alpha = null)`

>要注意 色を変えるときには注意してください。QrCodeの読み込みが難しくなる 色が有ります。

すべての色はRGB (Red Green Blue)で表現する必要があります。 次のようにしてQrCodeの色を変更できます:

	QrCode::color(255,0,255);

背景色の変更もサポートされており、同じ方法で表現できます。

	QrCode::backgroundColor(255,255,0);

#### 背景色の変更 `(int $red, int $green, int $blue, int $alpha = null)`

`backgroudColor`メソッドを呼び出すことでQRコードの背景色を変更できます。

	QrCode::backgroundColor(255, 0, 0); // 赤が背景色のQRコード
	QrCode::backgroundColor(255, 0, 0, 25); // 透明度25%で赤が背景色のQRコード

![赤が背景色のQRコード](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-background.png?raw=true) ![赤が背景色で透過なQRコード](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-25-transparent-background.png?raw=true)

#### グラデーション `(int $startRed, int $startGreen, int $startBlue, int $endRed, int $endGreen, int $endBlue, string $type)`

`gradient`メソッドを呼び出すことでQRコードにグラデーションを適用することができます。

以下のグラデーションタイプがサポートされています:

| タイプ                | 例                                                                                                                                    |
|--------------------|--------------------------------------------------------------------------------------------------------------------------------------|
| `vertical`         | ![Vertical](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/vertical.png?raw=true)                 |
| `horizontal`       | ![Horizontal](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/horizontal.png?raw=true)             |
| `diagonal`         | ![Diagonal](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/diagonal.png?raw=true)                 |
| `inverse_diagonal` | ![Inverse Diagonal](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/inverse_diagonal.png?raw=true) |
| `radial`           | ![Radial](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/radial.png?raw=true)                     |

#### 切り出しシンボル色 `(int $eyeNumber, int $innerRed, int $innerGreen, int $innerBlue, int $outterRed = 0, int $outterGreen = 0, int $outterBlue = 0)`

`eyeColor`メソッドを呼び出すことで切り出しシンボルの色を変更することもできます。

	QrCode::eyeColor(0, 255, 255, 255, 0, 0, 0); // シンボル番号`0`の色を変更します

| シンボル番号 | 例                                                                                                               |
|--------|-----------------------------------------------------------------------------------------------------------------|
| `0`    | ![Eye 0](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/eye-0.png?raw=true)  |
| `1`    | ![Eye 1](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/eye-1.png?raw=true)  |
| `2`    | ![Eye  2](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/eye-2.png?raw=true) |


#### スタイル `(string $style, float $size = 0.5)`

ブロックのスタイルは`style`メソッドを使用して`square`、`dot`、`round`に変更できます。 
これはQRコードの内部のブロックを変更します。
2つめのパラメーターは`dot`と`round`の大きさを指定します。

	QrCode::style('dot'); // `dot`スタイルに変更

| スタイル     | 例                                                                                                                    |
|----------|----------------------------------------------------------------------------------------------------------------------|
| `square` | ![Square](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/200-pixels.png?raw=true) |
| `dot`    | ![Dot](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/dot.png)                    |
| `round`  | ![Round](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/round.png?raw=true)       |

#### 切り出しシンボルのスタイル `(string $style)`

切り出しシンボルのスタイルは`eye`メソッドを使用して`square`、`circle`に変更できます。

	QrCode::eye('circle'); // `circle`スタイルの切り出しシンボルに変更

| スタイル     | 例                                                                                                                    |
|----------|----------------------------------------------------------------------------------------------------------------------|
| `square` | ![Square](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/200-pixels.png?raw=true) |
| `circle` | ![Circle](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/circle-eye.png?raw=true) |

#### マージンの変更 `(int $margin)`

QRコード周辺のマージンを変更する機能もサポートされています。 次の構文を使用してマージンを指定します:

	QrCode::margin(100);

#### エラー訂正 `(string $errorCorrection)`

エラー訂正レベルの変更は簡単です。次のようにします：

	QrCode::errorCorrection('H');

`errorCorrection` メソッドによってサポートされているオプション値は以下の通りです：

| エラー訂正レベル | 補償できる誤りの割合       |
|----------|------------------|
| L        | 7% までの誤りが復元できます  |
| M        | 15% までの誤りが復元できます |
| Q        | 25% までの誤りが復元できます |
| H        | 30% までの誤りが復元できます |

> より高いエラー訂正レベルを使用すると、QRコードの大きさはより大きくなり、格納できるデータ量は少なくなります。詳しくは [エラー訂正（リンク先は英語です）](http://en.wikipedia.org/wiki/QR_code#Error_correction) をご覧ください。

#### 文字コード `(string $encoding)`

QRコードの生成に使われる文字コードを変更します。デフォルトでは`ISO-8859-1`が指定されています。
詳細は [文字コード](https://ja.wikipedia.org/wiki/%E6%96%87%E5%AD%97%E3%82%B3%E3%83%BC%E3%83%89) をお読みください。

以下のようにして文字コードを変更できます:

	QrCode::encoding('UTF-8')->generate('日本語や特殊な文字を含むQRコードも作れます♠♥!!');

| 文字コード        |
|--------------|
| ISO-8859-1   |
| ISO-8859-2   |
| ISO-8859-3   |
| ISO-8859-4   |
| ISO-8859-5   |
| ISO-8859-6   |
| ISO-8859-7   |
| ISO-8859-8   |
| ISO-8859-9   |
| ISO-8859-10  |
| ISO-8859-11  |
| ISO-8859-12  |
| ISO-8859-13  |
| ISO-8859-14  |
| ISO-8859-15  |
| ISO-8859-16  |
| SHIFT-JIS    |
| WINDOWS-1250 |
| WINDOWS-1251 |
| WINDOWS-1252 |
| WINDOWS-1256 |
| UTF-16BE     |
| UTF-8        |
| ASCII        |
| GBK          |
| EUC-KR       |

#### 重ね合わせ `(string $filepath, float $percentage = .2, bool $absolute = false)`

`merge`メソッドはQRコードの上に画像を重ね合わせます。この機能は主にQRコードの中にロゴなどを配置する目的で使われます。

    //中央に画像を配置したQRコードを生成します
	QrCode::format('png')->merge('path-to-image.png')->generate();
	
    //中央に画像を配置したQRコードを生成します。配置された画像は最大でQRコードの大きさの30%になります。
	QrCode::format('png')->merge('path-to-image.png', .3)->generate();
	
    //中央に画像を配置したQRコードを生成します。配置された画像は最大でQRコードの大きさの30%になります。
	QrCode::format('png')->merge('http://www.google.com/someimage.png', .3, true)->generate();

> `merge`メソッドは現在のところPNGファイルのみをサポートしています。
> 引数`$absolute`が`false`の場合はファイルパスはプロジェクトルートからの相対パスとして認識されます。絶対パスで指定する場合は`true`を指定してください。

> `merge`メソッドを使用して画像を重ねているときでもQRコードを読み取れるようにするために、エラー訂正レベルも高くするべきです。`errorCorrection('H')`の使用を推奨します。

![ロゴを重ねた状態のサンプル](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### バイナリ文字列による重ね合わせ `(string $content, float $percentage = .2)`

`mergeString`メソッドは、ファイルを指定する代わりにバイナリ文字列を受け取る点を除いては`merge`メソッドと同様の挙動になります。

	// 中央に画像を配置したQRコードを生成します
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'))->generate();
	
	// 中央に画像を配置したQRコードを生成します。配置された画像は最大でQRコードの大きさの30%になります。
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'), .3)->generate();

> `merge`メソッドと同様に、現時点ではPNG形式のみサポートしています。エラー訂正についても同様にHレベルを推奨します。

#### 一歩進んだ使い方

全てのメソッドはチェーン呼び出しをサポートしています。`generate`メソッドは必ず最後に呼び出されなければいけません。例えば以下のようになります:

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Make me a QrCode!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('Make me a QrCode!');

そのままのバイナリ文字列と`base64_encode`によるエンコーディングを組み合わせて、PNG画像をファイルとして保存することなく直接表示することもできます。

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) !!} ">

<a id="docs-helpers"></a>
## ヘルパー

#### ヘルパーとは

ヘルパーは読み込み時に特定のアクションを実行するQRコードを簡単に生成するための機能です。

#### ビットコイン

このヘルパーはビットコインの支払用QRコードを生成します。[詳細情報（リンク先は英語です）](https://bitco.in/en/developer-guide#plain-text)

	QrCode::BTC($address, $amount);
	
	// 0.334BTCを指定したアドレスに送金
	QrCode::BTC('bitcoin address', 0.334);
	
	// いくつかのオプションを付けて0.334BTCを指定したアドレスに送金
	QrCode::size(500)->BTC('address', 0.0034, [
        'label' => 'my label',
        'message' => 'my message',
        'returnAddress' => 'https://www.returnaddress.com'
    ]);

#### Eメール

このヘルパーはEメールアドレス、件名、本文を指定してメールを送信するQRコードを生成します。

	QrCode::email($to, $subject, $body);
	
	// アドレスを指定します
	QrCode::email('foo@bar.com');
	
	// アドレス、件名、本文を指定します
	QrCode::email('foo@bar.com', 'This is the subject.', 'This is the message body.');
	
	// メールの件名と本文のみを指定します
	QrCode::email(null, 'This is the subject.', 'This is the message body.');
	
#### 位置情報

このヘルパーは緯度と経度を指定してGoogleマップなどの地図アプリを開くQRコードを生成します。

	QrCode::geo($latitude, $longitude);
	
	QrCode::geo(37.822214, -122.481769);
	
#### 電話番号

このヘルパーは読み取ったときに電話をかけるQRコードを生成します。

	QrCode::phoneNumber($phoneNumber);
	
	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');
	
#### SMS

このヘルパーは送信先と本文を指定してSMSメッセージを作成するQRコードを生成します。

	QrCode::SMS($phoneNumber, $message);
	
	// 電話番号が入力済みの状態でSMSメッセージを作成します
	QrCode::SMS('555-555-5555');
	
	// 電話番号と本文が入力済みの状態でSMSメッセージを作成します
	QrCode::SMS('555-555-5555', 'Body of the message');

#### Wi-Fi

このヘルパーはWi-Fiの接続情報を自動入力するQRコードを生成します。

	QrCode::wiFi([
		'encryption' => 'WPA/WEP',
		'ssid' => 'SSID of the network',
		'password' => 'Password of the network',
		'hidden' => 'Whether the network is a hidden SSID or not.'
	]);
	
	// Wi-Fiのオープンネットワークに接続します
	QrCode::wiFi([
		'ssid' => 'Network Name',
	]);
	
	// SSIDの公開されていないオープンネットワークに接続します
	QrCode::wiFi([
		'ssid' => 'Network Name',
		'hidden' => 'true'
	]);
	
	// 暗号化されたWi-Fiネットワーク接続します
	QrCode::wiFi([
		'ssid' => 'Network Name',
		'encryption' => 'WPA',
		'password' => 'myPassword'
	]);
	
> Wi-Fi接続情報のQRコードは現在のところApple社の製品ではサポートされていません。

<a id="docs-common-usage"></a>
## よくあるQRコードの利用方法

`generate`メソッドに渡す文字列にプレフィックスを付けることで、様々なQRコードを生成できます。

	QrCode::generate('http://www.simplesoftware.io');


| 利用方法            | プレフィックス     | 例                                                                                                        |
|-----------------|-------------|----------------------------------------------------------------------------------------------------------|
| ウェブサイトURL       | http://     | http://www.simplesoftware.io                                                                             |
| 暗号化されたウェブサイトURL | https://    | https://www.simplesoftware.io                                                                            |
| Eメールアドレス        | mailto:     | mailto:support@simplesoftware.io                                                                         |
| 電話番号            | tel:        | tel:555-555-5555                                                                                         |
| SMS             | sms:        | sms:555-555-5555                                                                                         |
| 本文入力済みSMS       | sms:        | sms::入力済みメッセージ                                                                                           |
| 本文・宛先入力済みSMS    | sms:        | sms:555-555-5555:入力済みメッセージ                                                                               |
| 位置情報            | geo:        | geo:-78.400364,-85.916993                                                                                |
| MeCard          | mecard:     | MECARD:Simple, Software;Some Address, Somewhere, 20430;TEL:555-555-5555;EMAIL:support@simplesoftware.io; |
| VCard           | BEGIN:VCARD | [例（リンク先は英語です）](https://en.wikipedia.org/wiki/VCard)                                                      |
| Wi-Fi           | wifi:       | wifi:WEP/WPA;SSID;PSK;Hidden(True/False)                                                                 |

<a id="docs-outside-laravel"></a>
## Laravel外での使い方

このパッケージは`Generater`クラスをインスタンス化することで、Laravelの外でも使えます。

	use SimpleSoftwareIO\QrCode\Generator;

	$qrcode = new Generator;
	$qrcode->size(500)->generate('Make a qrcode without Laravel!');
