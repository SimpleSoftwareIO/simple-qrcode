[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode) [![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)

- [Introduction](#docs-introduction)
- [Traductions](#docs-translations)
- [Configuration](#docs-configuration)
- [Utilisations Simples](#docs-ideas)
- [Usage](#docs-usage)
- [Helpers](#docs-helpers)
- [Usage Courant De QrCode](#docs-common-usage)
- [Usage Hors De Laravel](#docs-outside-laravel)

<a id="docs-introduction"></a>
## Introduction
Simple QrCode est un adaptateur facile d'utilisation pour le framework Laravel et qui s'appuie sur le magnifique travail fourni par [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode). Nous avons conçu une interface intuitive, facile d'installation et familière aux utilisateurs de Laravel.

<a id="docs-translations"></a>
## Traductions
Nous recherchons des utilisateurs parlant arabe, espagnol, français, coréen ou japonnais pour nous aider à traduire cette documentation. Si vous vous en sentez capable, créez une pull request ! 

<a id="docs-configuration"></a>
## Configuration

#### Composer

Commencez par ajouter le paquet QrCode à la section `require` de votre fichier `composer.json`: 

	"require": {
		"simplesoftwareio/simple-qrcode": "~2"
	}

Lancez ensuite la commande `composer update`.

#### Service Provider

###### Laravel <= 5.4
Ajouter l'entrée `SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class` au tableau `providers` du fichier de configuration `config/app.php`.

#### Alias

###### Laravel <= 5.4
Enfin, ajoutez l'entrée `'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class` au tableau `aliases` du fichier de configuration `config/app.php`.

<a id="docs-ideas"></a>
## Utilisations Simples

#### Print View

L'un des pricipaux usages que nous faisons de ce paquet et d'avoir des QrCodes dans toutes nos vues d'impression. Cela donne la possibilité à nos clients qui le flashent de revenir à la page d'origine du document après que celui-ci a été imprimé. Nous obtenons cette fonctionnalité en ajoutant le code suivant au fichier footer.blade.php.

	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>Flashez-moi pour revenir à la page d'origine.</p>
	</div>

#### Embarquer Un QrCode

Vous pouvez embarquer un qrcode dans un courriel pour permettre à vos utilisateurs de le flasher. Voici un exemple pour mettre ceci en œuvre dans Laravel :

	// Dans un template blade.
	<img src="{!!$message->embedData(QrCode::format('png')->generate('Embarquez-moi dans un courriel!'), 'QrCode.png', 'image/png')!!}">

<a id="docs-usage"></a>
## Usage

#### Usage De Base

L'utilisation du Générateur de QrCode est très simple. La syntaxe minimale est :

	QrCode::generate('Transformez-moi en QrCode !');

Cela créera un QrCode qui dit "Transformez-moi en QrCode !"

#### Generate

`Generate` sert à fabriquer un QrCode.

	QrCode::generate('Transformez-moi en QrCode !');

>Attention! Cette méthode doit être appelée en dernier si vous l'utilisez dans un appel chaîné.

Par défaut, `Generate` retournera le contenu d'une image SVG sous forme de chaîne. Vous pouvez afficher cette image directement avec un navigateur moderne dans un template Blade de Laravel de cette façon :

	{!! QrCode::generate('Transformez-moi en QrCode !'); !!}

La méthode `generate` accepte un second paramètre pour définir un nom de fichier où enregistrer le QrCode.

	QrCode::generate('Transformez-moi en QrCode !', '../public/qrcodes/qrcode.svg');

#### Changement De Format

>Le générateur de QrCode est prévu pour retourner une image SVG par défaut.

>Attention! La méthode `format` doit être appelée avant toute autre option de formatage, telles que `size`, `color`, `backgroundColor` et `margin`.

Trois formats sont actuellement supportés : PNG, EPS et SVG. Pour changer de format, utilisez le code suivant : 

	QrCode::format('png');  // retourne une image PNG
	QrCode::format('eps');  // retourne une image EPS
	QrCode::format('svg');  // retourne une image SVG

#### Changement De Taille

>Le générateur de QrCode retournera par défaut le QrCode dans la plus petite taille possible en pixels.

Vous pouvez changer la taille du QrCode par la méthode `size` qui prend comme paramètre la taille désirée en pixels :

	QrCode::size(100);

#### Changement De Couleur

>Changez les couleurs de vos QrCode avec précaution car certains lecteurs rencontrent des difficultés avec les QrCodes en couleur.

Toutes les couleurs doivent être exprimées en RGB (rouge, vert, bleu). Vous pouvez changer la couleur de trait du QrCode par la méthode `color` :

	QrCode::color(255,0,255);

La couleur de fond peut être définie de la même façon par la méthode `backgroundColor` :

	QrCode::backgroundColor(255,255,0);

#### Changement Des Marges

Vous pouvez définir une marge autour du QrCode par la méthode `margin` :

	QrCode::margin(100);

#### Correction D'Erreur

Il est très aisé de changer le niveau de correction d'erreur. Utilisez la syntaxe suivante :

	QrCode::errorCorrection('H');

Voici la liste des options supportées pour la méthode `errorCorrection`.

| Correction d'Erreur | Capacité De Correction |
| --- | --- |
| L | 7% de redondance. |
| M | 15% de redondance. |
| Q | 25% de redondance. |
| H | 30% de redondance. |

>L'élévation du niveau de correction d'erreur se fait au détriment de la taille du QrCode et de la quantité de données qu'il peut stocker. Pour en savoir plus, consultez [error correction](http://en.wikipedia.org/wiki/QR_code#Error_correction) (en anglais).

#### Encodage

La norme de codage par défaut des caractères contenus dans le QrCode est l'`ISO-8859-1`. Pour en savoir plus sur le codage, voyez [codage des caractères](http://fr.wikipedia.org/wiki/Codage_des_caractères). Vous pouvez changer le codage par le code suivant :

	QrCode::encoding('UTF-8')->generate('Transformez-moi en QrCode avec des symboles ♠♥!!');

| Codage Des Caractères |
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

>Une erreur du type `Could not encode content to ISO-8859-1` signifie qu'un mauvais codage est utilisé.  Nous recommendons `UTF-8` si vous n'êtes pas sûr.

#### Merge

La méthode `merge` fusionne une image sur un QrCode. C'est une pratique courante pour placer un logo dans un QrCode.

	QrCode::merge($nom_de_fichier, $pourcentage, $absolu);
	
	// Génère un QrCode avec une image centrée.
	QrCode::format('png')->merge('chemin-vers-l-image.png')->generate();
	
	// Génère un QrCode avec une image centrée. L'image recouvre jusque 30% du QrCode.
	QrCode::format('png')->merge('chemin-vers-l-image.png', .3)->generate();
	
	// Génère un QrCode avec une image centrée. L'image recouvre jusque 30% du QrCode.
	QrCode::format('png')->merge('http://www.google.com/someimage.png', .3, true)->generate();

>La méthode `merge` ne supporte que les images PNG.
>Le chemin vers l'image est relatif au chemin de base de l'application si $absolu est à `false`. Changez cette variable à `true` pour utiliser des chemins absolus.

> Vous devriez utiliser un haut niveau de correction d'erreur avec la méthode `merge` pour assurer la bonne lecture du QrCode. Nous recommandons l'utilisation de `errorCorrection('H')`.

![Fusion de Logo](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### Fusion De Chaîne Binaire

La méthode `mergeString` est semblable à la méthode `merge` si ce n'est qu'elle prend comme paramètre le contenu du fichier sous forme de chaîne au lieu du nom du fichier. C'est particulièrement utile lorsque vous travaillez avec une façade `Storage`. L'interface de `mergeString` est très similaire à celle de `merge`.

	QrCode::mergeString(Storage::get('chemin/vers/image.png'), $percentage);
	
	// Génère un QrCode avec une image centrée.
	QrCode::format('png')->mergeString(Storage::get('chemin/vers/image.png'))->generate();
	
	// Génère un QrCode avec une image centrée. L'image recouvre jusque 30% du QrCode.
	QrCode::format('png')->mergeString(Storage::get('chemin/vers/image.png'), .3)->generate();

>A l'instar de la méthode `merge`, seul le format d'image PNG est supporté. Les même recommandations relatives à la correction d'erreur s'appliquent.

#### Utilisation Avancée

Toutes les méthodes supportent le chaînage. La méthode `generate` doit être appelée en dernier et toute modification du `format` en premier. Vous pourriez par exemple écrire :

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Transformez-moi en QrCode!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('Transformez-moi en QrCode!');

Vous pouvez afficher une image PNG sans enregistrer de fichier en spécifiant une chaîne brute encodée avec `base64_encode`.

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Transformez-moi en QrCode!')) !!} ">

<a id="docs-helpers"></a>
## Helpers

#### Que sont les helpers?

Les helpers facilitent la création de QrCodes qui déclenchent une action du lecteur lorsqu'ils sont flashés.

#### E-Mail

Cet helper génère un QrCode pour l'envoi de courriel dont les destinataire, sujet et contenu peuvent être prédéfinis.

	QrCode::email($destinataire, $sujet, $contenu);
	
	// Renseigne l'adresse du destinataire
	QrCode::email('foo@bar.com');
	
  // Renseigne le destinataire, le sujet et le contenu du courriel
	QrCode::email('foo@bar.com', 'Ceci est le sujet.', 'Ceci est le contenu.');
	
  // Ne renseigne que le sujet et le contenu du courriel
	QrCode::email(null, 'Ceci est le sujet.', 'Ceci est le contenu.');
	
#### Geo

Cet helper génère un QrCode avec des coordonnées géographiques (latitude et longitude) qui pourront être ouvertes par une application Google Maps ou similaire.

	QrCode::geo($latitude, $longitude);
	
	QrCode::geo(37.822214, -122.481769);
	
#### Numéro de Téléphone

Cet helper génère un QrCode qui lorsqu'il est flashé compose un numéro de téléphone.

	QrCode::phoneNumber($numeroDeTelephone);
	
	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');
	
#### SMS (Messages Texte)

Cet helper génère un QrCode d'envoi de SMS dont le destinataire et le message peuvent être prédéfinis.

	QrCode::SMS($numeroDeTelephone, $message);
	
  // Crée un SMS pour un numéro de téléphone
	QrCode::SMS('555-555-5555');
	
  // Crée un SMS pour un numéro de téléphone avec un message
	QrCode::SMS('555-555-5555', 'Corps du message');

#### WiFi

Cet helper génère un QrCode qui permet la connexion à un réseau WiFi.

	QrCode::wiFi([
		'encryption' => 'WPA/WEP',
		'ssid' => 'SSID du réseau',
		'password' => 'Mot de passe de connexion',
		'hidden' => 'Indique si le SSID du réseau est masqué ou non.'
	]);
	
  // Connexion à un réseau WiFi ouvert
	QrCode::wiFi([
		'ssid' => 'Nom du réseau',
	]);
	
  // Connexion à un réseau WiFi ouvert et masqué
	QrCode::wiFi([
		'ssid' => 'Nom du réseau',
		'hidden' => 'true'
	]);
	
  // Connexion à un réseau WiFi sécurisé
	QrCode::wiFi([
		'ssid' => 'Nom du réseau',
		'encryption' => 'WPA',
		'password' => 'Mot de passe'
	]);
	
>La recherche de réseaux WiFi n'est actuellement pas supportée par les produis Apple.

<a id="docs-common-usage"></a>
## Usage Courant des QrCodes

Vous pouvez utiliser un des pseudos-protocoles du tableau suivant comme paramètre de la méthode `generate` pour créer un QrCode contenant des informations avancées :

	QrCode::generate('http://www.simplesoftware.io');


| Usage | Protocole | Exemple |
| --- | --- | --- |
| URL de site internet | http:// | http://www.simplesoftware.io |
| URL de site internet sécurisé | https:// | https://www.simplesoftware.io |
| Adresse de courriel | mailto: | mailto:support@simplesoftware.io |
| Numéro de téléphone | tel: | tel:555-555-5555 |
| SMS | sms: | sms:555-555-5555 |
| SMS avec message pré-défini | sms: | sms::I am a pretyped message |
| SMS avec message et numéro de téléphone pré-définis | sms: | sms:555-555-5555:I am a pretyped message |
| Coordonnées géographiques | geo: | geo:-78.400364,-85.916993 |
| MeCard | mecard: | MECARD:Simple, Software;Some Address, Somewhere, 20430;TEL:555-555-5555;EMAIL:support@simplesoftware.io; |
| VCard | BEGIN:VCARD | [Voir les exemples](https://fr.wikipedia.org/wiki/Code_QR#Correction_d.27erreur) |
| Wifi | wifi: | wifi:WEP/WPA;SSID;PSK;Hidden(True/False) |

<a id="docs-outside-laravel"></a>
##Usage Hors De Laravel

Vous pouvez utiliser ce paquet en dehors de Laravel en instanciant un objet de classe `BaconQrCodeGenerator`.

	use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

	$qrcode = new BaconQrCodeGenerator;
	$qrcode->size(500)->generate('Créer un qrcode sans Laravel!');
