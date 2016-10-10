Simple QrCode
========================

[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode)
[![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)

- [Introducción](#docs-introduction)
- [Traducciones](#docs-translations)
- [Configuración](#docs-configuration)
- [Ideas Simples](#docs-ideas)
- [Uso](#docs-usage)
- [Helpers](#docs-helpers)
- [Uso Común de QrCode](#docs-common-usage)
- [Uso fuera de Laravel](#docs-outside-laravel)

<a id="docs-introduction"></a>
## Introducción
Simple QrCode es un empaquetador de fácil uso para el popular framework Laravel basado en el gran trabajo proporcionado por [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode).  Hemos creado una interfaz que es familiar y fácil de usar para los usuarios de Laravel.

<a id="docs-translations"></a>
## Traducciones
Estamos buscando usuarios que hablen Árabe, Francés, Coreano o Japonés para traducir este documento.  Porfavor cread una pull request si podeis ayudar con una traducción!

<a id="docs-configuration"></a>
## Configuración

#### Composer

Primero, añadir el paquete Simple QrCode en su `require` en su archivo `composer.json`:

	"require": {
		"simplesoftwareio/simple-qrcode": "~1"
	}

Luego, ejecutar el comando `composer update`.

#### Service Provider

###### Laravel 4
Registrar `SimpleSoftwareIO\QrCode\QrCodeServiceProvider` en su `app/config/app.php` dentro del array `providers`.

###### Laravel 5
Registrar `SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class` en su `config/app.php` dentro del array `providers`.

#### Aliases

###### Laravel 4
Finalmente, registrar `'QrCode' => 'SimpleSoftwareIO\QrCode\Facades\QrCode'` en su archivo de configuración `app/config/app.php` dentro del array `aliases`.

###### Laravel 5
Finalmente, registrar `'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class` en su archivo de configuración `config/app.php` dentro del array `aliases`.

<a id="docs-ideas"></a>
## Ideas Simples

#### Print View

Uno de los principales usos de este paquete es la posibilidad de disponer QrCodes en todas nuestras print views.  Esto permite a nuestros usuarios volver a la página original después de imprimir simplemente escaneando el código.  Todo esto es posible añadiendo lo siguiente en nuestro archivo `footer.blade.php´.

	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>Escanéame para volver a la página principal.</p>
	</div>

#### Incorporar un QrCode

Puedes incorporar un código Qr en un e-mail para permitir a los usuarios un ágil escaneo.  El ejemplo siguiente muestra como hacer esto con Laravel.

	//Inside of a blade template.
	<img src="{!!$message->embedData(QrCode::format('png')->generate('Incorpórame en un e-mail!'), 'QrCode.png', 'image/png')!!}">

<a id="docs-usage"></a>
## Uso

#### Uso Básico

Usar el QrCode Generator es muy simple.  La sintaxis más básica es:

	QrCode::generate('Transfórmame en un QrCode!');

Esto creara un código que diga "Transfórmame en un QrCode!"

#### Generate

`Generate` se usa para crear el QrCode.

	QrCode::generate('Transfórmame en un QrCode!');

>Atención! Este método debe de ser usado el último si se usa dentro de una cadena de comandos (chain).

`Generate` por defecto devolverá un string de una imagen SVG.  Puedes imprimirla directamente en un navegador moderno con el sistema Blade de Laravel con el siguiente código:

	{!! QrCode::generate('Transfórmame en un QrCode!'); !!}

El método `generate` tiene un segundo parámetro que aceptará un nombre de archivo y un directorio para guardar el QrCode.

	QrCode::generate('Transfórmame en un QrCode!', '../public/qrcodes/qrcode.svg');

#### Cambio de Formato

>QrCode Generator por defecto devolverá una imagen SVG.

>Atención! El método `format` tiene que ser usado antes que cualquier opción de formato como `size`, `color`, `backgroundColor`, o `margin`.

Actualmente hay 3 formatos compatibles; PNG, EPS, and SVG.  Para cambiar el formato usa el siguiente código:

	QrCode::format('png');  //Devolvera una imagen PNG
	QrCode::format('eps');  //Devolvera una imagen EPS
	QrCode::format('svg');  //Devolvera una imagen SVG

#### Cambio de Tamaño

>QrCode Generator devolverá por defecto el tamaño de píxels mínimo para crear el QrCode.

Puedes cambiar el tamaño de un QrCode usando el método `size`. Simplemente especifica el tamaño deseado en píxels usando el siguiente código:

	QrCode::size(100);

#### Cambio de Color  

>Presta atención al cambiar el color de un QrCode.  Algunos lectores tienen dificultades al leer QrCodes en color.

Todos los colores deben ser expresados en RGB (Red Green Blue).  Puedes cambiar el color del QrCode usando el siguiente código:

	QrCode::color(255,0,255);

Para cambiar el color del fondo usamos:

	QrCode::backgroundColor(255,255,0);

#### Cambio de Márgenes

Es posible cambiar el márgen alrededor del QrCode.  Simplemente especificamos el márgen deseado usando el siguiente código:

	QrCode::margin(100);

#### Corrección de Errores

Cambiar el nivel de corrección de errores es fácil.  Unicamente usa el siguiente código:

	QrCode::errorCorrection('H');

Las siguientes opciónes son compatibles con el método de `errorCorrection`.

| Error Correction | Assurance Provided |
| --- | --- |
| L | 7% of codewords can be restored. |
| M | 15% of codewords can be restored. |
| Q | 25% of codewords can be restored. |
| H | 30% of codewords can be restored. |

>Cuanto más corrección de error se usa; el QrCode aumenta y puede almacenar menos datos. Para saber más sobre [corrección de error](http://en.wikipedia.org/wiki/QR_code#Error_correction).

#### Encoding

Para cambiar la codificación de carácteres que se usa para crear un QrCode.  Por defecto `ISO-8859-1` está seleccionado.  Para saber más sobre [codificación de carácteres](http://en.wikipedia.org/wiki/Character_encoding) You can change this to any of the following:

	QrCode::encoding('UTF-8')->generate('Transfórmame en un QrCode con símbolos especiales ♠♥!!');

| Codificador de carácteres |
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

>Un error de `Could not encode content to ISO-8859-1` significa que se esta usando una codificación de carácteres incorrecta.  Recomendamos `UTF-8` si no está seguro.

#### Merge

El método `merge` une una imagen con un QrCode.  Normalmente se usa para añadir logos en un QrCode.

	QrCode::merge($filename, $percentage, $absolute);
	
	//Genera un QrCode con una imagen en el centro.
	QrCode::format('png')->merge('path-to-image.png')->generate();
	
	//Genera un QrCode con una imagen en el centro.  La imagen ocupa un 30% del QrCode.
	QrCode::format('png')->merge('path-to-image.png', .3)->generate();
	
	//Genera un QrCode con una imagen en el centro.  La imagen ocupa un 30% del QrCode.
	QrCode::format('png')->merge('http://www.google.com/someimage.png', .3, true)->generate();

>El método `merge` sólo es compatible con PNG de momento.
>El path del archivo es relativo al path de la app si `$absolute` equivale a `false`.  Cambia esta variable a `true` para usar paths absolutos.

>Se debería usar un nivel alto de corrección de error al usar `merge` para asegurarse que el QrCode se sigue podiendo leer.  Recomendamos usar `errorCorrection('H')`.

![Merged Logo](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### Merge Binary String

El método `mergeString` se puede usar para conseguir el mismo resultado que con `merge`, con la diferencia que permite proveer una representación en string del archivo en vez de el filepath. Ésto es útil al trabajar con el `Storage` facade. Su interfaz es muy similar a la de `merge`. 

	QrCode::mergeString(Storage::get('path/to/image.png'), $percentage);
	
	//Genera un QrCode con una imagen en el centro.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'))->generate();
	
	//Genera un QrCode con una imagen en el centro.  La imagen ocupa un 30% del QrCode.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'), .3)->generate();

>Igual que con `merge`, sólo PNG de momento. Lo mismo que con el nivel de corrección de error, alto nivel está recomendado.

#### Uso Avanzado

Todos los métodos soportan chaining.  El método `generate` tiene que ser el último y cualquier cambio de `format` tiene que ser llamado primero. Por ejemplo:

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Transfórmame en un QrCode!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('Transfórmame en un QrCode!');

Puedes mostrar una imagen PNG sin guardar el archivo usando una string y eligiendo la codificación `base64_encode`.

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Transfórmame en un QrCode!')) !!} ">

<a id="docs-helpers"></a>
## Helpers

#### Qué son los helpers?

Los helpers son una manera fácil de crear QrCodes que causan que causan una acción en el lector al escanear.  

#### E-Mail

Este helper genera un QrCode de e-mail que es capaz de rellenar dirección e-mail, asunto, y el cuerpo del e-mail.

	QrCode::email($to, $subject, $body);
	
	//Rellena la dirección
	QrCode::email('foo@bar.com');
	
	//Rellena la dirección, el asunto y el cuerpo.
	QrCode::email('foo@bar.com', 'This is the subject.', 'This is the message body.');
	
	//Solo rellena el asunto y el cuerpo del e-mail.
	QrCode::email(null, 'This is the subject.', 'This is the message body.');
	
#### Geo

Este helper genera una latitude y una longitude que un teléfono puede leer y abrir la localización en Google Maps o alguna app similar.

	QrCode::geo($latitude, $longitude);
	
	QrCode::geo(37.822214, -122.481769);
	
#### Phone Number

Este helper genera un QrCode que puede ser escaneado y llama a un número de teléfono.

	QrCode::phoneNumber($phoneNumber);
	
	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');
	
#### SMS (Mensajes de texto)

Este helper crea SMS que pueden ser previamente rellenados con la dirección y el mensaje.

	QrCode::SMS($phoneNumber, $message);
	
	//Crea un mensaje de texto con el número rellenado.
	QrCode::SMS('555-555-5555');
	
	//Crea un mensaje de texto con el número y el mensaje rellenados.
	QrCode::SMS('555-555-5555', 'Mensaje');

#### WiFi

Este helpers crea QrCodes que conectan un teléfono a una red WiFI.

	QrCode::wiFi([
		'encryption' => 'WPA/WEP',
		'ssid' => 'SSID de la red',
		'password' => 'Password de la red',
		'hidden' => 'Si la red tiene SSID oculta o no.'
	]);
	
	//Conecta a una red abierta.
	QrCode::wiFi([
		'ssid' => 'Network Name',
	]);
	
	//Conecta a una red abierta y oculta.
	QrCode::wiFi([
		'ssid' => 'Network Name',
		'hidden' => 'true'
	]);
	
	//Conecta a una red segura.
	QrCode::wiFi([
		'ssid' => 'Network Name',
		'encryption' => 'WPA',
		'password' => 'myPassword'
	]);
	
>WiFi scanning no es compatible con productos Apple.

<a id="docs-common-usage"></a>
##Uso común de QrCode

Puedes usar un prefijo de la tabla dentro de la sección `generate` para crear un QrCode que almacene informacion avanzada:

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
##Uso fuera de Laravel

Puedes usar este paquete fuera de Laravel instanciando una nueva clase `BaconQrCodeGenerator`.

	use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

	$qrcode = new BaconQrCodeGenerator;
	$qrcode->size(500)->generate('Crea un QrCode sin Laravel!');
