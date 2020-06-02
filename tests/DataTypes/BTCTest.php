<?php

use PHPUnit\Framework\TestCase;
use SimpleSoftwareIO\QrCode\DataTypes\BTC;

class BTCTest extends TestCase
{
    public function setUp(): void
    {
        $this->btc = new BTC();
    }

    public function test_it_generates_a_valid_btc_qrcode_with_an_address_and_amount()
    {
        $this->btc->create(['btcaddress', 0.0034]);

        $properFormat = 'bitcoin:btcaddress?amount=0.0034';

        $this->assertEquals($properFormat, strval($this->btc));
    }

    public function test_it_generates_a_valid_btc_qrcode_with_an_address_amount_and_label()
    {
        $this->btc->create(['btcaddress', 0.0034, ['label' => 'label']]);

        $properFormat = 'bitcoin:btcaddress?amount=0.0034&label=label';

        $this->assertEquals($properFormat, strval($this->btc));
    }

    public function test_it_generates_a_valid_btc_qrcode_with_an_address_amount_label_message_and_return_address()
    {
        $this->btc->create([
            'btcaddress',
            0.0034,
            [
                'label'         => 'label',
                'message'       => 'message',
                'returnAddress' => 'https://www.returnaddress.com',
            ],
        ]);

        $properFormat = 'bitcoin:btcaddress?amount=0.0034&label=label&message=message&r='.urlencode('https://www.returnaddress.com');

        $this->assertEquals($properFormat, strval($this->btc));
    }
}
