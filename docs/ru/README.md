Простой QR-код 
========================

[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode)
[![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)

- [Введение](#docs-introduction)
- [Переводы](#docs-translations)
- [Конфигурация](#docs-configuration)
- [Простые Идеи](#docs-ideas)
- [Употребление](#docs-usage)
- [Хелперы](#docs-helpers)
- [Распространенное использование QR-кода](#docs-common-usage)
- [Использование за пределами Laravel](#docs-outside-laravel)

<a id="docs-introduction"></a>
## Введение
Обычный QR-код простой в использовании обертки для популярных рамок Laravel на основе превосходный работы, предоставленной [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode). Мы создали интерфейс, который привычный и простой в установке для пользователей Laravel.

<a id="docs-translations"></a>
## Переводы
Мы ищем пользователей, говорящих на китайском, корейском или японском языках, которые могут помочь перевести этот документ. Пожалуйста, создайте пул реквест, если вы способны сделать перевод!

<a id="docs-configuration"></a>
## Конфигурация

#### Composer

Во-первых, добавьте пакет простого QR-код к `require` в файле `composer.json`:

	"require": {
		"simplesoftwareio/simple-qrcode": "~1"
	}

Затем запустите команду `composer update`.

#### Поставщик Услуг

###### Laravel 4
Зарегистрируйте `SimpleSoftwareIO\QrCode\QrCodeServiceProvider` в `app/config/app.php` в пределах массива `providers`.

###### Laravel 5
Зарегистрируйте `SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class` в `config/app.php` в пределах массива `providers`.

#### Псевдонимы

###### Laravel 4
И, наконец, зарегистрируйте `'QrCode' => 'SimpleSoftwareIO\QrCode\Facades\QrCode'` в `app/config/app.php` файл конфигурации в пределах массива `aliases`.

###### Laravel 5
В конце, зарегистрируйте `'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class` в `config/app.php` файл конфигурации в пределах массива `aliases`.

<a id="docs-ideas"></a>
## Простые Идеи

#### Предварительный Просмотр Печати

Иметь QR-код во всех предварительных просмотрах является одним из основных элементов, для которых мы используем этот пакет. Это позволяет нашим клиентам, вернуться на исходную страницу после того, как она будет напечатана с помощью сканирования кода. Мы добились этого, добавив footer.blade.php в наш файл.

	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>Сканируйте меня, чтобы вернуться на исходную страницу.</p>
	</div>

#### Вставление QR-код

Вы можете вставить QR-код в электронную почту, чтобы позволить пользователям быстро его сканировать. Ниже приведен пример того, как сделать это с помощью Laravel.

	// Внутри шаблона Blade.
	<img src="{!!$message->embedData(QrCode::format('png')->generate('Введете меня в сообщение по электронный почте!'), 'QrCode.png', 'image/png')!!}">

<a id="docs-usage"></a>
## Употребление

#### Основное Использование

Использовать генератор для QR-код очень легко. Самый основной синтаксис:

	QrCode::generate('Сделайте меня QR-кодом!');

Это создаст QR-код говоря "Сделайте меня QR-кодом!"

#### Генератора

`Generate` используется, чтобы создать QR-код.

	QrCode::generate('Сделайте меня QR-кодом!');

> Внимание! Этот метод должен быть вызван в конце если используются в последовательности.

`Generate` по умолчанию возвращает строку изображение в формате SVG. Вы можете напечатать это прямо в современный браузер внутри системы Blade в Laravel как указано далее:

	{!! QrCode::generate('Сделайте меня QR-кодом!'); !!}

Метод `generate` имеет второй параметр, который будет принимать имя файла и путь для сохранения QR-код.

	QrCode::generate('Сделайте меня QR-кодом!', '../public/qrcodes/qrcode.svg');

#### Изменение Формата

> Генератор QR-код установлен для возврата изображения в формате SVG по умолчанию.

> Будьте осторожны! Метод `format` должен вызываться перед всеми остальными параметрами форматирования, такими как: `size`, `color`, `backgroundColor`, и `margin`.

Три формата на данный момент поддерживаются; PNG, EPS, и SVG. Для изменения формата используйте следующий код:

QrCode::format('png');  // Возвращает изображение в формате PNG
QrCode::format('eps');  // Возвращает изображение в формате EPS
QrCode::format('svg');  // Возвращает изображение в формате SVG

#### Изменение Размера

> Генератор QR-код по умолчанию будет возвращать наименьший размер в пикселях возможных для создания QR-код.

Вы можете изменить размер QR-код с помощью метода `size`. Просто укажите размер желаемого в пикселях, используя следующий синтаксис:

	QrCode::size(100);

#### Изменение цвета

> Будьте осторожны при изменении цвета в QR-код. Некоторым читателям очень сложно читать QR-код в цвете.

Все QR-коды должны быть выражены в красном, зеленом или синем цвете. Вы можете изменить цвет QR-код с помощью следующих действий:

	QrCode::color(255,0,255);

Изменения цвета фона также поддерживаются и должны быть выражены таким же образом.

	QrCode::backgroundColor(255,255,0);

#### Изменение поля

Возможность изменения поля вокруг QR-кода также поддерживается. Просто укажите желаемый запас, используя следующий синтаксис:

	QrCode::margin(100);

#### Исправление ошибок

Изменять уровень коррекции ошибок легко. Просто используйте следующий синтаксис:

	QrCode::errorCorrection('H');

Указанное далее поддерживается в вариантах для метода `errorCorrection`.

| Исправление ошибок | Гарантия |
| --- | --- |
| L | 7% кодовых слов могут быть восстановлены.|
| M | 15% кодовых слов могут быть восстановлены.|
| Q | 25% кодовых слов могут быть восстановлены.|
| H | 30% кодовых слов могут быть восстановлены.|

> Чем больше коррекций ошибок используется; тем больше становится QR-код и тем меньше данных он может хранить. Подробнее читайте об [исправлении ошибок]( https://ru.wikipedia.org/wiki/QR-%D0%BA%D0%BE%D0%B4#.D0.9E.D0.B1.D1.89.D0.B0.D1.8F_.D1.82.D0.B5.D1.85.D0.BD.D0.B8.D1.87.D0.B5.D1.81.D0.BA.D0.B0.D1.8F_.D0.B8.D0.BD.D1.84.D0.BE.D1.80.D0.BC.D0.B0.D1.86.D0.B8.D1.8F).

#### Кодирование

Измените кодировку,которая используется для создания QR-кода. По умолчанию `ISO-8859-1` выбран в качестве кодера. Подробнее читайте о [кодирование символов]( https://ru.wikipedia.org/wiki/%D0%9D%D0%B0%D0%B1%D0%BE%D1%80_%D1%81%D0%B8%D0%BC%D0%B2%D0%BE%D0%BB%D0%BE%D0%B2). Вы можете изменить это на любое из следующих действий:

	QrCode::encoding('UTF-8')->generate('‘Сделайте меня QR-кодом со специальными символами ♠♥!!');

| Набор Символов |
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

> Ошибка обозначена `Could not encode content to ISO-8859-1` означает, что неправильный тип кодировки был использован. Мы рекомендуем `UTF-8` если вы не уверены.

#### Merge

Метод `merge` объединяет изображение над QR-кодом. Это обычно используется для логотипов, размещенных в пределах QR-кода.

	QrCode::merge($filename, $percentage, $absolute);
	
	// Создает QR-код с изображением в центре.
	QrCode::format('png')->merge('path-to-image.png')->generate();
	
	// Создает QR-код с изображением в центре. Вставленное изображение занимает 30% QR-кода.
	QrCode::format('png')->merge('path-to-image.png', .3)->generate();
	
	// Создает QR-код с изображением в центре. Вставленное изображение занимает 30% QR-кода.
	QrCode::format('png')->merge('http://www.google.com/someimage.png', .3, true)->generate();

> Метод `merge` поддерживает только формат PNG в это время.
> Путь к файлу является относительно базового приложения пути, если `$absolute` установлен к `false`.  Измените эту переменную `true` чтоб использовать абсолютные пути.

> Вы должны использовать высокий уровень коррекции ошибок при использовании метода `merge` чтобы гарантировать, что QR-код остается читаемым. Мы рекомендуем использовать `errorCorrection('H')`.

![Merged Logo](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### Слияние Двоичной Строки

Метод `mergeString` может быть использован для достижения такой же, как вызов `merge` за исключением того, что позволяет обеспечить строковое представление файла вместо пути к файлу. Это полезно при работе с фасадом `Storage`. Этот интерфейс очень похож на вызов `merge`.

	QrCode::mergeString(Storage::get('path/to/image.png'), $percentage);
	
	// Создает QR-код с изображением в центре.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'))->generate();
	
	// Создает QR-код с изображением в центре. Вставленное изображение занимает 30% QR-кода.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'), .3)->generate();

> Как и в случае нормального вызова `merge` только PNG поддерживается в это время. То же самое относится к коррекции ошибок, рекомендуется использовать высокие уровни.

#### Дополнительные Функции

Все методы поддержки формирование последовательности. Метод `generate` должен быть вызван последним и любое изменение формата должно быть вызвано в первую очередь. Например, вы можете запустить любое из следующих действий:

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Сделайте меня QR-кодом!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('Сделайте меня QR-кодом!');

Вы можете отобразить изображение в формате PNG без сохранения файла, предоставляя необработанную строку и кодирование с `base64_encode`.

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Сделайте меня QR-кодом!')) !!} ">

<a id="docs-helpers"></a>
## Хелперы

#### Что такое хелперы?

Хелперы позволяют простой способ для создания QR-код, которые заставляют читателя выполнить определенное действие при сканировании.

#### Электронная Почта

Этот хелпер генерирует QR-код для электронный почты, который в состоянии заполнить адрес электронной почты, тему и текст.

	QrCode::email($to, $subject, $body);
	
	// Заполняет адресата
	QrCode::email('foo@bar.com');
	
	// Заполняет адресата, тему и текст сообщения электронной почты.
	QrCode::email('foo@bar.com', 'Это тема.', 'Это текст.');
	
	// Заполняет только тему и текст сообщения электронной почты.
	QrCode::email(null, 'Это тема.', 'Это текст.');
	
#### Geo

Этот хелпер генерирует широту и долготу, так что телефон может читать и открыть местоположение в Google Maps или подобного приложения.

	QrCode::geo($latitude, $longitude);
	
	QrCode::geo(37.822214, -122.481769);
	
#### Номер телефона

Этот хелпер генерирует QR-код, который можно сканировать, а затем набирает номер.

	QrCode::phoneNumber($phoneNumber);
	
	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');
	
#### СМС(текстовые сообщения)

Этот хелпер создаёт СМС сообщения, которые могут быть уже заполнены с адресом и текстом сообщения.

	QrCode::SMS($phoneNumber, $message);
	
	// Создает СМС где номер телефона уже заполнен.
	QrCode::SMS('555-555-5555');
	
	// Создает СМС где номер и текст уже заполнены.
	QrCode::SMS('555-555-5555', 'текст сообщения.');

#### WiFi

Эти хелперы создают сканируемые QR-коды, которые могут подключить телефон к сети Wi-Fi.

	QrCode::wiFi([
		'encryption' => 'WPA/WEP',
		'ssid' => 'идентификатор сети (SSID)',
		'password' => 'пароль сети',
		'hidden' => 'Если SSID сети явлается скрытым.'
	]);
	
	// Подключается к открытой сети WiFi.
	QrCode::wiFi([
		'ssid' => 'Имя сети',
	]);
	
	// Подключается к открытой, скрытой сети WiFi.
	QrCode::wiFi([
		'ssid' => 'Имя сети',
		'hidden' => 'true'
	]);
	
	// Подключается к защищенной сети.
	QrCode::wiFi([
		'ssid' => 'Имя сети',
		'encryption' => 'WPA',
		'password' => ' Мой пароль'
	]);
	
> Сканирование WiFi в настоящее время не поддерживается на продукты Apple.

<a id="docs-common-usage"></a>
## Распространенное использование QR-кода

Вы можете использовать префикс, найденный в таблице ниже, в секции `generate` чтобы создать QR-код для хранения более расширенной информации:

	QrCode::generate('http://www.simplesoftware.io');


| Применение | Префикс | Пример |
| --- | --- | --- |
| Сылка на сайт | http:// | http://www.simplesoftware.io |
| Обеспеченные URL | https:// | https://www.simplesoftware.io |
| Адрес электронной почты | mailto: | mailto:support@simplesoftware.io |
| Номер телефона| tel: | tel:555-555-5555 |
| Текстовые сообщения (СМС) | sms: | sms:555-555-5555 |
| Текстовые сообщения (СМС) с введенным сообщением | sms: | sms:: Я введенное сообщение |
| Текстовые сообщения (СМС) с введенным сообщением и номером телефона | sms: | sms:555-555-5555: Я введенное сообщение |
| Geo | geo: | geo:-78.400364,-85.916993 |
| MeCard | mecard: | MECARD:Simple, Software;Some Address, Somewhere, 20430;TEL:555-555-5555;EMAIL:support@simplesoftware.io; |
| VCard | BEGIN:VCARD | [Примеры](https://ru.wikipedia.org/wiki/VCard) |
| Wifi | wifi: | wifi:WEP/WPA;SSID;PSK;Hidden(True/False) |

<a id="docs-outside-laravel"></a>
## Использование за пределами Laravel

Вы можете использовать этот пакет за пределами Laravel от инстанцировании нового класса `BaconQrCodeGenerator`.

	use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

	$qrcode = new BaconQrCodeGenerator;
	$qrcode->size(500)->generate('Создайте QR-код без Laravel!');
