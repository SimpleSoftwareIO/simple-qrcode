<?php

namespace SimpleSoftwareIO\QrCode\DataTypes;

use BaconQrCode\Exception\InvalidArgumentException;

class Email implements DataTypeInterface
{
    /**
     * The prefix of the QrCode.
     *
     * @var string
     */
    protected $prefix = 'mailto:';

    /**
     * The email address.
     *
     * @var string
     */
    protected $email;

    /**
     * The subject of the email.
     *
     * @var string
     */
    protected $subject;

    /**
     * The body of an email.
     *
     * @var string
     */
    protected $body;

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
        return $this->buildEmailString();
    }

    /*
     * Builds the email string.
     *
     * @return string
     */
    protected function buildEmailString()
    {
        $email = $this->prefix.$this->email;

        if (isset($this->subject) || isset($this->body)) {
            $data = [
                'subject' => $this->subject,
                'body'    => $this->body,
            ];
            $email .= '?'.http_build_query($data);
        }

        return $email;
    }

    /**
     * Sets the objects properties.
     *
     * @param $arguments
     */
    protected function setProperties(array $arguments)
    {
        if (isset($arguments[0])) {
            $this->setEmail($arguments[0]);
        }
        if (isset($arguments[1])) {
            $this->subject = $arguments[1];
        }
        if (isset($arguments[2])) {
            $this->body = $arguments[2];
        }
    }

    /**
     * Sets the email property.
     *
     * @param $email
     */
    protected function setEmail($email)
    {
        if ($this->isValidEmail($email)) {
            $this->email = $email;
        }
    }

    /**
     * Ensures an email is valid.
     *
     * @param string $email
     *
     * @return bool
     */
    protected function isValidEmail($email)
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email provided');
        }

        return true;
    }
}
