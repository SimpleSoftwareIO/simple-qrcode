[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode) [![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)

- [소개(Introduction)](#docs-introduction)
- [번역(Translations)](#docs-translations)
- [설정(Configuration)](#docs-configuration)
- [간단한 아이디어(Simple Ideas)](#docs-ideas)
- [사용법(Usage)](#docs-usage)
- [헬퍼(Helpers)](#docs-helpers)
- [사용 예시(Common QrCode Usage)](#docs-common-usage)
- [라라벨을 사용하지 않는 곳에서 사용하기(Usage Outside of Laravel)](#docs-outside-laravel)

<a id="docs-introduction"></a>
## 소개(Introduction)
Simple QrCode는 인기가 많은 라라벨 프레임워크 상에서 쉽게 사용할 수 있는 Qr코드 생성 패키지로, 정말 잘 만들어진 [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode)를 기반으로 만들어졌습니다. 우리는 라라벨을 이용하는 사람들에게 친숙하고 쉬운 인터페이스를 만들었습니다.

<a id="docs-translations"></a>
## 번역(Translations)
우리는 현재 이 문서의 번역을 도와줄 아랍어, 스페인어, 불어, 혹은 일본어를 할 줄 아는 사람을 찾고 있습니다. 만약 번역을 해주실 수 있다면, 풀리퀘스트(Pull request)를 보내주세요!

<a id="docs-configuration"></a>
## 설정(Configuration)

#### Composer

우선, Simple QrCode 패키지를 `composer.json` 파일의 `require`에 추가해주세요:

	"require": {
		"simplesoftwareio/simple-qrcode": "~2"
	}

그 다음으로, `composer update` 명령을 실행해주세요.

#### Service Provider

###### Laravel <= 5.4
`config/app.php`의 `providers` 배열 안에, `SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class`를 등록해주세요.

#### Aliases

###### Laravel <= 5.4
마지막으로, `config/app.php` 설정 파일의 `aliases` 배열 안에, `'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class`를 등록해주세요.

<a id="docs-ideas"></a>
## 간단한 아이디어(Simple Ideas)

#### 화면에 출력하기

이 패키지를 사용하는 핵심적인 이유 중 하나는 Qr코드를 화면에 출력하기 위함입니다. 이 패키지는 우리의 고객들이 Qr코드를 스캔하는 것만으로 원래의 페이지로 돌아가게 할 수 있습니다. 우리는 이를 footer.blade.php 파일에 아래의 코드를 추가함으로서 해냈습니다.

	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>Scan me to return to the original page.</p>
	</div>

#### Qr코드 Embed하기

Qr코드를 이메일에 embed함으로서 유저가 쉽고 빠르게 스캔할 수 있게 할 수도 있습니다. 아래의 코드는 라라벨에서의 예시입니다.

	//Inside of a blade template.
	<img src="{!!$message->embedData(QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png')!!}">

<a id="docs-usage"></a>
## 사용법(Usage)

#### 간단한(Basic) 사용법

Qr코드를 생성하는 방법은 정말 쉽습니다. 가장 간단한 구문은:

	QrCode::generate('Make me into a QrCode!');

위 코드는 "Make me into a QrCode!"라는 문장을 Qr코드로 만들어줍니다.

#### 생성(Generate)

`Generate`는 Qr코드를 만들기 위해 사용됩니다.

	QrCode::generate('Make me into a QrCode!');

>주의하세요! 만약 메소드 체이닝을 사용하신다면, 이 메소드는 마지막에 호출되어야 합니다.

기본적인 `Generate`는 SVG 이미지 문자열을 반환합니다. 라라벨의 Blade를 사용하시면, 현대의 브라우저에는 직접적으로 출력하실 수 있습니다. 아래의 코드를 참고하세요:

	{!! QrCode::generate('Make me into a QrCode!'); !!}

`generate` 메소드의 두 번째 인자는 Qr코드를 저장할 파일명과 경로입니다.

	QrCode::generate('Make me into a QrCode!', '../public/qrcodes/qrcode.svg');

#### 포맷(Format) 변경

>Qr코드를 생성하면 기본적으로 SVG 이미지가 반환됩니다.

>주의하세요! `format` 메소드는 `size`, `color`, `backgroundColor`, 그리고 `margin`과 같은 다른 포맷팅 옵션들보다 먼저 호출되어야 합니다.

현재는 PNG, EPS, 그리고 SVG 이 세 가지 포맷을 지원하고 있습니다. 포맷을 변경하려면 아래의 코드를 참고하세요:

	QrCode::format('png');  //Will return a PNG image
	QrCode::format('eps');  //Will return a EPS image
	QrCode::format('svg');  //Will return a SVG image

#### 크기 변경

>Qr코드를 생성하면 기본적으로 Qr코드를 만들기 위한 최소 픽셀 사이즈로 반환됩니다.

`size` 메소드를 사용하면 Qr코드의 크기를 변경할 수 있습니다. 아래의 코드처럼, 단순히 원하는 픽셀 사이즈를 입력하세요:

	QrCode::size(100);

#### 색 변경

>Qr코드의 색을 변경할 때는 주의하세요. 어떤 Qr리더들은 색이 입혀진 Qr코드를 잘 읽지 못합니다.

모든 색은 RGB (Red Green Blue)로 표현되어야 합니다. 아래의 코드와 같이 Qr코드의 색을 변경할 수 있습니다:

	QrCode::color(255,0,255);

배경색도 변경할 수 있고, 같은 표현 방법을 사용합니다.

	QrCode::backgroundColor(255,255,0);

#### 여백(Margin) 변경

Qr코드 주위의 여백을 변경하는 것 또한 가능합니다. 아래의 코드처럼, 단순히 원하는 여백을 입력하세요:

	QrCode::margin(100);

#### 오류 복원(Error Correction)

오류 복원 레벨을 변경하는 것은 쉽습니다. 아래의 코드를 참고하세요:

	QrCode::errorCorrection('H');

아래는 `errorCorrection` 메소드에서 지원하는 옵션들입니다.

| 오류 복원 레벨 | 복원률 |
| --- | --- |
| L | 약 7%의 codewords |
| M | 약 15%의 codewords |
| Q | 약 25%의 codewords |
| H | 약 30%의 codewords |

>codewords는 데이터를 구성하는 단위로 Qr코드에는 8bit/codewords를 의미합니다.

>복원율이 커질 수록 Qr코드가 커지고 저장할 수 있는 데이터가 적어집니다. [error correction](http://en.wikipedia.org/wiki/QR_code#Error_correction)를 참고하세요.

#### 인코딩(Encoding)

Qr코드를 만들기 위한 문자 인코딩을 변경할 수 있습니다. 기본값은 `ISO-8859-1`입니다. [character encoding](http://en.wikipedia.org/wiki/Character_encoding)를 참고하세요. 아래의 코드처럼, 다른 인코딩으로 변경할 수 있습니다:

	QrCode::encoding('UTF-8')->generate('Make me a QrCode with special symbols ♠♥!!');

| 문자 인코더(Character Encoder) |
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

>`Could not encode content to ISO-8859-1` 오류는 잘못된 문자 인코딩이 사용되고 있다는 것을 의미합니다. 만약 확신이 없다면 `UTF-8` 사용을 권장합니다.

#### 병합(Merge)

`merge` 메소드는 이미지를 Qr코드 위에 합쳐줍니다. 주로 로고 이미지를 Qr코드 안에 넣기 위해 사용합니다.

	QrCode::merge($filename, $percentage, $absolute);
	
	//Generates a QrCode with an image centered in the middle.
	QrCode::format('png')->merge('path-to-image.png')->generate();
	
	//Generates a QrCode with an image centered in the middle.  The inserted image takes up 30% of the QrCode.
	QrCode::format('png')->merge('path-to-image.png', .3)->generate();
	
	//Generates a QrCode with an image centered in the middle.  The inserted image takes up 30% of the QrCode.
	QrCode::format('png')->merge('http://www.google.com/someimage.png', .3, true)->generate();

>`merge` 메소드는 현재 PNG 포맷만 지원합니다.
>`$absolute`가 `false`로 되어 있으면, 파일 경로는 상대 경로입니다. 절대 경로를 사용하고 싶으시면, 이 변수 값을 `true`로 변경해주세요.

>`merge`를 사용하면서 Qr리더가 잘 스캔하게 하기 위해서는 높은 오류 복원율을 사용해야합니다. `errorCorrection('H')`를 사용하기를 권장합니다.

![Merged Logo](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### 이진 문자열 병합(Merge Binary String)

`mergeString` 메소드는 `merge`와 동일한 동작을 합니다. 단, `mergeString` 메소드를 사용하면 파일을 파일의 경로가 아닌 문자열로 표현할 수 있도록 해줍니다. 이는 `Storage` 파사드를 같이 사용할 때, 유용하게 쓰입니다. `mergeString`의 인터페이스는 `merge`와 거의 동일합니다.

	QrCode::mergeString(Storage::get('path/to/image.png'), $percentage);
	
	//Generates a QrCode with an image centered in the middle.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'))->generate();
	
	//Generates a QrCode with an image centered in the middle.  The inserted image takes up 30% of the QrCode.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'), .3)->generate();

>일반적인 `merge` 메소드 호출처럼, 현재 PNG 포맷만 지원합니다. 오류 복원율도 동일하게 높은 레벨의 오류 복원율을 권장합니다.

#### 고급(Advanced) 사용법

모든 메소드는 메소드 체이닝을 지원합니다. `generate` 메소드는 반드시 마지막에 호출되어야 하고, `format` 변경은 반드시 첫 부분에 호출되어야 합니다. 아래의 예시 코드를 참고해주세요:

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Make me a QrCode!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('Make me a QrCode!');

PNG 이미지를 `base64_encode`를 사용하여 인코딩된 raw string을 사용하면, 파일로 저장하지 않아도 출력할 수 있습니다.

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) !!} ">

<a id="docs-helpers"></a>
## 헬퍼(Helpers)

#### 헬퍼가 무엇인가요?

헬퍼는 Qr리더로 스캔했을 때, 특정한 동작을 할 수 있는 Qr코드를 만들어줍니다.

#### 비트코인(BitCoin)

이 헬퍼는 스캔했을 때 비트코인을 송금할 수 있는 Qr코드를 만들어줍니다. [더 알아보기](https://bitco.in/en/developer-guide#plain-text)

	QrCode::BTC($address, $amount);
	
	//Sends a 0.334BTC payment to the address
	QrCode::BTC('bitcoin address', 0.334);
	
	//Sends a 0.334BTC payment to the address with some optional arguments
	QrCode::size(500)->BTC('address', 0.0034, [
        'label' => 'my label',
        'message' => 'my message',
        'returnAddress' => 'https://www.returnaddress.com'
    ]);

#### 이메일(E-mail)

이 헬퍼는 이메일 주소, 제목, 그리고 내용이 미리 입력되어 있는 채로 이메일을 보낼 수 있는 Qr코드를 만들어줍니다.

	QrCode::email($to, $subject, $body);
	
	//Fills in the to address
	QrCode::email('foo@bar.com');
	
	//Fills in the to address, subject, and body of an e-mail.
	QrCode::email('foo@bar.com', 'This is the subject.', 'This is the message body.');
	
	//Fills in just the subject and body of an e-mail.
	QrCode::email(null, 'This is the subject.', 'This is the message body.');
	
#### 지리위치(Geo)

이 헬퍼는 스마트폰으로 스캔해서 구글 지도 같은 지도 앱들에 위치를 표현할 수 있도록 위도와 경도 값을 포함하고 있는 Qr코드를 만들어줍니다.

	QrCode::geo($latitude, $longitude);
	
	QrCode::geo(37.822214, -122.481769);
	
#### 전화번호(Phone Number)

이 헬퍼는 스캔해서 통화 연결을 할 수 있는 Qr코드를 만들어줍니다.

	QrCode::phoneNumber($phoneNumber);
	
	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');
	
#### 문자 메세지(SMS)

이 헬퍼는 받는 사람 번호와 문자 메세지 내용이 미리 입력되어 있는 채로 문자 메세지를 보낼 수 있는 Qr코드를 만들어줍니다.

	QrCode::SMS($phoneNumber, $message);
	
	//Creates a text message with the number filled in.
	QrCode::SMS('555-555-5555');
	
	//Creates a text message with the number and message filled in.
	QrCode::SMS('555-555-5555', 'Body of the message');

#### 와이파이(WiFi)

이 헬퍼는 스마트폰으로 스캔해서 와이파이에 연결할 수 있도록 하는 Qr코드를 만들어줍니다.

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

>현재 애플 제품(예. 아이폰 등)은 와이파이 스캔을 지원하지 않습니다.	

<a id="docs-common-usage"></a>
## 사용 예시(Common QrCode Usage)

아래 표에 있는 접두사(prefix)를 `generate` 섹션에 사용하면, 더 고급스러운 정보가 저장된 Qr코드를 만들 수 있습니다:

	QrCode::generate('http://www.simplesoftware.io');


| 사용처 | Prefix | 예시 |
| --- | --- | --- |
| 웹사이트(http) URL | http:// | http://www.simplesoftware.io |
| 웹사이트(https) URL | https:// | https://www.simplesoftware.io |
| 이메일 주소 | mailto: | mailto:support@simplesoftware.io |
| 전화번호 | tel: | tel:555-555-5555 |
| 문자 메세지(SMS) | sms: | sms:555-555-5555 |
| 내용이 미리 입력된 문자 메세지(SMS) | sms: | sms::I am a pretyped message |
| 번호와 내용이 미리 입력된 문자 메세지(SMS) | sms: | sms:555-555-5555:I am a pretyped message |
| 지리위치 정보(Geo Address) | geo: | geo:-78.400364,-85.916993 |
| MeCard | mecard: | MECARD:Simple, Software;Some Address, Somewhere, 20430;TEL:555-555-5555;EMAIL:support@simplesoftware.io; |
| VCard | BEGIN:VCARD | [See Examples](https://en.wikipedia.org/wiki/VCard) |
| 와이파이(Wifi) | wifi: | wifi:WEP/WPA;SSID;PSK;Hidden(True/False) |

<a id="docs-outside-laravel"></a>
## 라라벨을 사용하지 않는 곳에서 사용하기(Usage Outside of Laravel)

`BaconQrCodeGenerator` 클래스를 인스턴스화하면, 라라벨을 사용하지 않는 곳에서 이 패키지를 사용할 수 있습니다.

	use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

	$qrcode = new BaconQrCodeGenerator;
	$qrcode->size(500)->generate('Make a qrcode without Laravel!');
