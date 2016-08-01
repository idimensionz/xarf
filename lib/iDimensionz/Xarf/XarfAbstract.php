<?php
/*
 * iDimensionz/{xarf}
 * Xarf.php
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

use Ramsey\Uuid\Uuid;

/**
 * Class XarfAbstract
 * @package iDimensionz\Xarf
 */
class XarfAbstract implements \JsonSerializable
{
    const XARF_VERSION = '0.2';

    const XARF_CATEGORY_ABUSE = 'abuse';
    const XARF_CATEGORY_FRAUD = 'fraud';
    const XARF_CATEGORY_INFO = 'info';

    const XARF_TYPE_IPV4 = 'ipv4';
    const XARF_TYPE_IPV6 = 'ipv6';
    const XARF_TYPE_IP_ADDRESS = 'ip-address';

    const XARF_ATTACHMENT_NONE = 'none';
    const XARF_ATTACHMENT_TEXT_PLAIN = 'text/plain';
    const XARF_ATTACHMENT_RFC822 = 'message/rfc822';

    /**
     * @var string
     */
    private $json;
    /**
     * @var string
     */
    private $reportedFrom;
    /**
     * @var string
     */
    private $category;
    /**
     * @var string
     */
    private $reportType;
    /**
     * @var string
     */
    private $userAgent;
    /**
     * @var string
     */
    private $reportId;
    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var string
     */
    private $source;
    /**
     * @var string
     */
    private $sourceType;
    /**
     * @var string
     */
    private $attachment;
    /**
     * @var string
     */
    private $schemaUrl;
    /**
     * @var string
     */
    private $version;
    /**
     * @var int
     */
    private $occurrences;
    /**
     * @var string
     */
    private $tlp;

    public function __construct()
    {
        $this->setVersion(self::XARF_VERSION);
        $this->setAttachment(static::XARF_ATTACHMENT_NONE);
    }

    /**
     * @return string
     */
    protected function getReportedFrom()
    {
        return $this->reportedFrom;
    }

    /**
     * @param string $reportedFrom
     */
    public function setReportedFrom($reportedFrom)
    {
        $this->reportedFrom = $reportedFrom;
    }

    /**
     * @return string
     */
    protected function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     * @throws \InvalidArgumentException
     */
    public function setCategory($category)
    {
        if (!in_array($category, [self::XARF_CATEGORY_ABUSE, self::XARF_CATEGORY_FRAUD, self::XARF_CATEGORY_INFO])) {
            throw new \InvalidArgumentException('Invalid category supplied');
        }
        $this->category = $category;
    }

    /**
     * @return string
     */
    protected function getReportType()
    {
        return $this->reportType;
    }

    /**
     * @param string $reportType
     */
    public function setReportType($reportType)
    {
        $this->reportType = $reportType;
    }

    /**
     * @return string
     */
    protected function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @return string
     */
    protected function getReportId()
    {
        return $this->reportId;
    }

    /**
     * @param string $topLevelDomain
     */
    public function setReportId($topLevelDomain)
    {
        $uuid = Uuid::uuid3(Uuid::NAMESPACE_DNS, $topLevelDomain);
        $this->reportId = $uuid->toString() . '@' . $topLevelDomain;
    }

    /**
     * @return \DateTime
     */
    protected function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    protected function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    protected function getSourceType()
    {
        return $this->sourceType;
    }

    /**
     * @param string $sourceType
     * @throws \InvalidArgumentException
     */
    public function setSourceType($sourceType)
    {
        if (!$this->isValidType($sourceType)) {
            throw new \InvalidArgumentException('Invalid Source Type provided');
        }
        $this->sourceType = $sourceType;
    }

    /**
     * @return string
     */
    protected function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @param string $attachment
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * @return string
     */
    protected function getSchemaUrl()
    {
        return $this->schemaUrl;
    }

    /**
     * @param string $schemaUrl
     */
    public function setSchemaUrl($schemaUrl)
    {
        $this->schemaUrl = $schemaUrl;
    }

    /**
     * @return string
     */
    protected function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return int
     */
    protected function getOccurrences()
    {
        return $this->occurrences;
    }

    /**
     * @param int $occurrences
     */
    public function setOccurrences($occurrences)
    {
        $this->occurrences = $occurrences;
    }

    /**
     * @return string
     */
    protected function getTlp()
    {
        return $this->tlp;
    }

    /**
     * @param string $tlp
     */
    public function setTlp($tlp)
    {
        $this->tlp = $tlp;
    }

    /**
     * @return array
     */
    protected function getValidTypes()
    {
        return [self::XARF_TYPE_IPV4, self::XARF_TYPE_IPV6, self::XARF_TYPE_IP_ADDRESS];
    }

    /**
     * @param string $type
     * @return bool
     */
    protected function isValidType($type)
    {
        return in_array($type, $this->getValidTypes());
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        $output = [];
        $output['properties'] = $output;
        $output['Report-ID'] = $this->getReportId();
        $output['Category'] = $this->getCategory();
        $output['Report-Type'] = $this->getReportType();
        $output['User-Agent'] = $this->getUserAgent();
        $output['Date'] = $this->getDate(DATE_RFC3339);
        $output['Source'] = $this->getSource();
        $output['Source-Type'] = $this->getSourceType();
        $output['Attachment'] = $this->getAttachment();
        $output['Schema-URL'] = $this->getSchemaUrl();
        $output['Version'] = $this->getVersion();
        $output['Occurrences'] = $this->getOccurrences();
        $output['TLP'] = $this->getTlp();

        return $output;
    }

    /**
     * Converts the x-arf object to a JSON object.
     * @return string
     */
    public function toJson()
    {
        return json_encode($this, JSON_FORCE_OBJECT);
    }
}
