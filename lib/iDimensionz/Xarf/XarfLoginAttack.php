<?php
/*
 * iDimensionz/{xarf}
 * XarfLoginAttack.php
 *  
 * The MIT License (MIT)
 * 
 * Copyright (c) 2015 iDimensionz
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
*/

namespace iDimensionz\Xarf;

/**
 * Class XarfLoginAttack
 * @package iDimensionz\Xarf
 */
class XarfLoginAttack extends XarfAbstract
    implements \JsonSerializable
{
    const XARF_SCHEMA_URL = 'http://www.x-arf.org/schema/abuse_login-attack_0.1.2.json';

    /**
     * @var string
     */
    private $service;
    /**
     * @var int
     */
    private $port;
    /**
     * @var string
     */
    private $destination;
    /**
     * @var string
     */
    private $destinationType;

    public function __construct()
    {
        parent::__construct();
        $this->setReportType('login-attack');
        $this->setCategory(static::XARF_CATEGORY_ABUSE);
        $this->setSchemaUrl(self::XARF_SCHEMA_URL);
    }

    /**
     * @return string
     */
    private function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return int
     */
    private function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return string
     */
    private function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * @return string
     */
    private function getDestinationType()
    {
        return $this->destinationType;
    }

    /**
     * @param string $destinationType
     */
    public function setDestinationType($destinationType)
    {
        if (!$this->isValidType($destinationType)) {
            throw new \InvalidArgumentException('Invalid destination type supplied');
        }

        $this->destinationType = $destinationType;
    }

    /**
     * @param string $attachment
     * @throws \InvalidArgumentException
     */
    public function setAttachment($attachment)
    {
        if (!in_array($attachment, [static::XARF_ATTACHMENT_NONE, static::XARF_ATTACHMENT_TEXT_PLAIN])) {
            throw new \InvalidArgumentException('Attachment must be none or text\plain');
        }

        parent::setAttachment($attachment);
    }

    public function jsonSerialize()
    {
        $output = parent::jsonSerialize();
        $output['Service'] = $this->getService();
        $output['Port'] = $this->getPort();
        $output['Destination'] = $this->getDestination();
        $output['Destination-Type'] = $this->getDestinationType();
    }
}
