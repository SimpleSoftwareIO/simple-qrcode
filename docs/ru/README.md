[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode) [![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)


- [Введение](#docs-introduction)
- [Переводы](#docs-translations)
- [Конфигурация](#docs-configuration)
- [Простые Идеи](#docs-ideas)
- [Использование](#docs-usage)
- [Хелперы](#docs-helpers)
- [Префиксы](#docs-common-usage)
- [Использование без Laravel](#docs-outside-laravel)

<a id="docs-introduction"></a>
## Введение

Simple QrCode - простая в использовании обёртка для популярного фреймворка Laravel на основе превосходного проекта [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode).
Мы создали интерфейс, который привычен и прост в установке для пользователей Laravel.

<a id="docs-translations"></a>
## Переводы

Мы ищем пользователей, говорящих на китайском, корейском или японском языках, которые могут помочь перевести этот документ. 
Пожалуйста, создайте пул реквест, если вы можете сделать перевод!

<a id="docs-configuration"></a>
## Конфигурация

### Composer

Находясь в директории вашего проекта laravel, выполните команду:

```bash
composer require simplesoftwareio/simple-qrcode
```

Либо добавьте пакет `simplesoftwareio/simple-qrcode` в раздел `require` файла `composer.json`:

```json
"require": {
    "simplesoftwareio/simple-qrcode": "~2"
}
```

Затем запустите команду `composer update`.

### Поставщик услуг (Laravel <= 5.4)

Добавьте строчку 
```
SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class
``` 
в конец массива `providers` в файле `config/app.php`.

### Алиас (Laravel <= 5.4)

Добавьте строчку 
```
'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class
``` 
в конец массива `aliases` в файле `config/app.php`.

<a id="docs-ideas"></a>
## Простые Идеи

### Печать страниц

Мы используем QR-коды на страница для печати.
Это позволяет нашим клиентам открыть исходную страницу на устройстве после печати, просто отсканировав этот код.
Для этого в файл `footer.blade.php` мы добавили следующий код:

```blade
<div class="visible-print text-center">
    {!! QrCode::size(100)->generate(Request::url()); !!}
    <p>Отсканируйте QR-код, чтобы открыть исходную страницу</p>
</div>
```

### Вставка QR-кода в email

Вы можете вставить QR-код в email, чтобы позволить пользователям быстро его отсканировать.
Ниже приведен пример того, как сделать это с помощью Laravel:

```blade
// внутри шаблона blade
<img src="{!!$message->embedData(QrCode::format('png')->generate('Введете меня в сообщение по электронный почте!'), 'QrCode.png', 'image/png')!!}">
```

<a id="docs-usage"></a>
## Использование

### Общий случай использования

Использовать генератор для QR-код очень легко. 
Достаточно вызвать один метод:

```php
QrCode::generate('Lorem ipsum!');
```

Этот код создаст QR-код с текстом "Lorem ipsum!".

### Генерация изображений

Используйте метод `generate()`, чтобы создать изображение QR-кода:

```php
QrCode::generate('Lorem ipsum!');
```

> Внимание! При вызове в цепочке методов этот метод должен вызываться в конце.

Метод `generate()` по умолчанию возвращает строку, содержащую SVG-представление изображения. 
Поэтому её можно вывести как есть прямо в браузер внутри Blade-шаблона:

```blade
{!! QrCode::generate('Lorem ipsum!'); !!}
```

Чтобы сохранить изображение QR-кода в файл, передайте методу `generate()` путь к файлу вторым аргументом:

```blade
QrCode::generate('Lorem ipsum!', '../public/qrcodes/qrcode.svg');
```

### Изменение формата

> По умолчанию QR-код создаётся в формате SVG.

> **Обратите внимание!** Метод `format()` должен вызываться **перед** всеми остальными методами форматирования, такими как `size()`, `color()`, `backgroundColor()` и `margin()`.

На данный момент поддерживаются три формата: PNG, EPS и SVG.
Для изменения формата используйте следующий код:

```php
QrCode::format('png');
QrCode::format('eps');
QrCode::format('svg');
```

### Изменение размера

> По умолчанию QR-код создаётся наименьшего размера.

Вы можете изменить размер QR-код с помощью метода `size()`. 
Просто укажите размер желаемого в пикселях, используя следующий синтаксис:

```php
QrCode::size(100);
```

### Изменение цветов

> Будьте осторожны при изменении цветов QR-кода.
> Это может затруднить его сканирование.

Вы можете изменить цвет клеток на изображении.
Для этого следует использовать метод `color()`.
Три аргумента этого метода - значения RGB-палитры соответственно.

Например, так можно сделать клетки розовыми:

```php
QrCode::color(255, 0, 255);
```

Также поддерживается изменение цвета фона методом `backgroundColor()`.
Например, следующий код сделает фон не белым, а жёлтым:

```php
QrCode::backgroundColor(255, 255, 0);
```

### Поля

Вы можете изменить внутренние поля изображения.
Это поможет повысить вероятность успешного сканирования.

Просто укажите количество пикселей между краем изображения и матрицей:

```php
QrCode::margin(100);
```

### Уровень коррекции ошибок

Для изменения уровня коррекции ошибок используйте следующий метод:

```php
QrCode::errorCorrection('H');
```

Метод `errorCorrection()` поддерживает следующие уровни:

| Уровень | Допуск ошибок |
| ------- | ------------- |
|    L    |       7%      |
|    M    |      15%      |
|    Q    |      25%      |
|    H    |      30%      |

> Чем выше уровень коррекции, тем больше становится QR-код и тем меньше данных он может хранить. 
> [Подробнее](https://ru.wikipedia.org/wiki/QR-%D0%BA%D0%BE%D0%B4#.D0.9E.D0.B1.D1.89.D0.B0.D1.8F_.D1.82.D0.B5.D1.85.D0.BD.D0.B8.D1.87.D0.B5.D1.81.D0.BA.D0.B0.D1.8F_.D0.B8.D0.BD.D1.84.D0.BE.D1.80.D0.BC.D0.B0.D1.86.D0.B8.D1.8F).

### Кодировка символов

По умолчанию используется кодировка `ISO-8859-1`.
[Подробнее о кодировках символов](https://ru.wikipedia.org/wiki/%D0%9D%D0%B0%D0%B1%D0%BE%D1%80_%D1%81%D0%B8%D0%BC%D0%B2%D0%BE%D0%BB%D0%BE%D0%B2). 

Вы можете кодировку, используя метод `encoding()`:

```php
QrCode::encoding('UTF-8')->generate('‘Lorem ipsum со специальными символами ♠♥!!');
```

Полный список поддерживаемых кодировок:

| Кодировка    |
| ------------ |
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

> Ошибка `Could not encode content to ISO-8859-1` означает, что вы передали в метод `generate()` строку, символы которой невозможно перевести в ISO-8859-1.
> Если вы не уверены какую кодировку использовать в вашем случае, то перед вызовом `generate()` установите кодировку `UTF-8`.

### Наложение изображений на QR-код (из файла)

Метод `merge()` накладывает указанное изображение на QR-код.
Это обычно используется для логотипов, размащаемых в пределах QR-кода.

```php
QrCode::merge($filename, $percentage, $absolute);

// Создает QR-код с изображением в центре
QrCode::format('png')->merge('path-to-image.png')->generate();

// Создает QR-код с изображением в центре
// Вставленное изображение занимает 30% QR-кода
QrCode::format('png')->merge('path-to-image.png', .3)->generate();
QrCode::format('png')->merge('http://www.google.com/someimage.png', .3, true)->generate();
```

> На данный момент метод `merge()` поддерживает только PNG.

> По умолчанию путь к файлу считается относительно `base_path()` вашего проекта.
> Если вы указываете абсолютный путь к файлу, то передайте `true` третьим аргументом.

> Вы должны использовать высокий уровень коррекции ошибок при использовании метода `merge()` чтобы QR-код остался читаемым. 
> Рекомендуется использовать `errorCorrection('H')`.

![Merged Logo](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

### Наложение изображений на QR-код (из двоичной строки)

Метод `mergeString()` может быть использован для решения той же задачи, что и `merge()`. 
Отличие в том, что `mergeString()` принимает строковое представление файла вместо пути к файлу. 
Это полезно при работе с фасадом `Storage`. 
Этот интерфейс очень похож на вызов `merge()`.

> Как и в случае с `merge()`, здесь поддерживается только PNG-формат. 
> То же самое относится к коррекции ошибок - рекомендуется использовать высокие уровни.

### Дополнительный функционал

Все методы поддерживают последовательный вызов.

Вызывайте метод `generate()` в последнюю очередь, после применения форматирования.

Примеры последовательных вызовов:

```php
QrCode::size(250)
      ->color(150, 90, 10)
      ->backgroundColor(10, 14, 244)
      ->generate('Lorem ipsum!');
QrCode::format('png')
      ->size(399)
      ->color(40, 40, 40)
      ->generate('Lorem ipsum!');
```

Вы можете отобразить в браузере PNG-изображение без его сохранения в файл, выводя закодированную при помощи `base64_encode()` необработанную строку:

```blade
<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Lorem ipsum!')) !!} ">
```

<a id="docs-helpers"></a>
## Хелперы

### Что такое хелперы?

Хелперы предоставляют простой способ создания QR-кода, который заставляет сканер пользователя выполнить определенное действие.

### Электронная Почта

Этот хелпер генерирует QR-код для создания email.
Можно указать email адресата, тему и текст письма.

```php
QrCode::email($to, $subject, $body);

// Заполняет адресата
QrCode::email('foo@bar.com');

// Заполняет адресата, тему и текст сообщения электронной почты.
QrCode::email('foo@bar.com', 'Это тема', 'Это текст');

// Заполняет только тему и текст сообщения электронной почты.
QrCode::email(null, 'Это тема', 'Это текст');
```
	
### Geo

Этот хелпер генерирует QR-код с координатами точки на карте.
Для этого нужно указать её широту и долготу.
Смартфон пользователя может открыть указанное местоположение в Google Maps или другом приложении карт.

```php
QrCode::geo($latitude, $longitude);
QrCode::geo(37.822214, -122.481769);
```
	
### Номер телефона

Этот хелпер генерирует QR-код, при помощи которого можно быстро совершить звонок:

```php
QrCode::phoneNumber($phoneNumber);
QrCode::phoneNumber('555-555-5555');
QrCode::phoneNumber('1-800-Laravel');
```
	
### СМС

Этот хелпер создаёт СМС-сообщение, в котором уже может быть указан номер телефона адресата и текст сообщения:

```php
QrCode::SMS($phoneNumber, $message);

// Создает СМС, где номер телефона уже заполнен.
QrCode::SMS('555-555-5555');

// Создает СМС, где номер и текст уже заполнены.
QrCode::SMS('555-555-5555', 'текст сообщения.');
```

### WiFi

Эти хелперы создают QR-коды, которые помогут подключить смартфон к Wi-Fi:

```php
QrCode::wiFi([
    'encryption' => 'WPA/WEP',
    'ssid' => 'идентификатор сети (SSID)',
    'password' => 'пароль сети',
    'hidden' => 'является ли сеть скрытой (true/false)'
]);

// Подключается к открытой сети WiFi.
QrCode::wiFi([
    'ssid' => 'Имя сети',
]);

// Подключается к открытой или скрытой сети WiFi.
QrCode::wiFi([
    'ssid' => 'Имя сети',
    'hidden' => 'true'
]);

// Подключается к защищенной сети.
QrCode::wiFi([
    'ssid' => 'Имя сети',
    'encryption' => 'WPA',
    'password' => 'Мой пароль'
]);
```
	
> Сканирование WiFi в настоящее время не поддерживается устройствами Apple.

<a id="docs-common-usage"></a>
## Префиксы

Вы можете использовать префиксы вместо хелперов.
Составьте строку по образцу, как в таблице ниже, и передайте её в метод `generate()`, чтобы добиться того же эффекта, как при использовании хелперов:

```php
QrCode::generate('http://www.simplesoftware.io');
```

| Применение | Префикс | Пример |
| --- | --- | --- |
| Ссылка на сайт | http:// | http://www.simplesoftware.io |
| Безопасная ссылка | https:// | https://www.simplesoftware.io |
| Email | mailto: | mailto:support@simplesoftware.io |
| Телефон для звонка | tel: | tel:555-555-5555 |
| СМС | sms: | sms:555-555-5555 |
| СМС с текстом сообщения | sms: | sms::Какое-то сообщение |
| СМС с текстом сообщения и номером адресата | sms: | sms:555-555-5555:Какое-то сообщение |
| Местоположение на карте | geo: | geo:-78.400364,-85.916993 |
| Визитка (MeCard) | mecard: | MECARD:Simple, Software;Some Address, Somewhere, 20430;TEL:555-555-5555;EMAIL:support@simplesoftware.io; |
| Контакт (VCard) | BEGIN:VCARD | [Примеры](https://ru.wikipedia.org/wiki/VCard) |
| Wifi | wifi: | wifi:WEP/WPA;SSID;PSK;Hidden(True/False) |

<a id="docs-outside-laravel"></a>
## Использование без Laravel

Вы можете использовать этот пакет за пределами Laravel, просто создав новый объект класса `BaconQrCodeGenerator`.

```php
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

$qrcode = new BaconQrCodeGenerator;
$qrcode->size(500)->generate('Создайте QR-код без Laravel!');
```
