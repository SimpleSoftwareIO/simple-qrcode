<?php

namespace SimpleSoftwareIO\QrCode\DataTypes;

class EPC implements DataTypeInterface
{
    /**
     * The prefix of the QrCode.
     *
     * @var string
     */
    protected $prefix = 'epc:';

    /**
     * The BIC.
     *
     * @var string
     */
    protected $bic;

    /**
     * The iban.
     *
     * @var string
     */
    protected $iban;

    /**
     * The amount of credit_transfer.
     *
     * @var string
     */
    protected $amount;

    /**
     * The Name of the Beneficiary.
     *
     * @var string
     */
    protected $name;

    /**
     * The text.
     *
     * @var string
     */
    protected $text;

    /**
     * Generates the DataType Object and sets all of its properties.
     *
     * @param $arguments
     */
    public function create(array $arguments)
    {
        $this->setProperties($arguments);
    }

    /**
     * Returns the correct QrCode format.
     *
     * @return string
     */
    public function __toString()
    {
        $string = "BCD\n";
        $string .= "002\n";
        $string .= "2\n";
        $string .= "SCT\n";
        $string .= $this->bic."\n";
        $string .= $this->name."\n";
        $string .= $this->iban."\n";
        $string .= 'EUR'.number_format($this->amount, 2)."\n";
        $string .= "\n";
        $string .= "\n";
        $string .= $this->text."\n";

        return $string;
    }

    /**
     * Sets the properties.
     *
     * @param $arguments
     */
    protected function setProperties(array $arguments)
    {
        $arguments = $arguments[0];
        if (isset($arguments['bic'])) {
            $this->bic = $arguments['bic'];
        }
        if (isset($arguments['iban'])) {
            $this->iban = $arguments['iban'];
        }
        if (isset($arguments['amount'])) {
            $this->amount = $arguments['amount'];
        }
        if (isset($arguments['name'])) {
            $this->name = $arguments['name'];
        }
        if (isset($arguments['text'])) {
            $this->text = $arguments['text'];
        }
    }
}
