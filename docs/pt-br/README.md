[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode) [![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)


- [Introdução](#docs-introduction)
- [Traduções](#docs-translations)
- [Configuração](#docs-configuration)
- [Simples ideias](#docs-ideas)
- [Uso](#docs-usage)
- [Ajuda](#docs-ajudantes)
- [Uso comum do QrCode](#docs-common-usage)
- [Uso sem Laravel](#docs-outside-laravel)

<a id="docs-introduction"></a>
## Introdução
Simple QrCode é um pacote de fácil uso do Framework Laravel, baseado no grande trabalho do [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode). Criamos uma interface que é fácil e familiar de instalar para usuários Laravel.

<a id="docs-translations"></a>
## Traduções
 Estamos procurando por usuários que falem Árabe, Espanhol, Francês, Coreano ou Japonês, para nos ajudar a traduzir este documento. Por favor, crie um pull request se você é capar de fazer uma tradução!

<a id="docs-configuration"></a>
## Configuração

#### Composer

Primeiramente, adicione o pacote Simple QrCode ao seu `require` no arquivo `composer.json`:

	"require": {
		"simplesoftwareio/simple-qrcode": "~2"
	}

Em seguida, execute o comando `composer update`.

#### Provedor de Serviço

###### Laravel <= 5.4
Registre a `SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class` em seu `config/app.php` dentro do array `providers`.

#### Aliases

###### Laravel <= 5.4
Finalmente, adicione `'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class` em seu arquivo de configuração `config/app.php` dentro do array `aliases`.

<a id="docs-ideas"></a>
## Ideias simples

#### Print View

Um dos principais pontos pelo qual nós utilizamos este pacote para é ter QRCodes em todos os nossos pontos de vista de impressão. Isto permite que nossos clientes possam retornar para a página original depois da impressão, basta digitalizar o código. Conseguimos isso adicionando o seguinte em nosso arquivo footer.blade.php.

	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>Me escaneie para retornar à página principal</p>
	</div>

#### Embarcando um QrCode

Você pode incorporar um qrcode dentro de um e-mail, que permita que seus usuários escaneiem rapidamente. Abaixo, um exemplo de como fazer isso utilizando o Laravel.

	//Inside of a blade template.
	<img src="{!!$message->embedData(QrCode::format('png')->generate('Anexe-me em um e-mail!'), 'QrCode.png', 'image/png')!!}">

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

	QrCode::format('png');  // Retornará uma imagem no formato PNG
	QrCode::format('eps');  // Retornará uma imagem no formato EPS
	QrCode::format('svg');  // Retornará uma imagem no formato SVG

#### Alteração de Tamanho

>Por padrão, o gerador QrCode retornará o menos tamanho possível em pixels para criar o QrCode.

Você pode alterar o tamanho do QrCode usando o método `size`. Simplesmente especifique o tamanho desejado em pixels usando a seguinte sintaze:

	QrCode::size(100);

#### Alteração de cor

>Cuidado quando estiver alterando a cor de um QRCode. Alguns leitores tem uma grande dificuldade em ler QrCodes coloridos.

Todas as cores devem ser definidas em RGB(Red Green Blue). Você pode alterar a cor de um qrCode usando o código abaixo:

	QrCode::color(255,0,255);

Alterações do plano de fundo também são suportadas e definidas da mesma maneira.

	QrCode::backgroundColor(255,255,0);

#### Alteração de Margem

A capacidade de alterar a margem ao redor do QrCode também é suportada. Simplesmente especifique o tamanho desejado da margem, utilizando a sintaxe abaixo:

	QrCode::margin(100);

#### Correção de erros

Alterar o nível de correção de erros é simples. Utilize a seguinte sintaxe:

	QrCode::errorCorrection('H');

As seguintes opções são suportadas para o método `errorCorrection`.

| Correção de erros | Garantia fornecida |
| --- | --- |
| L | 7% das palavras-código podem ser restauradas. |
| M | 15% das palavras-código podem ser restauradas. |
| Q | 25% das palavras-código podem ser restauradas. |
| H | 30% das palavras-código podem ser restauradas. |

>Quanto maior a correção de erros utilizada, maior o QrCode fica e menos informação ele pode armazenar. Leia mais sobre [correção de erros](http://en.wikipedia.org/wiki/QR_code#Error_correction).

#### Codificação

Alterar a codificação que é usada para criar um QrCode. Por padrão, a encodificação padrão é a `ISO-8859-1`. Leia mais sobre [codificação de caracteres](https://pt.wikipedia.org/wiki/Codifica%C3%A7%C3%A3o_de_caracteres). Você pode alterar a codificação usando o seguinte código:

	QrCode::encoding('UTF-8')->generate('Faça-me um QrCode com símbolos especiais ♠♥!!');

| Codificador de caracteres |
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
	
	// Gera um QrCode com uma imagem centralizada.
	QrCode::format('png')->merge('diretório/da/imagem.png')->generate();
	
	// Gera um QrCode com uma imagem centralizada. A imagem inserida ocupará 30% do QrCode.
	QrCode::format('png')->merge('diretório/da/imagem.png', .3)->generate();
	
	// Gera um QrCode com uma imagem centralizada. A imagem inserida ocupará 30% do QrCode.
	QrCode::format('png')->merge('http://www.google.com/algumaImagem.png', .3, true)->generate();

>O método `merge` suporta somente arquivos do tipo PNG.
>O diretório da imagem é relativo ao caminho base da aplicação, se o `$absolute` estiver setada para `false`. Altere essa variável para `true` para usar caminhos absolutos.

>Você deve usar um alto nível de correção de erros quando usado o método `merge`, para garantir que o QrCode será legível. Recomendamos usar `errorCorrection('H')`.

![Merged Logo](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### Funda string binária

O método `mergeString` pode ser usado para alcançar a mesma chamada do método `merge`, exceto que ele permite que você represente uma string de um arquivo ao invés do diretório. Isso é útil quando é utilizado o padrão `Storage`. A chamada a essa interface é bastante similar ao método `merge`. 

	QrCode::mergeString(Storage::get('diretório/da/imagem.png'), $percentage);
	
	// Gera um QrCode com uma imagem centralizada.
	QrCode::format('png')->mergeString(Storage::get('diretório/da/imagem.png'))->generate();
	
	// Gera um QrCode com uma imagem centralizada. A imagem inserida ocupará 30% do QrCode.
	QrCode::format('png')->mergeString(Storage::get('diretório/da/imagem.png'), .3)->generate();

>Assim como o método `merge`, somente arquivos do tipo PNG são suportados. O mesmo aplica-se para correção de erros, altos níveis são recomendados.

#### Uso Avançado

Todos os métodos suportam encadeamento. O método `generate` deve ser chamado por último e o método `format` deve ser chamado primeiro. Por exemplo, vocẽ pode executar o código seguinte:

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('Faça-me um QrCode!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('Faça-me um QrCode!');

Você pode exibir uma imagem PNG, sem salvar o arquivo e prover uma string encodificada pelo método `base64_encode`.

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Crie-me dentro de um QrCode!')) !!} ">

<a id="docs-ajudantes"></a>
## Ajudantes

#### O que são ajudantes?

Ajudantes são uma maneira fácil de criar QrCodes que executam uma ação quando escaneados.  

#### E-Mail

Esse ajudante, gera um qrcode de e-mail que é capaz de ser preenchido no endereço de e-mail, assunto e corpo.

	QrCode::email($to, $subject, $body);
	
	// Preenche o endereço de email
	QrCode::email('foo@bar.com');
	
	// Preenche o endereço, título e corpo de um email
	QrCode::email('foo@bar.com', 'This is the subject.', 'This is the message body.');
	
	// Preenche apenas o título e corpo de um email
	QrCode::email(null, 'This is the subject.', 'This is the message body.');
	
#### Geo

Esse ajudante gera uma latitude e longitude que pode ser lido por um aparelho celular e abrir a localização no Google maps ou outro aplicativo similar.

	QrCode::geo($latitude, $longitude);
	
	QrCode::geo(37.822214, -122.481769);
	
#### Phone Number

Esse ajudante, gera uma QrCode que pode ser escaneado e exibir um número de telefone.

	QrCode::phoneNumber($phoneNumber);
	
	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');
	
#### SMS (Mensagens de Texto)

Esse ajudante, cria uma mensagem SMS que pode ser preenchida com o número de telefone e o corpo da mensagem.

	QrCode::SMS($phoneNumber, $message);
	
	// Cria uma mensagem de texto com o telefone preenchido.
	QrCode::SMS('555-555-5555');
	
	// Cria uma mensagem de texto com o número telefônico e a mensagem preenchida.
	QrCode::SMS('555-555-5555', 'Body of the message');

#### WiFi

Esse ajudante, faz com que QrCodes escaneáveis permitam o aparelho celular se conectar a uma rede WI-FI.

	QrCode::wiFi([
		'encryption' => 'WPA/WEP',
		'ssid' => 'SSID da rede',
		'password' => 'Senha da rede',
		'hidden' => 'Se a rede é um SSID oculto ou não.'
	]);
	
	// Conectar a uma rede wifi
	QrCode::wiFi([
		'ssid' => 'Nome da rede',
	]);
	
	// Conectar a uma refe wifi oculta
	QrCode::wiFi([
		'ssid' => 'Nome da rede',
		'hidden' => 'true'
	]);
	
	// Conectar a uma rede wifi segura
	QrCode::wiFi([
		'ssid' => 'Nome da rede',
		'encryption' => 'WPA',
		'password' => 'minhaSenha'
	]);
	
>Escaneamento WIFI atualmente não são suportados nos produtos Apple.

<a id="docs-common-usage"></a>
##Uso Comum do QRCode

Você pode usar um prefixo listado na tabela abaixo dentro da seção `generate` para criar um QrCode para armazenar informações mais avançadas:

	QrCode::generate('http://www.simplesoftware.io');


| Uso | Prefixo | Exemplo |
| --- | --- | --- |
| URL do site | http:// | http://www.simplesoftware.io |
| URL segura | https:// | https://www.simplesoftware.io |
| Endereço de e-mail | mailto: | mailto:support@simplesoftware.io |
| Número de telefone | tel: | tel:555-555-5555 |
| Texto (SMS) | sms: | sms:555-555-5555 |
| Texto (SMS) With Pretyped Message | sms: | sms::I am a pretyped message |
| Texto (SMS) With Pretyped Message and Number | sms: | sms:555-555-5555:I am a pretyped message |
| Coordenadas | geo: | geo:-78.400364,-85.916993 |
| MeCard | mecard: | MECARD:Simple, Software;Some Address, Somewhere, 20430;TEL:555-555-5555;EMAIL:support@simplesoftware.io; |
| VCard | BEGIN:VCARD | [Veja Exemplos](https://en.wikipedia.org/wiki/VCard) |
| Wifi | wifi: | wifi:WEP/WPA;SSID;PSK;Hidden(True/False) |

<a id="docs-outside-laravel"></a>
##Uso fora do Laravel

Você pode usar o pacote fora do Laravel instanciando a classe `BaconQrCodeGenerator`.

	use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

	$qrcode = new BaconQrCodeGenerator;
	$qrcode->size(500)->generate('Crie um QrCode sem Laravel!');
