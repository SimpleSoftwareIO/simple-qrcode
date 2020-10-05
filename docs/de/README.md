[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode) [![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)

#### [Deutsch](http://www.simplesoftware.io/#/docs/simple-qrcode/de) | [Español](http://www.simplesoftware.io/#/docs/simple-qrcode/es) | [Français](http://www.simplesoftware.io/#/docs/simple-qrcode/fr) | [Italiano](http://www.simplesoftware.io/#/docs/simple-qrcode/it) | [Português](http://www.simplesoftware.io/#/docs/simple-qrcode/pt-br) | [Русский](http://www.simplesoftware.io/#/docs/simple-qrcode/ru) | [日本語](http://www.simplesoftware.io/#/docs/simple-qrcode/ja) | [한국어](http://www.simplesoftware.io/#/docs/simple-qrcode/kr) | [हिंदी](http://www.simplesoftware.io/#/docs/simple-qrcode/hi) | [简体中文](http://www.simplesoftware.io/#/docs/simple-qrcode/zh-cn)

- [Einführung](#docs-introduction)
- [Upgrade-Anleitung](#docs-upgrade)
- [Installation](#docs-configuration)
- [Einfache Anwendungsideen](#docs-ideas)
- [Nutzungsbeispiele](#docs-usage)
- [Helfer](#docs-helpers)
- [Häufig verwendete QrCodes](#docs-common-usage)
- [Verwendung außerhalb von Laravel](#docs-outside-laravel)

<a id="docs-introduction"></a>
## Einführung
Simple QrCode stellt eine komfortable Schnittstelle zum Generieren von QrCodes für das beliebte Laravel Framework dar und basiert auf der großartigen Arbeit von [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode). Das Paket ist einfach zu installieren und bietet ein Laravel-Nutzern vertrautes Nutzererlebnis.   

![Example 1](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/example-1.png?raw=true) ![Example 2](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/example-2.png?raw=true)

<a id="docs-upgrade"></a>
## Upgrade-Anleitung

Um von v2 auf v3 zu aktualisieren, muss die Versionsangabe der `simplesoftwareio/simple-qrcode` Abhängigkeit in der `composer.json` Datei auf `~4` geändert werden:

	"require": {
		"simplesoftwareio/simple-qrcode": "~4"
	}
  
Ein abschließender Aufruf von `composer update simplesoftwareio/simple-qrcode` aktualisiert das installierte Paket.

>Um das `png` Bildformat zu verwenden, **muss zwingend** die `imagick` PHP Extension installiert werden. 

#### v4

Es gab einen Fehler im Bereich der Laravel Facades von v3, der einige Probleme beim Laden verursachte.  Da die Problembehebung eine nicht abwärtskompatible Änderung nötig gemacht hat, wurde v4 veröffentlicht.  Bei einem Upgrade von v2 muss kein Code angepasst werden; die nachfolgende Änderung betrifft nur Nutzer der v3.     

Sämtliche Verweise auf die `QrCode` Facade müssen wie folgt geändert werden:

```
use SimpleSoftwareIO\QrCode\Facades\QrCode;
```

<a id="docs-configuration"></a>
## Installation

#### Composer

Das Paket kann durch Ausführung von `composer require simplesoftwareio/simple-qrcode "~4"` installiert werden. 

Laravel wird das Paket automatisch integrieren.

<a id="docs-ideas"></a>
## Einfache Anwendungsideen

#### Druckansicht

Wir verwenden das Package hauptsächlich dazu, QrCodes auf all unseren Druckansichten zu platzieren.  So können unsere Kunden durch einfaches Scannen des QrCodes auf der ausgedruckten Seite zur Ursprungsseite zurückfinden.  Erreicht haben wir das durch ein Hinzufügen der folgenden Zeilen in unserer footer.blade.php Datei:   

	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>Scan mich, um zur Original-Seite zurückzukehren.</p>
	</div>

#### Einbetten eines QrCodes

Ein QrCode kann in eine E-Mail eingebettet werden, um den Nutzern ein schnelles Scannen zu ermöglichen.  Das folgende Beispiel zeigt, wie man dies mit Laravel umsetzt:

	// Innerhalb eines Blade Templates.
	<img src="{!!$message->embedData(QrCode::format('png')->generate('Bette mich in eine E-Mail ein!'), 'QrCode.png', 'image/png')!!}">

<a id="docs-usage"></a>
## Nutzungsbeispiele

#### Grundfunktionen

```
// Alle Beispiele gehen davon aus, dass die QrCode Facade über die untenstehende Code-Zeile eingebunden wird. Für Laravel Benutzer wird die Facade automatisch geladen. 

use SimpleSoftwareIO\QrCode\Facades\QrCode;
```

Die Verwendung des QrCode Generators ist sehr einfach. Die einfachste Art der Nutzung ist:

	use SimpleSoftwareIO\QrCode\Facades\QrCode;

	QrCode::generate('Wandel mich in einen QrCode!');

Dies wird einen QrCode mit dem Inhalt "Wandel mich in einen QrCode!" generieren.

#### Generate `(string $data, string $filename = null)`

`Generate` wird genutzt, um den QrCode zu generieren.

	QrCode::generate('Wandel mich in einen QrCode!');

Standardmäßig liefert `generate` einen String mit SVG Daten zurück.  Über Laravels Blade Template System kann dieser direkt in modernen Browsern angezeigt werden: 

	{!! QrCode::generate('Wandel mich in einen QrCode!'); !!}

Die `generate` Methode akzeptiert als zweiten Parameter einen Dateipfad zum Speichern des QrCodes in einer Zieldatei:

	QrCode::generate('Wandel mich in einen QrCode!', '../public/qrcodes/qrcode.svg');

#### Format `(string $format)`

Es werden derzeit drei Bildformate unterstützt: `png`, `eps` und `svg`.  Das gewünschte Format kann wie folgt gewählt werden:

	QrCode::format('png');  // Wird ein png zurückliefern
	QrCode::format('eps');  // Wird ein eps zurückliefern
	QrCode::format('svg');  // Wird ein svg zurückliefern

> `imagick` wird benötigt, um ein `png` zu generieren.

#### Size `(int $size)`

Die gewünschte Größe des QrCodes kann über die `size` Methode festgelegt werden.  Dazu wird einfach die gewünschte Größe in Pixel übergeben:

	QrCode::size(100);

![200 Pixels](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/200-pixels.png?raw=true) ![250 Pixels](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/250-pixels.png?raw=true) 

#### Color `(int $red, int $green, int $blue, int $alpha = null)`

>Vorsicht beim Ändern der Farbe eines QrCodes: einige QrCode-Leser haben große Schwierigkeiten, farbige QrCodes zu lesen.

Alle Farben werden im RGBA (Rot, Grün, Blau, Alpha) Format angegeben. Die Farbe eines QrCodes kann wie folgt geändert werden:

	QrCode::color(255, 0, 0); // Roter QrCode
	QrCode::color(255, 0, 0, 25); // Roter QrCode mit 25% Transparenz 

![Red QrCode](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-qrcode.png?raw=true) ![Red Transparent QrCode](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-25-transparent.png?raw=true)

#### Background Color `(int $red, int $green, int $blue, int $alpha = null)`

Die Hintergrundfarbe eines QrCodes kann über die `backgroundColor` Methode geändert werden.

	QrCode::backgroundColor(255, 0, 0); // QrCode mit rotem Hintergrund
	QrCode::backgroundColor(255, 0, 0, 25); // QrCode mit rotem Hintergrund und 25% Transparenz 

![Red Background QrCode](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-background.png?raw=true) ![Red Transparent Background QrCode](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-25-transparent-background.png?raw=true)

#### Gradient `$startRed, $startGreen, $startBlue, $endRed, $endGreen, $endBlue, string $type)`

Einem QrCode kann über die `gradient` Methode ein Farbverlauf zugewiesen werden.

Die folgenden Typen von Gradienten werden unterstützt:

| Typ | Beispiel |
| --- | --- |
| `vertical` | ![Veritcal](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/vertical.png?raw=true) |
| `horizontal` | ![Horizontal](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/horizontal.png?raw=true) |
| `diagonal` | ![Diagonal](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/diagonal.png?raw=true) |
| `inverse_diagonal` | ![Invrse Diagonal](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/inverse_diagonal.png?raw=true) |
| `radial` | ![Radial](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/radial.png?raw=true) |

#### EyeColor `(int $eyeNumber, int $innerRed, int $innerGreen, int $innerBlue, int $outterRed = 0, int $outterGreen = 0, int $outterBlue = 0)`

Die Farben der Positionsmarker können über die `eyeColor` Methode angepasst werden.

| Auge Nr. | Beispiel |
| --- | --- |
| `0` | ![Eye 0](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/eye-0.png?raw=true) |
| `1` | ![Eye 1](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/eye-1.png?raw=true)|
| `2` | ![Eye  2](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/eye-2.png?raw=true) |


#### Style `(string $style, float $size = 0.5)`

Über `square` (quadratisch), `dot` (punktförmig), oder `round` (rund) kann der Stil einfach ausgetauscht werden.  Dies ändert die Datenblöcke innerhalb des QrCodes.  Der zweite Parameter bestimmt die Größe der einzelnen Punkte oder deren Abrundung. 

| Stil | Beispiel |
| --- | --- |
| `square` | ![Square](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/200-pixels.png?raw=true) |
| `dot` | ![Dot](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/dot.png)|
| `round` | ![Round](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/round.png?raw=true) |

#### Eye Style `(string $style)`

Es werden zwei verschiedene Stile von Positionsmarkern unterstützt: `square` (quadratisch) und `circle` (rund).

| Style | Example |
| --- | --- |
| `square` | ![Square](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/200-pixels.png?raw=true) |
| `circle` | ![Circle](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/circle-eye.png?raw=true)|

#### Margin `(int $margin)`

Der Seitenrand des QrCodes kann über die folgende Syntax festgelegt werden:

	QrCode::margin(100);

#### Error Correction `(string $errorCorrection)`

Über die `errorCorrection` Methode kann der anzuwendende Grad der Fehlerkorrektur einfach geändert werden:

	QrCode::errorCorrection('H');

Die folgenden Optionen werden von der Methode unterstützt:

| Fehlerkorrekturstufe | Gewährleistete Sicherheit |
| --- | --- |
| L | 7% der Daten können wiederhergestellt werden. |
| M | 15% der Daten können wiederhergestellt werden. |
| Q | 25% der Daten können wiederhergestellt werden. |
| H | 30% of der Daten können wiederhergestellt werden. |

>Je hoher die Fehlerkorrekturstufe, desto größer wird der resultierende QrCode und desto weniger Daten können in ihm gespeichert werden. Mehr Informationen zur [Fehlerkorrektur](http://de.wikipedia.org/wiki/QR_code#Error_correction) finden sich in der Wikipedia.

#### Encoding `(string $encoding)`

Über die `encoding` Methode kann die für den QrCode verwendete Zeichenkodierung bestimmt werden.  Standardmäßig wird `ISO-8859-1` verwendet. Mehr zur [Zeichenkodierung](https://de.wikipedia.org/wiki/Zeichenkodierung) findet sich in der Wikipedia.

Die folgenden Kodierungen werden unterstützt:

	QrCode::encoding('UTF-8')->generate('Generier mir einen QrCode mit Symbolen ♠♥!!');

| Zeichenkodierung |
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

Die `merge` Methode passt ein Bild in einen QrCode ein.  Üblicherweise wird dies verwendet, um ein Logo in einem QrCode anzuzeigen.

	// Generiert einen QrCode mit einem mittig zentrierten Bild.
	QrCode::format('png')->merge('pfad-zur-bilddatei.png')->generate();
	
	// Generiert einen QrCode mit einem mittig zentrierten Bild.  Das Bild nimmt dabei 30% des QrCodes ein.
	QrCode::format('png')->merge('pfad-zur-bilddatei.png', .3)->generate();
	
	// Generiert einen QrCode mit einem mittig zentrierten Bild.  Das Bild nimmt dabei 30% des QrCodes ein.
	QrCode::format('png')->merge('http://www.google.com/irgendeinbild.png', .3, true)->generate();

>Die `merge` Methode unterstützt derzeit ausschließlich Bilder im PNG Format.
>Der Dateipfad muss relativ zum Basispfad der App angegeben werden, solange `$absolute` auf `false` gesetzt ist.  Ein absoluter Dateipfad wird erwartet, wenn der Parameter auf `true` gesetzt wird.

>Bei Verwendung der `merge` Methode sollte eine hohe Fehlerkorrekturstufe gewählt werden, um sicherzustellen, dass der QrCode lesbar bleibt.  Wir empfehlen eine Nutzung von `errorCorrection('H')`.

![Merged Logo](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### Merge Binary String `(string $content, float $percentage = .2)`

Die `mergeString` Methode entspricht der `merge` Methode, erlaubt aber abweichend den Inhalt einer Bilddatei als String zu übergeben. Dies ist besonders hilfreich, wenn mit der `Storage` Facade gearbeitet wird.   

	// Generiert einen QrCode mit einem mittig zentrierten Bild.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'))->generate();
	
	// Generiert einen QrCode mit einem mittig zentrierten Bild.  Das Bild nimmt dabei 30% des QrCodes ein.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'), .3)->generate();

>Wie auch bei `merge` werden derzeit nur Daten im PNG Format unterstützt. Ebenso wird auch hier die Verwendung einer hohen Fehlerkorrekturstufe empfohlen. 

#### Fortgeschrittene Nutzung

Alle Methoden können verkettet werden.  Dabei muss die `generate` Methode jeweils als letztes aufgerufen werden.  So sind beispielsweise die folgenden Aufrufe möglich: 

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Generier einen QrCode!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('Generier einen QrCode!');

Durch Umwandlung der als String zurückgelieferten binären Bilddaten über `base64_encode` kann der QrCode als PNG Bild angezeigt werden, ohne dieses vorher in einer Datei speichern zu müssen:

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Generier einen QrCode!')) !!} ">

<a id="docs-helpers"></a>
## Helfer

#### Was sind Helfer?

Helfer stellen einen einfachen Weg war, QrCodes zu generieren, die einen QrCode-Leser anweisen, nach dem Scannen eine bestimmte Aktion auszuführen.

#### BitCoin

Dieser Helfer generiert einen QrCode, um BitCoin-Zahlungen anzuweisen. [Weitere Informationen](https://bitco.in/en/developer-guide#plain-text) dazu (in Englisch).

	QrCode::BTC($adresse, $betrag);
	
	// Weist eine Zahlung über 0.334BTC an die angegebene Adresse an.
	QrCode::BTC('bitcoin adresse', 0.334);
	
	// Sendet eine Zahlung über 0.334BTC an die Adresse mit zusätzlichen optionalen Parametern.
	QrCode::size(500)->BTC('adresse', 0.0034, [
        'label' => 'Meine Kennzeichnung',
        'message' => 'Meine Nachricht',
        'returnAddress' => 'https://www.rueckkehrurl.com'
    ]);

#### E-Mail

Dieser Helfer generiert einen E-Mail QrCode, der automatisch die Zieladresse, Betreff und einen Text im E-Mail-Programm befüllt:

	QrCode::email($an, $betreff, $nachricht);
	
	// Füllt die Zieladresse aus.
	QrCode::email('foo@bar.com');
	
	// Füllt die Zieladresse, das Betreff und die Nachricht einer E-Mail aus.
	QrCode::email('foo@bar.com', 'Dies ist das Betreff.', 'Dies ist die Nachricht.');
	
	// Füllt nur Betreff und Nachricht aus.
	QrCode::email(null, ''Dies ist das Betreff.', 'Dies ist die Nachricht.');
	
#### Geo

Dieser Helfer generiert einen QrCode mit Positionsinformationen über Angabe eines Breiten- und Längengrads, die ein Smartphone lesen und in Google Maps oder einer ähnlichen App darstellen kann.

	QrCode::geo($breitengrad, $laengengrad);
	
	QrCode::geo(37.822214, -122.481769);
	
#### Telefonnummer

Dieser Helfer generiert einen QrCode, der den QrCode-Leser anweist, eine Telefonnummer anzuwählen.

	QrCode::phoneNumber($telefonNummer);
	
	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');
	
#### SMS Nachrichten

Über diesen Helfer können Nachrichten in der SMS App vorab mit der Nummer und dem Text ausgefüllt werden:

	QrCode::SMS($telefonNummer, $nachricht);
	
	// Generiert eine leere SMS mit vorbefüllter Telefonnummer.
	QrCode::SMS('555-555-5555');
	
	// Generiert eine SMS mit vorbefüllter Telefonnummer und Nachricht.
	QrCode::SMS('555-555-5555', 'Nachricht');

#### WiFi

Dieser Helper generiert QrCodes, die gescannt werden können um ein Mobilgerät mit einem Drahtlosnetzwerk zu verbinden:

	QrCode::wiFi([
		'encryption' => 'WPA/WEP',
		'ssid' => 'SSID des Netzwerks',
		'password' => 'Passwort des Netzwerks',
		'hidden' => 'Bestimmt ob die SSID des Netzwerks versteckt ist oder nicht.'
	]);
	
	// Verbindet zu einem offenen Drahtlosnetzwerk.
	QrCode::wiFi([
		'ssid' => 'Netzwerkname',
	]);
	
	// Verbindet zu einem offenen Drahtlosnetzwerk mit geheimer SSID.
	QrCode::wiFi([
		'ssid' => 'Netzwerkname',
		'hidden' => 'true'
	]);
	
	// Verbindet zu einem gesicherten Drahtlosnetzwerk mit WPA Verschlüsselung.
	QrCode::wiFi([
		'ssid' => 'Nerzwerkname',
		'encryption' => 'WPA',
		'password' => 'Netzwerkpasswort'
	]);
	
>WiFi QrCodes werden aktuell nicht von Apple-Produkten unterstützt.

<a id="docs-common-usage"></a>
## Häufig verwendete QrCodes

Dem Inhaltsparameter der `generate` Methode kann ein Präfix vorangestellt werden, um auf schnelle Weise einen QrCode mit komplexeren Informationen zu generieren:

	QrCode::generate('http://www.simplesoftware.io');


| Verwendung | Präfix | Beispiel |
| --- | --- | --- |
| Webseiten URL | http:// | http://www.simplesoftware.io |
| Sichere URL | https:// | https://www.simplesoftware.io |
| E-mail Adresse | mailto: | mailto:support@simplesoftware.io |
| Telefonnummer | tel: | tel:555-555-5555 |
| SMS | sms: | sms:555-555-5555 |
| SMS mit vorbefüllter Nachricht | sms: | sms::Ich bin eine vorbefüllte Nachricht |
| SMS mit vorbefüllter Nachricht und Nummer | sms: | sms:555-555-5555:Ich bin eine vorbefüllte Nachricht |
| Geo-Position | geo: | geo:-78.400364,-85.916993 |
| MeCard | mecard: | MECARD:Simple, Software;Eine Adresse, Irgendwo, 20430;TEL:555-555-5555;EMAIL:support@simplesoftware.io; |
| VCard | BEGIN:VCARD | [Beispiele auf Wikipedia](https://de.wikipedia.org/wiki/VCard) |
| Wifi | wifi: | wifi:WEP/WPA;SSID;PSK;Versteckt(True/False) |

<a id="docs-outside-laravel"></a>
## Verwendung außerhalb von Laravel

Dieses Paket kann auch ohne Laravel verwendet werden, indem man eine neue Instanz der `Generator` Klasse erzeugt.

	use SimpleSoftwareIO\QrCode\Generator;

	$qrcode = new Generator;
	$qrcode->size(500)->generate('Generiere einen QrCode ohne Laravel!');
