[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode) [![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)


- [Introduzione](#docs-introduction)
- [Traduzioni](#docs-translations)
- [Configurazione](#docs-configuration)
- [Semplici Utilizzi](#docs-ideas)
- [Utilizzo](#docs-usage)
- [Helpers](#docs-helpers)
- [Uso generico dei QrCode](#docs-common-usage)
- [Uso al di fuori di Laravel](#docs-outside-laravel)

<a id="docs-introduction"></a>
## Introduzione
Simple QrCode è un semplice wrapper per il popolare framework Laravel basato sul bellissimo lavoro [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode). Abbiamo creato un'interfaccia familiare e semplice da installare per gli utenti Laravel.

<a id="docs-translations"></a>
## Traduzioni
Siamo alla ricerca di utenti che ci aiutino a tradurre la documentazione in Arabo, Spagnolo, Francese, Coreano o Giapponese. Se pensate di potercela fare non esitate a fare una pull request!

<a id="docs-configuration"></a>
## Configurazione

#### Composer

Per prima cosa, aggiungete il pacchetto di Simple QrCode al file `require` in `composer.json`:

	"require": {
		"simplesoftwareio/simple-qrcode": "~2"
	}

Ora lanciate il comando `composer update`.

#### Service Provider

###### Laravel <= 5.4
Registrate `SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class` nel vostro `config/app.php` all'interno dell'array `providers`.

#### Alias

###### Laravel <= 5.4
Infine, registrate `'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class` nel vostro file di configurazione `config/app.php` all'interno dell'array `aliases`.

<a id="docs-ideas"></a>
## Semplici Utilizzi

#### Print View

Uno degli usi principali di questo pacchetto è la possibilità di avere codici Qr in tutte le nostre print views. Questo permette all'utente di tornare alla pagina originale semplicemente facendo lo scan del codice. Tutto ciò è possibile aggiungendo le seguenti linee nel nostro footer.blade.php.

	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>Scansionami per tornare alla pagina principale.</p>
	</div>

#### Incorporare un QrCode

Potreste incorporare un codice Qr in una e-mail per permettere agli utenti uno scan immediato. Il seguente è un esempio di come potresti fare tutto ciò con Laravel.

	//Inside of a blade template.
	<img src="{!!$message->embedData(QrCode::format('png')->generate('Incorporami in una e-mail!'), 'QrCode.png', 'image/png')!!}">

<a id="docs-usage"></a>
## Utilizzo

#### Utilizzo Base

Usare il generatori di codici Qr è molto semplice. La sintassi più semplice è:

	QrCode::generate('Trasformami in un QrCode!');

Questo comando produrrà un codice Qr che dice "Trasformami in un QrCode!"

#### Generate

`Generate` è usato per creare codici Qr:

	QrCode::generate('Trasformami in un QrCode!');

>Attenzione! Questo metodo deve essere chiamato per ultimo se lo si usa all'interno di una catena (chain).

`Generate` restituirà, di default, una stringa di immagini SVG. Puoi stamparla direttamente in un browser recente dal sistema Blade di Laravel con il seguente codice:

	{!! QrCode::generate('Make me into a QrCode!'); !!}

Il metodo `generate` accetta un secondo parametro che indica la directory nella quale verrà salvato il codice Qr.

	QrCode::generate('Make me into a QrCode!', '../public/qrcodes/qrcode.svg');

#### Variazione del formato

>QrCode Generator è impostato di default per generare immagini SVG.

>Attenzione! Il metodo `format` deve essere chiamato prima di qualunque altra opzione di formato come `size`, `color`, `backgroundColor`, o `margin`.

Momentaneamente, sono supportati tre formati: PNG, EPS e SVG. Per cambiare il formato usare uno dei seguenti comandi:

	QrCode::format('png');  //Genererà un'immagine PNG
	QrCode::format('eps');  //Genererà un'immagine EPS
	QrCode::format('svg');  //Genererà un'immagine SVG

#### Variazione della grandezza

>QrCode Generator restituirà, di default, la più piccola grandezza possibile per creare il QrCode.

Puoi cambiare la grandezza del codice Qr usando il metodo `size`. Basta specificare la grandezza desiderata, in pixel, usando la seguente sintassi:

	QrCode::size(100);

#### Variazione del colore

>Fai attenzione quando cambi il colore di un QrCode! Alcuni lettori potrebbero avere dei problemi a leggere dei codici Qr colorati diversamente.

Tutti i colori dovranno essere espressi in RGB (Rosso Verde Blu). Puoi cambiare il colore di un QrCode usando questa sintassi:

	QrCode::color(255,0,255);

Puoi anche cambiare il colore di sfondo con la seguente istruzione:

	QrCode::backgroundColor(255,255,0);

#### Variazione del margine

E' anche possibile variare il margine attorno al codice Qr. Basta infatti specificare la grandezza del margine nella seguente sintassi:

	QrCode::margin(100);

#### Correzione dell'errore

Cambiare il livello di correzione dell'errore è facile. Per farlo, usare questa sintassi:

	QrCode::errorCorrection('H');

Seguono le opzioni supportate dal metodo `errorCorrection`.

| Error Correction | Assurance Provided |
| --- | --- |
| L | 7% of codewords can be restored. |
| M | 15% of codewords can be restored. |
| Q | 25% of codewords can be restored. |
| H | 30% of codewords can be restored. |

>Più error correction viene usata, più sarà grande il QrCode e meno dati sarà in grando di contenere. Leggi di più a riguardo [error correction](http://en.wikipedia.org/wiki/QR_code#Error_correction).

#### Encoding

Puoi cambiare l'encoding dei caratteri utilizzato per creare il codice Qr. Di default è selezionato `ISO-8859-1`. Leggi di più a riguardo [character encoding](http://en.wikipedia.org/wiki/Character_encoding)
Puoi cambiare l'encoding utilizzando:

	QrCode::encoding('UTF-8')->generate('Trasformami in un QrCode con simboli speciali ??!!');

| Encoder dei caratteri |
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

>L'errore `Could not encode content to ISO-8859-1` significa che si sta usando l'encoding erraro. E' raccomandato usare `UTF-8` se non si è sicuri.

#### Merge

Il metodo `merge` unisce un immagine con un QrCode. Il merge è molto usato per inserire loghi in un codice Qr.

	QrCode::merge($filename, $percentage, $absolute);
	
	//Genera un QrCode con una immagine al centro.
	QrCode::format('png')->merge('path-to-image.png')->generate();
	
	//Genera un QrCode con una immagine al centro. L'immagine inserita occupa il 30% del codice Qr.
	QrCode::format('png')->merge('path-to-image.png', .3)->generate();
	
	//Genera un QrCode con una immagine al centro. L'immagine inserita occupa il 30% del codice Qr.
	QrCode::format('png')->merge('http://www.google.com/someimage.png', .3, true)->generate();

>Il metodo `merge` supporta solamente il formato PNG.
>Il percorso specificato è relativo alla base path se `$absolute` è impostata su `false`. Cambiare questa variabile in `true` per utilizzare percorsi assoluti.

>Dovresti usare un alto livello di error correction quando usi il metodo `merge` per assicurarti che il Qr sia ancora leggibile. Raccomandiamo di usare `errorCorrection('H')`.

![Merged Logo](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### Merge Binary String

Il metodo `mergeString` può essere usato per ottenere quasi lo stesso risultato di `merge`, con la differenza che permette di inserire una rappresentazione testuale del file al posto del percorso. Questo è utile quando si lavora con la facade `Storage`. La sua interfaccia è molto simile a quella di `merge`. 

	QrCode::mergeString(Storage::get('path/to/image.png'), $percentage);
	
	//Genera un QrCode con una immagine al centro.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'))->generate();
	
	//Genera un QrCode con una immagine al centro. L'immagine inserita occupa il 30% del codice Qr.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'), .3)->generate();

>Come la chiamata a `merge`, anche questa volta è supportato solamente il formato PNG. Lo stesso vale per gli error correction, H è il valore raccomandato.

#### Utilizzo Avanzato

Tutti i metodi supportano il chaining. Il metodo `generate` deve essere chiamato per ultimo e tutti gli eventuali metodi `format` devono essere chiamati per primi. Per esempio sono validi i seguenti:

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Make me a QrCode!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('Trasformami in un QrCode!');

Puoi mostrare un'immagine PNG senza salvare il file relativo impostando una stringa e scegliendo l'encoding `base64_encode`.

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Trasformami in un QrCode!')) !!} ">

<a id="docs-helpers"></a>
## Helpers

#### Cosa sono gli helpers?

Gli Helpers sono un metodo molto semplice per creare codici Qr che permettono al lettore di eseguire una certa azione quando scansionati.

#### E-Mail

Questo helper genera un QrCode in grado di riempire i campi di una e-mail quali indirizzo, oggetto e corpo.

	QrCode::email($to, $subject, $body);
	
	//Fills in the to address
	QrCode::email('foo@bar.com');
	
	//Fills in the to address, subject, and body of an e-mail.
	QrCode::email('foo@bar.com', 'Questo è l'oggetto.', 'Questo è il corpo del messaggio.');
	
	//Fills in just the subject and body of an e-mail.
	QrCode::email(null, 'Questo è l'oggetto.', 'Questo è il corpo del messaggio.');
	
#### Geo

Questo helper genera una latitudine e una longitudine che un telefono può leggere ed aprire con Google Maps o applicazioni simili.

	QrCode::geo($latitude, $longitude);
	
	QrCode::geo(37.822214, -122.481769);
	
#### Numeri di Telefono

Questo helper genera un QrCode che, una volta scansionato, digita un numero di telefono.

	QrCode::phoneNumber($phoneNumber);
	
	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');
	
#### SMS (Messaggi)

Questo helper crea messaggi SMS che possono essere precompilati con il destinatario e il corpo del messaggio.

	QrCode::SMS($phoneNumber, $message);
	
	//Creates a text message with the number filled in.
	QrCode::SMS('555-555-5555');
	
	//Creates a text message with the number and message filled in.
	QrCode::SMS('555-555-5555', 'Corpo del messaggio.');

#### WiFi

Questo helper crea codici Qr scansionabili che permettono la connessione del telefono ad una determinata rete WiFi.

	QrCode::wiFi([
		'encryption' => 'WPA/WEP',
		'ssid' => 'SSID della rete',
		'password' => 'Password della rete',
		'hidden' => 'Whether the network is a hidden SSID or not.'
	]);
	
	//Connects to an open WiFi network.
	QrCode::wiFi([
		'ssid' => 'Nome Rete',
	]);
	
	//Connects to an open, hidden WiFi network.
	QrCode::wiFi([
		'ssid' => 'Nome Rete',
		'hidden' => 'true'
	]);
	
	//Connects to an secured, WiFi network.
	QrCode::wiFi([
		'ssid' => 'Nome Rete',
		'encryption' => 'WPA',
		'password' => 'miaPassword'
	]);
	
>La scansione WiFi non è al momento supportata sui dispositivi Apple.

<a id="docs-common-usage"></a>
##Uso generico dei QrCode

Puoi utilizzare un prefisso della tabella sottostante per generare dei codici Qr in grado di contenere maggiori informazioni:

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
##Uso al di fuori di Laravel

Puoi usare questo package al di fuori di Laravel istanziando una nuova classe `BaconQrCodeGenerator`.

	use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

	$qrcode = new BaconQrCodeGenerator;
	$qrcode->size(500)->generate('Crea un QrCode senza Laravel!');
