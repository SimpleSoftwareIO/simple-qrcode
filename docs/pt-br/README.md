Simple QrCode
========================

[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode)
[![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)
[![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)

- [Introdução](#docs-introduction)
- [Traduções](#docs-translations)
- [Configuração](#docs-configuration)
- [Simples ideias](#docs-ideas)
- [Uso](#docs-usage)
- [Helpers](#docs-helpers)
- [Uso comum do QrCode](#docs-common-usage)
- [Uso sem Laravel](#docs-outside-laravel)

<a id="docs-introduction"></a>
## Introdução
Simple QrCode é wrapper de fácil uso do Framework Laravel, baseado no grande trabalho provide pelo [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode). Criamos uma interface que é fácil e familiar de instalar para usuários Laravel.

<a id="docs-translations"></a>
## Traduções
 Estamos procurando por usuário que falem Árabe, Espanhol, Francês, Coreano ou Japonês, para nos ajudar a traduzir este documento. Por favor, crie um pull request if você é capar de fazer uma tradução!

<a id="docs-configuration"></a>
## Configuração

#### Composer

Primeiramente, adicione o pacote Simple QrCode ao seu `require` no arquivo `composer.json`:

	"require": {
		"simplesoftwareio/simple-qrcode": "~1"
	}

Próximo, execute o comando `composer update`.

#### Provedor de Serviço

###### Laravel 4
Registre o `SimpleSoftwareIO\QrCode\QrCodeServiceProvider` em seu `app/config/app.php` dentro do array`providers`.

###### Laravel 5
Registre a `SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class` em seu `config/app.php` dentro do array `providers`.

#### Aliases

###### Laravel 4
Finalmente, registre o `'QrCode' => 'SimpleSoftwareIO\QrCode\Facades\QrCode'` em seu arquivo de configuração `app/config/app.php` dentro do array `aliases`.

###### Laravel 5
Finally, register the `'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class` em seu arquivo de configuração `config/app.php` dentro do array `aliases`.

<a id="docs-ideas"></a>
## Simple Ideas

#### Print View

Um dos principais itens que utilizam este pacote para é ter QRCodes em todos os nossos pontos de vista de impressão. Isto permite que nossos clientes para retornar para a página original depois de impresso, basta digitalizar o código. Conseguimos isso adicionando o seguinte em nosso arquivo footer.blade.php.

	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>Scan me to return to the original page.</p>
	</div>

#### Embarcando um QrCode

Você pode incorporar um qrcode dentro de um e-mail, que permita que seus usuários escaneiem rapidamente. Abaixo, um exemplo de como fazer isso utilizando o Laravel.

	//Inside of a blade template.
	<img src="{!!$message->embedData(QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png')!!}">

<a id="docs-usage"></a>
## Uso

#### Uso Básico

É muito fácil utilizar o gerador de Qrcode. A sintaxe mais básica é:

	QrCode::generate('Me transforme em um QrCode!');

Isso criará um Qr que diz "Me transforme em um QrCode!"

#### Generate

`Generate` é usado para criar o QrCode.

	QrCode::generate('Me transforme em um QrCode!');

>Atenção! Esse método deve ser chamado por último dentro da cadeia.

`Generate` por padrão irá retornar uma string de imagem SVG. Você pode exibir diretamente em seu browser, utilizando o Laravel's Blade com o código abaixo:

	{!! QrCode::generate('Me transforme em um QrCode!'); !!}

O método `generate` tem um segundo parametro que aceita um arquivo e um path para salvar o Qrcode.

	QrCode::generate('Me transforme em um QrCode!', '../public/qrcodes/qrcode.svg');

#### Alteração de Formato

>Por padrão o gerador de QrCode está configurado para retornar uma imagem SVG.

>Cuidao! O método `format` deve ser chamado antes de qualquer outra opção de formatação como `size`, `color`, `backgroundColor` e `margin`.

Atualmente são suportados três tipos de formatos; PNG, EPS, and SVG. Para alterar o formato, use o seguinte código:

	QrCode::format('png');  //Retornará uma imagem no formato PNG
	QrCode::format('eps');  //Retornará uma imagem no formato EPS
	QrCode::format('svg');  //Retornará uma imagem no formato SVG

#### Alteração de Tamanho

>Por padrão, o gerador QrCode retornará o menos tamanho possível em pixels para criar o QrCode.

Você pode alterar o tamanho do QrCode usando o método `size`. Simplesmente especificando o tamanho desejado em pixels usando a seguinte sintaze:

	QrCode::size(100);

#### Alteração de cor

>Cuidado quando estiver alterando a cor de um QRCode. Alguns leitores tem uma grande dificuldade em ler QrCodes coloridos.

Todas as cores devem ser definidas em RGB(Red Green Blue). Você pode alterar a cor de um qrCode usando o código abaixo.  You can change the color of a QrCode by using the following:

	QrCode::color(255,0,255);

Alterações do plano de fundo também são suportadas e definidas da mesma maneira.

	QrCode::backgroundColor(255,255,0);

#### Alteração de Margem

A capacidade de alterar a margem ao redor do QrCode também é suportada. Simplesmente especifique o tamenho desejado da margem, utilizando a sintaxe abaixo:

	QrCode::margin(100);

#### Correção de erros

Alterar o nível de correção de erros é simples. Utilize a seguinte sintaxe:

	QrCode::errorCorrection('H');

As seguintes opções são suportadas para o método `errorCorrection`.

| Error Correction | Assurance Provided |
| --- | --- |
| L | 7% of codewords can be restored. |
| M | 15% of codewords can be restored. |
| Q | 25% of codewords can be restored. |
| H | 30% of codewords can be restored. |

>The more error correction used; the bigger the QrCode becomes and the less data it can store. Read more about [error correction](http://en.wikipedia.org/wiki/QR_code#Error_correction).

#### Codificação

Alterar a codificação que é usada para criar um QrCode. Por padrão, a encodificação padrão é a `ISO-8859-1`. Leia mais sobre [character encoding](https://pt.wikipedia.org/wiki/Codifica%C3%A7%C3%A3o_de_caracteres) Você pode alterar a codificação usando o seguinte código:

	QrCode::encoding('UTF-8')->generate('Make me a QrCode with special symbols ♠♥!!');

| Character Encoder |
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

>Um erro de `Could not encode content to ISO-8859-1` significa que foi inserido algum caractere inválido. Recomendamos o `UTF-8` se você não tiver certeza.

#### Mesclar

O método `merge` mescla uma imagem sobre um Qrcode. É comumente usado para se colocar logos dentro de um QrCode.

	QrCode::merge($filename, $percentage, $absolute);
	
	//Gera um QrCode com uma imagem centralizada.
	QrCode::format('png')->merge('path-to-image.png')->generate();
	
	//Gera um QrCode com uma imagem centralizada. A imagem inserida ocupará 30% do QrCode.
	QrCode::format('png')->merge('path-to-image.png', .3)->generate();
	
	//Gera um QrCode com uma imagem centralizada. A imagem inserida ocupará 30% do QrCode.
	QrCode::format('png')->merge('http://www.google.com/someimage.png', .3, true)->generate();

>O método `merge` suporta somente arquivos do tipo PNG.
>O filepath é relativo ao caminho base da aplicação, se o `$absolute` estiver setada para `false`. Altere essa variável para `true` para usar caminhos absolutos.

>Você deve usar um alto nível de correção de erros quando usado o método `merge`, para garantir que o QrCode será legível. Recomendamos usar `errorCorrection('H')`.

![Merged Logo](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### Merge Binary String

O método `mergeString` pode ser usado para alcaçar a mesma chamada do método `merge`, exceto que ele permite que você represente uma string de um arquivo ao invés do filepath. Isso é útil quando é utilizado o padrão `Storage` . A chamada a essa interface é bastante similar ao método `merge`. 

	QrCode::mergeString(Storage::get('path/to/image.png'), $percentage);
	
	//Gera um QrCode com uma imagem centralizada.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'))->generate();
	
	//Gera um QrCode com uma imagem centralizada. A imagem inserida ocupará 30% do QrCode.
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'), .3)->generate();

>Assim como o método `merge`, somente arquivos do tipo PNG são suportados. O mesmo aplica-se para correção de erros, altos níveis são recomendados.

#### Uso Avançado

Todos os métodos suportam encadeamento. O método `generate` deve ser chamado por ultimo e o método `format` deve ser chamado primeiro. Por exemplo, vocẽ pode executar o código seguinte:

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Make me a QrCode!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('Make me a QrCode!');

Você pode exibir uma imagem PNG, sem salvar o arquivo e prover uma string encodificada pelo método `base64_encode`.

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) !!} ">

<a id="docs-helpers"></a>
## Ajudantes

#### O que são ajudantes?

Ajudantes são uma maneira fácil de criar QrCodes que executam uma ação quando escaneados.  

#### E-Mail

Esse helper, gera um qrcode de e-mail que é capaz de ser preenchido no endereço de e-mail, assunto e corpo.

	QrCode::email($to, $subject, $body);
	
	//Fills in the to address
	QrCode::email('foo@bar.com');
	
	//Fills in the to address, subject, and body of an e-mail.
	QrCode::email('foo@bar.com', 'This is the subject.', 'This is the message body.');
	
	//Fills in just the subject and body of an e-mail.
	QrCode::email(null, 'This is the subject.', 'This is the message body.');
	
#### Geo

Esse helper gera uma latitude e longituded que o pode ser lido por um aparelho celular e abrir a localização no Google maps ou outro aplicativo similar.

	QrCode::geo($latitude, $longitude);
	
	QrCode::geo(37.822214, -122.481769);
	
#### Phone Number

Esse helper, gera uma QrCode que pode ser escaneado exibido um telefone.

	QrCode::phoneNumber($phoneNumber);
	
	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');
	
#### SMS (Mensagens de Texto)

Esse Helper, cria uma mensagem SMS que pode ser This helper makes SMS messages that can be preenchida com o emissoe e o corpo da mensagem.

	QrCode::SMS($phoneNumber, $message);
	
	//Cria uma mensagem de texto com o telefone preenchido.
	QrCode::SMS('555-555-5555');
	
	//Cria uma mensagem de text com o numero telefonico e a mensagem preenchida.
	QrCode::SMS('555-555-5555', 'Body of the message');

#### WiFi

Esse Helper, faz com que QrCodes escaneaveis, permitam o aparelho celular se conectar a uma rede WI-FI.

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
	
>Escaneamento WIFI atualmente não são suportados nos produtos Apple.

<a id="docs-common-usage"></a>
##Uso Comum do QRCode

Você pode usar um prefixo listado na tabela abaixo dentro da seção `generate` para criar um QrCode para armazenar informações mais avançadas:

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
##Uso fora do Laravel

Você pode usar o pacote fora do Laravel instanciando a classe `BaconQrCodeGenerator`.

	use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

	$qrcode = new BaconQrCodeGenerator;
	$qrcode->size(500)->generate('Make a qrcode without Laravel!');
