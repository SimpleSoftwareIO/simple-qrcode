<?php

namespace SimpleSoftwareIO\QrCode\DataTypes;

class KSAVat implements DataTypeInterface
{
    /**
     * The prefix of the QrCode.
     *
     * @var string
     */
    protected $prefix = 'ksa_vat:';

    /**
     * The separator between the variables.
     *
     * @var string
     */
    protected $separator = '##';

    /**
     * Seller’s name.
     *
     * @var
     */
    protected $seller_name;

    /**
     * VAT registration number of the seller.
     *
     * @var
     */
    protected $vat_nr;

    /**
     * Time stamp of the invoice (date and time).
     *
     * @var
     */
    protected $invoice_date;

    /**
     * Invoice total (with VAT).
     *
     * @var
     */
    protected $invoice_total;

    /**
     * VAT total.
     *
     * @var
     */
    protected $invoice_tax;

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
     * Sets the KSAVat properties.
     *
     * @param $arguments
     */
    protected function setProperties(array $arguments)
    {
        $arguments = $arguments[0];
        if (isset($arguments['seller'])) {
            $this->seller_name = $arguments['seller'];
        }
        if (isset($arguments['vat'])) {
            $this->vat_nr = $arguments['vat'];
        }
        if (isset($arguments['date'])) {
            $this->invoice_date = $arguments['date'];
        }
        if (isset($arguments['total'])) {
            $this->total = $arguments['total'];
        }
        if (isset($arguments['tax'])) {
            $this->tax = $arguments['tax'];
        }
    }

    /**
     * Returns the correct QrCode format.
     *
     * @return string
     */
    public function __toString()
    {
        $result = chr(1) . chr(strlen($this->seller_name)) . $this->seller_name;
        $result .= chr(2) . chr(strlen($this->vat_nr)) . $this->vat_nr;
        $result .= chr(3) . chr(strlen($this->invoice_date)) . $this->invoice_date;
        $result .= chr(4) . chr(strlen($this->total)) . $this->total;
        $result .= chr(5) . chr(strlen($this->tax)) . $this->tax;
        return base64_encode($result);
    }
}
