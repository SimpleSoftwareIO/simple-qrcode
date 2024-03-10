<?php

use PHPUnit\Framework\TestCase;
use SimpleSoftwareIO\QrCode\DataTypes\EPC;

class EPCTest extends TestCase
{
    public function testToString()
    {
        $arguments = [
            'bic' => 'BIC123',
            'iban' => 'IBAN456',
            'amount' => '1000.50',
            'name' => 'John Doe',
            'text' => 'Test payment',
        ];

        $epc = new EPC();
        $epc->create([$arguments]);

        $expected = "BCD\n";
        $expected .= "002\n";
        $expected .= "2\n";
        $expected .= "SCT\n";
        $expected .= $arguments['bic']."\n";
        $expected .= $arguments['name']."\n";
        $expected .= $arguments['iban']."\n";
        $expected .= 'EUR'.number_format($arguments['amount'], 2)."\n";
        $expected .= "\n";
        $expected .= "\n";
        $expected .= $arguments['text']."\n";

        $this->assertEquals($expected, $epc->__toString());
    }

    public function testSetProperties()
    {
        $arguments = [
            'bic' => 'BIC123',
            'iban' => 'IBAN456',
            'amount' => '1000.50',
            'name' => 'John Doe',
            'text' => 'Test payment',
        ];

        $epc = new EPC();
        $epc->create([$arguments]);

        $this->assertEquals($arguments['bic'], $epc->getBic());
        $this->assertEquals($arguments['iban'], $epc->getIban());
        $this->assertEquals($arguments['amount'], $epc->getAmount());
        $this->assertEquals($arguments['name'], $epc->getName());
        $this->assertEquals($arguments['text'], $epc->getText());
    }
}
