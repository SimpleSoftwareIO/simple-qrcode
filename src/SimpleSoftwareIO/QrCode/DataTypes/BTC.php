<?php

namespace SimpleSoftwareIO\QrCode\DataTypes;

class BTC implements DataTypeInterface
{
    /**
     * The prefix of the QrCode.
     *
     * @var string
     */
    protected $prefix = 'bitcoin:';

    /**
     * The BitCoin address.
     *
     * @var string
     */
    protected $address;

    /**
     * The amount to send.
     *
     * @var int
     */
    protected $amount;

    /**
     * The BitCoin transaction label.
     *
     * @var string
     */
    protected $label;

    /**
     * The BitCoin message to send.
     *
     * @var string
     */
    protected $message;

    /**
     * The BitCoin return URL.
     *
     * @var string
     */
    protected $returnAddress;

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
        return $this->buildBitCoinString();
    }

    /**
     * Sets the BitCoin arguments.
     *
     * @param array $arguments
     */
    protected function setProperties(array $arguments)
    {
        if (isset($arguments[0])) {
            $this->address = $arguments[0];
        }

        if (isset($arguments[1])) {
            $this->amount = $arguments[1];
        }

        if (isset($arguments[2])) {
            $this->setOptions($arguments[2]);
        }
    }

    /**
     * Sets the optional BitCoin options.
     *
     * @param array $options
     */
    protected function setOptions(array $options)
    {
        if (isset($options['label'])) {
            $this->label = $options['label'];
        }

        if (isset($options['message'])) {
            $this->message = $options['message'];
        }

        if (isset($options['returnAddress'])) {
            $this->returnAddress = $options['returnAddress'];
        }
    }

    /**
     * Builds a BitCoin string.
     *
     * @return string
     */
    protected function buildBitCoinString()
    {
        $query = http_build_query([
            'amount'    => $this->amount,
            'label'     => $this->label,
            'message'  => $this->message,
            'r'         => $this->returnAddress,
        ]);

        $btc = $this->prefix.$this->address.'?'.$query;

        return $btc;
    }
}
