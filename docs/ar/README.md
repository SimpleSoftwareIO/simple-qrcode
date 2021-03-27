
[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode) [![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)

#### [Deutsch](http://www.simplesoftware.io/#/docs/simple-qrcode/de) | [Español](http://www.simplesoftware.io/#/docs/simple-qrcode/es) | [Français](http://www.simplesoftware.io/#/docs/simple-qrcode/fr) | [Italiano](http://www.simplesoftware.io/#/docs/simple-qrcode/it) | [Português](http://www.simplesoftware.io/#/docs/simple-qrcode/pt-br) | [Русский](http://www.simplesoftware.io/#/docs/simple-qrcode/ru) | [日本語](http://www.simplesoftware.io/#/docs/simple-qrcode/ja) | [한국어](http://www.simplesoftware.io/#/docs/simple-qrcode/kr) | [हिंदी](http://www.simplesoftware.io/#/docs/simple-qrcode/hi) | [简体中文](http://www.simplesoftware.io/#/docs/simple-qrcode/zh-cn) | [العربية](https://www.simplesoftware.io/#/docs/simple-qrcode/ar)

<div dir="rtl">

<a id="docs-introduction"></a>
## المقدمة
Simple QrCode هو غلاف سهل الاستخدام لإطار عمل Laravel الشهير استنادًا إلى العمل الرائع الذي يقدمه [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode).  أنشأنا واجهة مألوفة و سهلة التثبيت لمستخدمي لارافل

![المثال 1](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/example-1.png?raw=true) ![المثال 2](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/example-2.png?raw=true)

<a id="docs-upgrade"></a>
## دليل الترقية

قم بالترقية من V2 أو V3 عن طريق ملف `composer.json` إلى `~4`

يجب تثبيت امتداد PHP الخاص بـ `imagick` إذا كنت تخطط لاستخدام تنسيق صورة` png`.


#### v4

> كان هناك خطأ  عند إنشاء 4.1.0 و السماح ل للتغيرات التي حدثت للفرع الرئيسي. دالة `generate` الآن ترجع حالة `Illluminate\Support\HtmlString` إذا كنت تستخدم لارافل.
> إطلع على https://github.com/SimpleSoftwareIO/simple-qrcode/issues/205 لمزيد من التفاصيل


كانت هنا مشكلة مع واجهة لارافل في الإصدار ال3 التي أحدثت بعض المشاكل في التحميل. الطريقة الوحيدة لإصلاح هذا هو الإعتماد على الإصدار الرابع من الحزمة. إذا أنت من الإصدار V2 لا يوجد اي حاجة لتغيير الكود. التغييرات الآتية فقط تشمل الإصدار الثالث V3

جميع الإشارات لواجهة `QrCode` تحتاج لتغيير الآتي:
</div>

```
use SimpleSoftwareIO\QrCode\Facades\QrCode;
```

<a id="docs-configuration"></a>
<div dir="rtl">
## الإعدادات

#### Composer

قم بتشغيل `composer require simplesoftwareio/simple-qrcode "~4"` لإضافة الحزمة. 

لارافل ستقوم تلقائيا بتنصيب الحزمة.

<a id="docs-ideas"></a>
## أفكار بسيطة

#### عرض الطباعة

واحدة من العناصر التي تستخدم هذه الحزمة لأجل الحصول على QrCodes في كل عروض الطباعة. هذه الخاصية تسمح للمستخدم للرجوع إلى الصفحة الأصلية بعد أن تمت طباعة الكود. 
حصلنا على هذه النتيجة عن طريق إضافة التالي لتذييل الصفحة footer.blade.php 
<div dir="ltr">

	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>Scan me to return to the original page.</p>
	</div>

</div>
#### تضمين QrCode

ممكن ان تضمن الqrcode داخل بريد إلكتروني للسماح لمستخدميك بعمل مسح سريع على qrcode.
التالي هو مثال لكيفية عمل هذا بإستخدام إطار العمل لارافل.

<div dir="ltr">

	//Inside of a blade template.
	<img src="{!!$message->embedData(QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png')!!}">

</div>
<a id="docs-usage"></a>
## الإستخدامات

#### الإستخدامات البسيطة

<div dir="ltr">

```
// جميع الأمثلة التالية تفترض أن واجهة Qrcode تم إستدعائها.
// واجهة Qrcode يتم إستدعائها تلقائيا بالنسبة لمستخدمي لارافل

use SimpleSoftwareIO\QrCode\Facades\QrCode;
```
</div>

يعد استخدام QrCode Generator أمرًا سهلاً للغاية. أبسط شكل للكود هو:

<div dir="ltr">

	use SimpleSoftwareIO\QrCode\Facades\QrCode;

	QrCode::generate('Make me into a QrCode!');

</div>

هذا سيحول الكود إلى QrCode يحمل العبارة التالية:  "Make me into a QrCode!"

![Example QrCode](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/make-me-into-a-qrcode.png?raw=true)

#### Generate `(string $data, string $filename = null)`

`Generate` تستخدم لإنشاء QrCode

<div dir="ltr">

	QrCode::generate('Make me into a QrCode!');

</div>

`Generate` بشكل افتراضي سيعيد سلسلة صورة SVG. يمكنك طباعة هذا مباشرة في متصفح حديث داخل نظام Laravel's Blade باستخدام ما يلي:

<div dir="ltr">

	{!! QrCode::generate('Make me into a QrCode!'); !!}

</div>

طريقة "generate" لها معلمة ثانية ستقبل اسم ملف ومسار لحفظ رمز الاستجابة السريعة.

<div dir="ltr">

	QrCode::generate('Make me into a QrCode!', '../public/qrcodes/qrcode.svg');

</div>

#### شكل `(string $format)`

ثلاثة تنسيقات مدعومة حاليا ؛ `png`, `eps`, و `svg` . لتغيير التنسيق استخدم الكود التالي:

<div dir="ltr">

	QrCode::format('png');  //Will return a png image
	QrCode::format('eps');  //Will return a eps image
	QrCode::format('svg');  //Will return a svg image

</div>

> `imagick` مطلوبة لإنشاء إمتداد `png`

#### Size `(int $size)`

يمكنك تغيير حجم رمز الاستجابة السريعة باستخدام طريقة`size`. ما عليك سوى تحديد الحجم المطلوب بالبكسل باستخدام الصيغة التالية:

<div dir="ltr">

	QrCode::size(100);

</div>

![200 Pixels](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/200-pixels.png?raw=true) ![250 Pixels](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/250-pixels.png?raw=true) 

#### Color `(int $red, int $green, int $blue, int $alpha = null)`

>كن حذرًا عند تغيير لون رمز QrCode ، حيث يواجه بعض القراء صعوبة بالغة في قراءة رموز QrCode بالألوان.

يجب التعبير عن كل الألوان في RGBA (أحمر أخضر أزرق ألفا). يمكنك تغيير لون رمز الاستجابة السريعة باستخدام ما يلي:

<div dir="ltr">

	QrCode::color(255, 0, 0); // Red QrCode
	QrCode::color(255, 0, 0, 25); //Red QrCode with 25% transparency 

</div>

![Red QrCode](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-qrcode.png?raw=true) ![Red Transparent QrCode](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-25-transparent.png?raw=true)

#### Background Color `(int $red, int $green, int $blue, int $alpha = null)`

يمكنك تغيير لون خلفية رمز QrCode عن طريق استدعاء دالة `backgroundColor`.

<div dir="ltr">

	QrCode::backgroundColor(255, 0, 0); // Red background QrCode
	QrCode::backgroundColor(255, 0, 0, 25); //Red background QrCode with 25% transparency 

</div>

![Red Background QrCode](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-background.png?raw=true) ![Red Transparent Background QrCode](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-25-transparent-background.png?raw=true)

#### Gradient `$startRed, $startGreen, $startBlue, $endRed, $endGreen, $endBlue, string $type)`

يمكنك تطبيق التدرج اللوني في الQrcode عن طريق إستدعاء الدالة `gradient`

يتم دعم أنواع التدرجات اللونية التالية:

| النوع | مثال |
| --- | --- |
| `vertical` | ![Veritcal](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/vertical.png?raw=true) |
| `horizontal` | ![Horizontal](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/horizontal.png?raw=true) |
| `diagonal` | ![Diagonal](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/diagonal.png?raw=true) |
| `inverse_diagonal` | ![Invrse Diagonal](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/inverse_diagonal.png?raw=true) |
| `radial` | ![Radial](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/radial.png?raw=true) |

#### EyeColor `(int $eyeNumber, int $innerRed, int $innerGreen, int $innerBlue, int $outterRed = 0, int $outterGreen = 0, int $outterBlue = 0)`

ربما تريد تغيير لون العين بإستخدم دالة `eyeColor`.

<div dir="ltr">

	QrCode::eyeColor(0, 255, 255, 255, 0, 0, 0); // Changes the eye color of eye `0`

</div>

| رقم العين | مثال |
| --- | --- |
| `0` | ![Eye 0](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/eye-0.png?raw=true) |
| `1` | ![Eye 1](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/eye-1.png?raw=true)|
| `2` | ![Eye  2](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/eye-2.png?raw=true) |


#### Style `(string $style, float $size = 0.5)`


يمكن تبديل النمط بسهولة بـ`square` أو  `dot` أو`round`. سيؤدي هذا إلى تغيير الكتل داخل 
سيأثر المعامل الثاني للدالة على الحجم الخاص بالنقاط و الإستدارة


التنسيق 

<div dir="ltr">

	QrCode::style('dot'); // Uses the `dot` style.

</div>

| التنسيق | مثال |
| --- | --- |
| `square` | ![Square](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/200-pixels.png?raw=true) |
| `dot` | ![Dot](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/dot.png)|
| `round` | ![Round](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/round.png?raw=true) |

#### Eye Style `(string $style)`

العين التي بداخل الQrcode تدعم طريقتين مختلفيتين  في التنسيق `square` و `circle`

	QrCode::eye('circle'); // Uses the `circle` style eye.

| Style | Example |
| --- | --- |
| `square` | ![Square](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/200-pixels.png?raw=true) |
| `circle` | ![Circle](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/circle-eye.png?raw=true)|

#### Margin `(int $margin)`

القدرة على تغيير الهامش حول QrCode مدعومة أيضًا. ما عليك سوى تحديد الهامش المطلوب باستخدام الصيغة التالية:

<div dir="ltr">

	QrCode::margin(100);

</div>

#### Error Correction `(string $errorCorrection)`

من السهل تغيير مستوى تصحيح الخطأ. فقط استخدم الصيغة التالية:

<div dir="ltr">

	QrCode::errorCorrection('H');

</div>

الخيارات التالية تم دعمها في دالة `errorCorrection`:

| تصحيح الخطأ | الضمان المتوفر |
| --- | --- |
| L | 7% يمكن استعادة الكلمات المشفرة. |
| M | 15% يمكن استعادة الكلمات المشفرة. |
| Q | 25% يمكن استعادة الكلمات المشفرة. |
| H | 30% يمكن استعادة الكلمات المشفرة. |

> كلما إستخدمت نسبة تصحيح الخطأ أكثر, لكما قلت مصداقية ال Qrcode في إسترجاع البيانات المسجلة داخله
> إطلع أكثر حول [تصحيح الخطأ](https://ar.wikipedia.org/wiki/%D8%B1%D9%85%D8%B2_%D8%A7%D8%B3%D8%AA%D8%AC%D8%A7%D8%A8%D8%A9_%D8%B3%D8%B1%D9%8A%D8%B9%D8%A9#Error_correction).


#### Encoding `(string $encoding)`

قم بتغيير ترميز الأحرف المستخدم لبناء QrCode. افتراضيًا ، يتم تحديد "ISO-8859-1" باعتباره المشفر. اقرأ المزيد عن [ترميز الحروف](http://en.wikipedia.org/wiki/Character_encoding).

يمكنك تغيير هذا إلى أي مما يلي:

<div dir="ltr">

	QrCode::encoding('UTF-8')->generate('Make me a QrCode with special symbols ♠♥!!');

</div>

| تشفير الأحرف |
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

#### Merge `(string $filepath, float $percentage = .2, bool $absolute = false)`

تدمج دالة `merge`  صورة عبر QrCode. يستخدم هذا بشكل شائع لوضع الشعارات داخل QrCode.

<div dir="ltr">

	//Generates a QrCode with an image centered in the middle.
	QrCode::format('png')->merge('path-to-image.png')->generate();
	
	//Generates a QrCode with an image centered in the middle.  The inserted image takes up 30% of the QrCode.
	QrCode::format('png')->merge('path-to-image.png', .3)->generate();
	
	//Generates a QrCode with an image centered in the middle.  The inserted image takes up 30% of the QrCode.
	QrCode::format('png')->merge('http://www.google.com/someimage.png', .3, true)->generate();

</div>

> دالة "merge" تدعم PNG فقط في الوقت الحالي.
> يعد مسار الملف نسبيًا لمسار التطبيق الأساسي إذا تم تعيين`$absolute`  على `false`. غيّر هذا المتغير إلى `true` لاستخدام المسارات المطلقة.

> يجب عليك استعمال نسبة الإرتفاع ل تصحيح الخطأ عندما تستعمل دالة `merge` للتأكد أن ال Qrcode باقي سهل القراءة. نوصي باستخدام `errorCorrection('H')`.

![Merged Logo](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### Merge Binary String `(string $content, float $percentage = .2)`

دالة `mergeString`  يمكن إستخدامها للوصول لنفس النتيجة عندما تستدعي دالة `merge`, باستثناء أنه يسمح لك بتوفير تمثيل سلسلة للملف بدلاً من مسار الملف. هذا مفيد عند العمل مع واجهة `Storage`. واجهته مشابهة تمامًا لدالة `merge`

<div dir="ltr">

	//Generates a QrCode with an image centered in the middle.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'))->generate();
	
	//Generates a QrCode with an image centered in the middle.  The inserted image takes up 30% of the QrCode.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'), .3)->generate();

</div>
>كما هو الحال مع استدعاء `merge` العادي ، يتم دعم PNG فقط في الوقت الحالي. الأمر نفسه ينطبق على تصحيح الخطأ ، ويوصى بالمستويات العالية.

#### إستعمالات متقدمة

جميع الدوال تدعم التسلسل. يجب إستدعاء دالة `generate` في الأخير. على سبيل المثال: 

<div dir="ltr">

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Make me a QrCode!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('Make me a QrCode!');

</div>

تستطيع عرض صورة بإمتداد PNG بدون حفظ الملف من خلال توفير سلسلة raw string  و encoding بواسطة `base64_encode`.

<div dir="ltr">

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) !!} ">

</div>

<a id="docs-helpers"></a>
## الدوال المساعدة

#### ماهي الدوال المساعدة

تعد الدوال المساعدة طريقة سهلة لإنشاء QrCodes التي تجعل القارئ يقوم بعمل معين عند مسحه ضوئيا

#### بيتكوين

This helper generates a scannable bitcoin to send payments.  [More information](https://bitco.in/en/developer-guide#plain-text)

هاته الدالة المساعدة تقوم  بعمل إنشاء عملة بيتكوين قابلة للمسح لإرسال مدفوعات.  [لمزيد من المعلومات أضغط على الرابط](https://bitco.in/en/developer-guide#plain-text)

<div dir="ltr">

	QrCode::BTC($address, $amount);
	
	//Sends a 0.334BTC payment to the address
	QrCode::BTC('bitcoin address', 0.334);
	
	//Sends a 0.334BTC payment to the address with some optional arguments
	QrCode::size(500)->BTC('address', 0.0034, [
        'label' => 'my label',
        'message' => 'my message',
        'returnAddress' => 'https://www.returnaddress.com'
    ]);

</div>

#### البريد الإلكتروني

هاته الدالة المساعدة تمكنك من إنشاء QrCode للبريد الإلكتروني عنوان بريد إلكتروني مع الموضوع و المحتوى

<div dir="ltr">

	QrCode::email($to, $subject, $body);
	
	//Fills in the to address
	QrCode::email('foo@bar.com');
	
	//Fills in the to address, subject, and body of an e-mail.
	QrCode::email('foo@bar.com', 'This is the subject.', 'This is the message body.');
	
	//Fills in just the subject and body of an e-mail.
	QrCode::email(null, 'This is the subject.', 'This is the message body.');
	
</div>

#### الموقع الجغرافي

هاته الدالة المساعة تنشأ لك خطوط طول و عرض لتتم القرائة عن طريق الهاتف و فتح الموقع على خرائط Google أو تطبيق مشابه

<div dir="ltr">

	QrCode::geo($latitude, $longitude);
	
	QrCode::geo(37.822214, -122.481769);

</div>

#### رقم الهاتف

هاته الدالة تمكنك من إنشاء QrCode يستطيع الهاتف مسحه و الإتصال بالرقم.

<div dir="ltr">

	QrCode::phoneNumber($phoneNumber);
	
	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');

</div>

#### الرسائل القصيرة (الرسائل النصية)

هاته الدالة المساعدة تمكنك من إنشاء رسالة نصية و التي يمكن تعبئتها مسبقًا بالإرسال إلى العنوان ونص الرسالة:

<div dir="ltr">

	QrCode::SMS($phoneNumber, $message);
	
	//Creates a text message with the number filled in.
	QrCode::SMS('555-555-5555');
	
	//Creates a text message with the number and message filled in.
	QrCode::SMS('555-555-5555', 'Body of the message');

</div>

#### الوايفاي

هاته الدالة المساعدة تمكنك من مسح ال QrCodes التي بدورها تعمل إتصال من الهاتف لشبكة الوايفاي:

<div dir="ltr">

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
	
	//Connects to a secured WiFi network.
	QrCode::wiFi([
		'ssid' => 'Network Name',
		'encryption' => 'WPA',
		'password' => 'myPassword'
	]);

</div>

> منتجات أبل في الوقت الحالي لا تدعم مسح الوايفاي عن طريق ال QrCode

<a id="docs-common-usage"></a>
## الإستعمالات الشائعة لل QrCode


يمكنك استخدام بادئة موجودة في الجدول أدناه داخل قسم  `generate` لإنشاء رمز QrCode لتخزين المزيد من المعلومات المتقدمة:

<div dir="ltr">

	QrCode::generate('http://www.simplesoftware.io');

</div>

| الإستعمال | الإختصار | مثال |
| --- | --- | --- |
| رابط موقع إلكتروني | http:// | http://www.simplesoftware.io |
| عنوان URL آخمن | https:// | https://www.simplesoftware.io |
| بريد إلكتروني | mailto: | mailto:support@simplesoftware.io |
| رقم هاتف | tel: | tel:555-555-5555 |
| رسالة نصية (SMS) | sms: | sms:555-555-5555 |
| رسالة نصية (SMS) مع رسالة مكتوبة مسبقًا | sms: | sms::I am a pretyped message |
| رسالة نصية (SMS) مع رسالة ورقم مكتوب مسبقًا | sms: | sms:555-555-5555:I am a pretyped message |
| العنوان الجغرافي | geo: | geo:-78.400364,-85.916993 |
| MeCard | mecard: | MECARD:Simple, Software;Some Address, Somewhere, 20430;TEL:555-555-5555;EMAIL:support@simplesoftware.io; |
| VCard | BEGIN:VCARD | [See Examples](https://en.wikipedia.org/wiki/VCard) |
| الوايفاي | wifi: | wifi:WEP/WPA;SSID;PSK;Hidden(True/False) |

<a id="docs-outside-laravel"></a>
## إستخدام خارج لارافل

يمكنك إستخدام هاته الحزمة خارج إطار لارافل عبر إنشاء `Generator` كلاس Class جديد:

<div dir="ltr">

	use SimpleSoftwareIO\QrCode\Generator;

	$qrcode = new Generator;
	$qrcode->size(500)->generate('Make a qrcode without Laravel!');

</div>