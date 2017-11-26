Simple QrCode
========================

[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode)
[![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)

- [परिचय](#docs-introduction)
- [अनुवाद](#docs-translations)
- [विन्यास](#docs-configuration)
- [साधारण विचार](#docs-ideas)
- [उपयोग](#docs-usage)
- [सहायक](#docs-helpers)
- [साधारण QrCode उपयोग](#docs-common-usage)
- [लरावेल(Laravel) के बाहर उपयोग](#docs-outside-laravel)

<a id="docs-introduction"></a>
## परिचय
सरल क्यूआरकोड [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode) द्वारा प्र्दान किए गये महान कार्य पर आधारित लोकप्रिय Laravel ढ़ाचा के लिए आसानी से प्रयोग करने योग्य आवरण है। हमने लरावेल उपयोगकर्ताओं के लिए परिचित व आसानी से  स्थापित करने योग्य एक अंतरफलक  बनाया है।

<a id="docs-translations"></a>
## अनुवाद
हमे उनकी खोज है जो इस दस्तावेज़ का अरबी, स्पेनिश, फ्रेंच, कोरियाई या जापानी मे अनुवाद करने मे मदद कर सकते हैं। यदि आप एक अनुवाद करने में सक्षम हैं तो कृपया एक पुल अनुरोध बनाए!

<a id="docs-configuration"></a>
## विन्यास

#### Composer

सर्वप्रथं composer.json मे qrcode पॅकेज को अपने require से जोड़ें:

	"require": {
		"simplesoftwareio/simple-qrcode": "~2"
	}

फिर composer update कमॅंड चलाएँ।

#### Service Provider

###### Laravel <= 5.4
config/app.php में providers array में SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class को रजिस्टर करें।

#### Aliases (उपनाम)

###### Laravel <= 5.4
आखिर में 'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class को config/app.php विन्यास फ़ाइल में aliases array में रजिस्टर करें।

<a id="docs-ideas"></a>
## साधारण विचार

#### Print View (प्रिंट देखें)

इस पैकेज का मुख्य रूप से उपयोग हम सभी print views मे QrCode डालने के लिए करते हैं। यह हमारे ग्राहकों को स्कैन करके के बाद मूल पृष्ठ पर लौटने के लिए अनुमित करता है। हमने अपने footer.blade.php फ़ाइल में निम्न जोड़कर इसे हासिल किया है।

	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>Scan me to return to the original page.</p>
	</div>

#### Embed A QrCode

अपने उपयोगकर्ताओं को जल्दी से स्कैन करने के लिए आप एक ई-मेल के अंदर एक qrcode एम्बेड कर सकते हैं। निम्नलिखित  लरावेल के साथ ऐसा करने का एक उदाहरण है।

	//Inside of a blade template.
	<img src="{!!$message->embedData(QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png')!!}">

<a id="docs-usage"></a>
## उपयोग

#### Basic Usage (साधारण उपयोग)

QrCode Generator का उपयोग बेहद आसान है:

	QrCode::generate('Make me into a QrCode!');

इससे qrcode कहेगा है कि  "मुझे एक qrcode में बनाओ!"

#### Generate

Generate QrCode बनाने के काम आता है।

	QrCode::generate('Make me into a QrCode!');

>सचेत! यह विधि श्रृंखला में अंतिम में पुकारी जानी चाहिए।
`जेनरेट` डिफ़ॉल्ट रूप से SVG छवि की स्ट्रिंग लौटता है। आप इसे सीधे ही Laravel's Blade system से निम्न प्रकार से  किसी भी आधुनिक ब्राउज़र मे प्रिंट ले सकते हैं:

	{!! QrCode::generate('Make me into a QrCode!'); !!}

उत्पन्न विधि का एक दूसरे पैरामीटर है जो एक फ़ाइल का नाम और पथ QrCode को बचाने के लिए स्वीकार करता है।

	QrCode::generate('Make me into a QrCode!', '../public/qrcodes/qrcode.svg');

#### Format Change(प्रारूप बदलें)

>QrCode Generator डिफ़ॉल्ट रूप से SVG चित्र लौटाता है.

>ध्यान रहे! `format` की विधि को किसी भी अन्य स्वरूपण विकल्प जैसे कि `size`, `color`, `backgroundColor`, व `margin` से पहले ही कॉल करें.

निम्न तीन स्वरूप वर्तमान मे समर्थित हैं; PNG, EPS, और SVG.  निम्न कोड का उपयोग करें:

	QrCode::format('png');  //Will return a PNG image
	QrCode::format('eps');  //Will return a EPS image
	QrCode::format('svg');  //Will return a SVG image

#### Size Change (आकार बदल)

>QrCode Generator डिफ़ॉल्ट रूप से सबसे छोटी संभव आकार से QrCode बनाएग।

आप `आकार` विधि का उपयोग कर एक QRCode का आकार बदल सकते हैं। बस निम्न वाक्य-विन्यास का उपयोग करके पिक्सल मे वांछित आकर निर्दिष्ट करें:

	QrCode::size(100);

#### Color Change (रंग का बदलना)

>QrCode का रंग बदलते समय सतर्क रहें। कई उपयोगकर्ताओं को भिन्न रंगों मे QrCode पढ़ने मे कठिनाई होती है।

सभी रंगों को RGB(लाल हरा नीला) मे व्यक्त करना आवश्यक है। आप निम्न का उपयोग करने QrCode का रंग बदल सकते हैं:

	QrCode::color(255,0,255);

पृष्ठभूमि रंग परिवर्तन भी इस ही तरीके से व्यक्त किया जा सकता है।

	QrCode::backgroundColor(255,255,0);

#### Size Change (हाशिया परिवर्तन)

एक QrCode के आसपास हाशिया बदलने की क्षमता भी प्रदान की गयी है। इच्छित हाशिया निम्न वाक्य-विन्यास के अनुसार व्यक्त करें:

	QrCode::margin(100);

#### Error Correction (त्रुटि सुधार)

त्रुटि सुधार के स्तर को बदलना भी आसान है।  निम्न वाक्य - विन्यास के अनुसार चलें:

	QrCode::errorCorrection('H');

`errorCorrection` की विधि के लिए निम्न विकल्प समर्थित हैं:

| गलतीयों का सुधार | प्रस्तावित आश्वासन |
| --- | --- |
| L | 7%  codewords में से बहाल किए जा सकते हैं। |
| M | 15%  codewords में से बहाल किए जा सकते हैं। |
| Q | 25%  codewords में से बहाल किए जा सकते हैं। |
| H | 30%  codewords में से बहाल किए जा सकते हैं। |

>अधिक त्रुटि सुधार के उपयोग से QrCode बड़ा हो जाता है और कम सूचना जमा कर सकता है। [त्रुटि सुधार](http://en.wikipedia.org/wiki/QR_code#Error_correction) के बारे मे अधिक पढ़ें।

#### Encoding(एन्कोडिंग)

वर्ण एन्कोडिंग को बदलें जिसका प्रयोग QrCode का निर्माण करने के लिए  किया जाता है। डिफ़ॉल्ट रूप से `ISO-8859-1` एनकोडर के रूप में चयनित है।[वर्ण एनकोडिंग](http://en.wikipedia.org/wiki/Character_encoding) के बारे में अधिक पढ़ें। आप निम्न में से किसी के लिए इसे बदल सकते हैं:

	QrCode::encoding('UTF-8')->generate('Make me a QrCode with special symbols ♠♥!!');

| वर्ण एनकोडर |
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

>`Could not encode content to ISO-8859-1` त्रुटि का अर्थ है कि ग़लत वर्ण एनकोड का प्रकार उपयोग किया गया है।  यदि आप अनिश्चित हैं तो हमारा सुझाव है कि `UTF-8` का उपयोग करें।

#### Merge(विलय)

`मर्ज` विधि एक QrCode पर एक छवि विलीन करता है। यह आमतौर पर एक QrCode के भीतर लोगो रखने के लिए प्रयोग किया जाता है।

	QrCode::merge($filename, $percentage, $absolute);
	
	//Generates a QrCode with an image centered in the middle.
	QrCode::format('png')->merge('path-to-image.png')->generate();
	
	//Generates a QrCode with an image centered in the middle.  The inserted image takes up 30% of the QrCode.
	QrCode::format('png')->merge('path-to-image.png', .3)->generate();
	
	//Generates a QrCode with an image centered in the middle.  The inserted image takes up 30% of the QrCode.
	QrCode::format('png')->merge('http://www.google.com/someimage.png', .3, true)->generate();

>`मर्`ज विधि में अभी केवल PNG ही समर्थित है।
>filepath app, base path से सापेक्षित है यदि `$absolute` सेट है `false` पर।  इसे `true` से बदलें absolute paths पाने के लिए।

>आपको `merge` विधि का इस्तेमाल करते समय उच्च स्तर के त्रुटि सुधार का उपयोग करना चाहिए।  सुझाव है कि `errorCorrection('H')` का उपयोग करें।

![Merged Logo](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### Merge Binary String(द्विआधारी स्ट्रिंग का विलय)

`mergeString` विधि `मर्ज कॉल` वाले ही परिणाम पाने के लिए प्रयोग किया जा सकता है, सिवाय इसके कि इसमे आपको फ़ाइल पथ की बजाय फाइल की एक प्रतिनिधित्व स्ट्रिंग प्रदान करनी होती है। यह तब उपयोगी है जब `स्टोरेज` मुखौटे के साथ काम किया जाता है। इसका इंटरफेस मर्ज कॉल की तरह ही है।

	QrCode::mergeString(Storage::get('path/to/image.png'), $percentage);
	
	//Generates a QrCode with an image centered in the middle.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'))->generate();
	
	//Generates a QrCode with an image centered in the middle.  The inserted image takes up 30% of the QrCode.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'), .3)->generate();

>As with the normal `merge` call, only PNG is supported at this time. The same applies for error correction, high levels are recommened.

#### Advance Usage(अग्रिम उपयोग)

सभी तरीके श्रृंखलन का समर्थन करते हैं। `generate` तरीका अंत मे कॉल करना तथा तरीका कोई `format` का बदलाव सबसे पहले कॉल करना आवश्यक है। जैसे की आप निम्न मे से कोई भी रन कर सकते हैं:

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Make me a QrCode!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('Make me a QrCode!');

आप बिना फ़ाइल सुरक्षित करे, कच्चे स्ट्रिंग व `base64_encode` की एन्कोडेंग देकर भी PNG प्रदर्शित कर सकते हैं।

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) !!} ">

<a id="docs-helpers"></a>
## सहायक

#### सहायक क्या है ?

सहायक QrCode का निर्माण करने का साधारण तरीका है जो स्कैन करने पर पाठक से निश्चित कार्रवाई करवाते हैं।

#### E-Mail (ई-मेल)

यह सहायक ई-मेल qrcode का निर्माण करता है जो ई-मेल का पता, विषय तथा शरीर भरने मे सक्षम होता है।

	QrCode::email($to, $subject, $body);
	
	//Fills in the to address
	QrCode::email('foo@bar.com');
	
	//Fills in the to address, subject, and body of an e-mail.
	QrCode::email('foo@bar.com', 'This is the subject.', 'This is the message body.');
	
	//Fills in just the subject and body of an e-mail.
	QrCode::email(null, 'This is the subject.', 'This is the message body.');
	
#### Geo (जियो)

यह सहायक अक्षांश व देशान्तर का निर्माण करता है जिसे फोन पढ़ व Google Maps (गूगल मांचित्र) या अन्य app मे खोल सकता है।

	QrCode::geo($latitude, $longitude);
	
	QrCode::geo(37.822214, -122.481769);
	
#### Phone Number (फ़ोन नंबर)

इस सहायक द्वारा उत्तपन्‍न qrCode स्कैन करने पर नंबर डायल किया जा सकता है।

	QrCode::phoneNumber($phoneNumber);
	
	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');
	
#### SMS (पाठ संदेश)

इस सहायक द्वारा उत्तपन्‍न QrCode स्कैन करने पर SMS संदेश का भेजने का पता तथा संदेश का शरीर पहले से भरा जा सकता है।

	QrCode::SMS($phoneNumber, $message);
	
	//Creates a text message with the number filled in.
	QrCode::SMS('555-555-5555');
	
	//Creates a text message with the number and message filled in.
	QrCode::SMS('555-555-5555', 'Body of the message');

#### Wi-Fi (वाई-फाई)

इस सहायक द्वारा उत्तपन्‍न qrCode स्कैन करने पर वाईफाई नेटवर्क से जुड़ा जा सकता है।

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
	
>वाई-फाई स्कैनिंग Apple उत्पादों में अभी समर्थित नही है।

<a id="docs-common-usage"></a>
## साधारण QrCode उपयोग

आप निम्न तालिका मे से `generate` अनुभाग मे पाए गये उपसर्ग का उपयोग करके और अधिक उन्नत जानकारी स्टोर करने के लिए QrCode का निर्माण कर सकते हैं:

	QrCode::generate('http://www.simplesoftware.io');


| प्रयोग | उपसर्ग | उदाहरण |
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
## लरावेल(Laravel) के बाहर उपयोग

आप `BaconQrCodeGenerator` नमक नयी कक्षा स्थापित करके इस पैकेज का लरावेल के बाहर भी उपयोग कर सकते हैं।

	use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

	$qrcode = new BaconQrCodeGenerator;
	$qrcode->size(500)->generate('Make a qrcode without Laravel!');
