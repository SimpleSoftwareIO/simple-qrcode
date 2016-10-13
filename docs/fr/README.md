Simple QrCode
========================

[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode)
[![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)

####[Español](https://www.simplesoftware.io/docs/simple-qrcode/es) | [Italiano](https://www.simplesoftware.io/docs/simple-qrcode/it) | [Português](https://www.simplesoftware.io/docs/simple-qrcode/pt-br) | [Русский](https://www.simplesoftware.io/docs/simple-qrcode/ru) | [हिंदी](https://www.simplesoftware.io/docs/simple-qrcode/hi) | [汉语](https://www.simplesoftware.io/docs/simple-qrcode/zh)

- [Introduction](#docs-introduction)
- [Translations](#docs-translations)
- [Configuration](#docs-configuration)
- [Simple Ideas](#docs-ideas)
- [Usage](#docs-usage)
- [Helpers](#docs-helpers)
- [Common QrCode Usage](#docs-common-usage)
- [Usage Outside of Laravel](#docs-outside-laravel)

<a id="docs-introduction"></a>
## Introduction
Simple QrCode est un wrapper facile à utiliser pour le framework populaire Laravel basé sur le large travail fourni par [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode).  Nous avons créé une interface qui est familière et facile à installer pour les utilisateurs de Laravel.

<a id="docs-translations"></a>
## Traductions
Nous cherchons des utilisateurs parlant Arabe, Espagnol, Coréen ou Japonais pour aider à traduire ce document.  Créez une pull request si vous pouvez faire une traduction !

<a id="docs-configuration"></a>
## Configuration

#### Composer

Premièrement, ajoutez le paquet Simple QrCode dans votre `require` de votre fichier `composer.json` :

	"require": {
		"simplesoftwareio/simple-qrcode": "~1"
	}

Ensuite, exécutez la commande `composer update`.

#### Service Provider

###### Laravel 4
Enregistrez le `SimpleSoftwareIO\QrCode\QrCodeServiceProvider` dans votre fichier `app/config/app.php` à l'intérieur de la liste `providers`.

###### Laravel 5
Enregistrez le `SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class` dans votre fichier `config/app.php` à l'intérieur de la liste `providers`.

#### Alias

###### Laravel 4
Finalement, enregistrez le `'QrCode' => 'SimpleSoftwareIO\QrCode\Facades\QrCode'` dans votre fichier de configuration `app/config/app.php` à l'intérieur de la liste `aliases`.

###### Laravel 5
Finalement, enregistrez le `'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class` dans votre fichier de configuration `config/app.php` à l'intérieur de la liste `aliases`.

<a id="docs-ideas"></a>
## Idées simples

#### Vues d'impression

L'une des raisons pour laquelle on utilise ce paquet est d'avoir des QrCodes dans toutes nos vues d'impression.  Ceci permet à nos clients de retourner à la page originale après qu'elle ait été imprimée en scannant simplement le code.  Nous avons fait ceci en ajoutant le suivant dans notre fichier `footer.blade.php`.

	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>Scanne moi pour retourner à la page originale.</p>
	</div>

#### Intégrer un QrCode

Vous pouvez intégrer un qrcode dans un e-mail pour permettre à vos utilisateur de le scanner rapidement.  Ci-après est un exemple de comment faire ceci avec Laravel.

	//Dans un template blade.
	<img src="{!!$message->embedData(QrCode::format('png')->generate('Integrez-moi dans un e-mail!'), 'QrCode.png', 'image/png')!!}">

<a id="docs-usage"></a>
## Utilisation

#### Utilisation basique

Utiliser le générateur QrCode est très facile.  La syntaxe la plus basique est :

	QrCode::generate('Make me into a QrCode!');

Ceci va faire un QrCode qui dit "Make me into a QrCode!"

#### Generate

`Generate` est utilisé pour créer le QrCode.

	QrCode::generate('Make me into a QrCode!');

>Attention ! Cette méthode doit être appelée en dernier si utilisée dans une chaîne.

`Generate` va retourner par défaut une chaîne de caractères d'image SVG.  Vous pouvez affichez ceci directement dans un navigateur moderne à l'intérieur du system Laravel Blade avec le suivant :

	{!! QrCode::generate('Make me into a QrCode!'); !!}

La méthode `generate` a un second paramètre qui va accepter un nom de fichier et un chemin pour sauvegarder le QrCode.

	QrCode::generate('Make me into a QrCode!', '../public/qrcodes/qrcode.svg');

#### Changement du format

>QrCode Generator est configuré pour retourner une image SVG par defaut.

>Attention ! La méthode `format` doit être appelée avant les autres opions de formattage telles que `size`, `color`, `backgroundColor` et `margin`.

Trois formats sont actuellement supportés : PNG, EPS et SVG.  Pour changer le format, utilisez le code suivant :

	QrCode::format('png');  //Va retourner une image PNG
	QrCode::format('eps');  //Va retourner une image EPS
	QrCode::format('svg');  //Va retourner une image SVG

#### Changement de la taille

>QrCode Generator va par défaut retourner la plus petite taille possible en pixels pour créer le QrCode.

Vous pouvez changer la taille d'un QrCode en utilisant la méthode `size`. Spécifiez simplement la taille désirée en pixels en utilisant la syntaxe suivante :

	QrCode::size(100);

#### Changement de la couleur

>Faites attention lorsque vous changez la couleur d'un QrCode.  Certains lecteurs éprouvent beaucoup de difficulté en lisant des QrCodes colorés.

Toutes les coulers peuvent être exprimées en RVB (Rouge Vert Bleu).  Vous pouvez changer la couleur d'un QrCode en utilisant la ligne suivante :

	QrCode::color(255,0,255);

Les changements de couleur d'arrière-plan sont également supportés et peuvent être exprimés de la même façon.

	QrCode::backgroundColor(255,255,0);

#### Changement de la marge

La possibilité de changer la marge autour d'un QrCode est également supportée.  Spécifiez simplement la marge désirée en utilisant la syntaxe suivante :

	QrCode::margin(100);

#### Correction d'erreur

Changer le niveau de correction d'erreur est facile.  Utilisez juste la syntaxe suivante :

	QrCode::errorCorrection('H');

Les options suivantes sont supportées pour la méthode `errorCorrection`.

| Correction d'erreur | Assurance fournie |
| --- | --- |
| L | 7% des mots de code peuvent être restaurés. |
| M | 15% des mots de code peuvent être restaurés. |
| Q | 25% des mots de code peuvent être restaurés. |
| H | 30% des mots de code peuvent être restaurés. |

>Plus le niveau de correction d'erreur est élevé, plus le QrCode devient gros et moins il peut stocker de données. Lisez plus à propos de la [correction d'erreur](https://fr.wikipedia.org/wiki/Code_QR#Correction_d.27erreur).

#### Encodage

Changez l'encodage de caractères utilisé pour construire un QrCode.  Par défaut l'encodeur `ISO-8859-1` est sélectionné.  Lisez plus à propos du [codage des caractères](https://fr.wikipedia.org/wiki/Codage_des_caractères) Vous pouvez changer ceci en l'un des suivants:

	QrCode::encoding('UTF-8')->generate('Make me a QrCode with special symbols ♠♥!!');

| Encodeur de caractères |
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

>Une erreur `Could not encode content to ISO-8859-1` signifie que le mauvais type d'encodage de caractères est utilisé.  Nous recommandons `UTF-8` si vous n'êtes pas sûr.

#### Merge

La méthode `merge` fusionne une image au dessus d'un QrCode.  This is commonly used to placed logos within a QrCode.

	QrCode::merge($filename, $percentage, $absolute);

	//Génère un QrCode avec une image centrée au milieu.
	QrCode::format('png')->merge('path-to-image.png')->generate();

	//Génère un QrCode avec une image centrée au milieu.  L'image insérée prend jusqu'à 30% du QrCode.
	QrCode::format('png')->merge('path-to-image.png', .3)->generate();

	//Génère un QrCode avec une image centrée au milieu.  L'image insérée prend jusqu'à 30% du QrCode.
	QrCode::format('png')->merge('http://www.google.com/someimage.png', .3, true)->generate();

>La méthode `merge` ne supporte actuellement que les PNG.
>The filepath is relative to app base path if `$absolute` is set to `false`.  Change this variable to `true` to use absolute paths.

>Vous devriez utiliser un haut niveau de correction d'erreur lorsque vous utilisez la méthode `merge` afin de vous assurer que le QrCode est encore lisible.  Nous recommendons d'utiliser `errorCorrection('H')`.

![Merged Logo](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### Merge Binary String

La méthode `mergeString` peut être utilisée pour accomplir la même chose que l'appel `merge`, mais il vous permet de fournir un représentation en chaîne de caractère du fichier au lieu du chemin vers le fichier. C'est utile lorsque vous travaillez avec la facade `Storage`. Son interface est relativement similaire à l'appel `merge`.

	QrCode::mergeString(Storage::get('path/to/image.png'), $percentage);

	//Génère un QrCode avec une image centrée au milieu.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'))->generate();

	//Génère un QrCode avec une image centrée au milieu.  L'image insérée prend jusqu'à 30% du QrCode.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'), .3)->generate();

>Comme pour l'appel normal `merge`, seuls les PNG sont supportés actuellement. La même chose s'applique pour la correction d'erreur, de hauts niveaux sont recommandés.

#### Utilisation Avancée

Toutes les méthodes supportent l'enchaînement.  La méthode `generate` doit être appelée en dernier et tout changement `format` doit être appelé en premier.  Par exemple vous pouvez exécuter les lignes suivantes :

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Make me a QrCode!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('Make me a QrCode!');

Vous pouvez afficher une image PNG sans sauvegarder le fichier en fournissant une chaîne brute et encodée avec `base64_encode`.

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) !!} ">

<a id="docs-helpers"></a>
## Assistants

#### Que sont les assistants?

Les assistants sont une façon facile de créer des QrCodes qui font faire une certaine action à un lecteur lorsque scanné.  

#### E-Mail

Cet assistant génère un qrcode e-mail qui peut remplir l'adresse email, le sujet et le corps du message.

	QrCode::email($to, $subject, $body);

	//Remplit l'adresse du destinataire
	QrCode::email('foo@bar.com');

	//Remplit l'adresse du destinataire, le sujet et le corps d'un e-mail.
	QrCode::email('foo@bar.com', 'Ceci est le sujet.', 'Ceci est le corps du message.');

	//Remplit juste le sujet et le corps d'un e-mail.
	QrCode::email(null, 'Ceci est le sujet.', 'Ceci est le corps du message.');

#### Geo

Cet assistant génère une latitude et une longitude qu'un téléphone peut lire et ouvrir la localisation dans Google Maps ou une application similaire.

	QrCode::geo($latitude, $longitude);

	QrCode::geo(37.822214, -122.481769);

#### Numéro de téléphone

Cet assistant génère un QrCode qui peut être scanné puis compose un numéro.

	QrCode::phoneNumber($phoneNumber);

	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');

#### SMS (Messages Texto)

Cet assistant créé des messages SMS qui peuvent être préremplis avec le numéro du destinataire et le corps du messages.

	QrCode::SMS($phoneNumber, $message);

	//Créé un message texte avec le numéro rempli.
	QrCode::SMS('555-555-5555');

	//Créé un message texte avec le numéro et le message remplis.
	QrCode::SMS('555-555-5555', 'Corps du message');

#### WiFi

Cet assistant créé des QrCodes scannables qui peuvent connecter un téléphone à un réseau WiFI.

	QrCode::wiFi([
		'encryption' => 'WPA/WEP',
		'ssid' => 'SSID du réseau',
		'password' => 'Mot de passe du réseau',
		'hidden' => 'Si réseau est un SSID caché ou non.'
	]);

	//Connecte à un réseau WiFi ouvert.
	QrCode::wiFi([
		'ssid' => 'Nom du réseau',
	]);

	//Connecte à un réseau WiFi ouvert et caché.
	QrCode::wiFi([
		'ssid' => 'Nom du réseau',
		'hidden' => 'true'
	]);

	//Connecte à un réseau WiFi sécurisé.
	QrCode::wiFi([
		'ssid' => 'Nom du réseau',
		'encryption' => 'WPA',
		'password' => 'myPassword'
	]);

>Le scan WiFi n'est actuellement pas supporté sur les produits Apple.

<a id="docs-common-usage"></a>
##Utilisation QrCode Commune

Vous pouvez utiliser un préfixe trouvé dans le tableau ci-dessous dans la section `generate` pour créer un QrCode pour stocker des informations plus avancées :

	QrCode::generate('http://www.simplesoftware.io');


| Utilisation | Préfixe | Exemple |
| --- | --- | --- |
| URL Website | http:// | http://www.simplesoftware.io |
| URL sécurisée | https:// | https://www.simplesoftware.io |
| Adresse E-mail | mailto: | mailto:support@simplesoftware.io |
| Numéro de téléphone | tel: | tel:555-555-5555 |
| Texto (SMS) | sms: | sms:555-555-5555 |
| Texto (SMS) avec message prétapé | sms: | sms::I am a pretyped message |
| Texto (SMS) avec message prétapé et numéro | sms: | sms:555-555-5555:I am a pretyped message |
| Address géographique | geo: | geo:-78.400364,-85.916993 |
| MeCard | mecard: | MECARD:Simple, Software;Some Address, Somewhere, 20430;TEL:555-555-5555;EMAIL:support@simplesoftware.io; |
| VCard | BEGIN:VCARD | [See Examples](https://en.wikipedia.org/wiki/VCard) |
| Wifi | wifi: | wifi:WEP/WPA;SSID;PSK;Hidden(True/False) |

<a id="docs-outside-laravel"></a>
##Utilisation en dehors de Laravel

Vous pouvez utiliser ce paquet en dehors de Laravel en instanciant une nouvelle classe `BaconQrCodeGenerator`.

	use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

	$qrcode = new BaconQrCodeGenerator;
	$qrcode->size(500)->generate('Make a qrcode without Laravel!');
