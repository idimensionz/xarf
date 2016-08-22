<?php
/*
 * iDimensionz/{xarf}
 * XarfAbstractUnitTest.php
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

namespace Tests\iDimensionz\Xarf;

use iDimensionz\Xarf\XarfAbstract;
use Ramsey\Uuid\Uuid;

class XarfAbstractUnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XarfAbstractTestStub
     */
    private $xarfAbstract;

    public function setUp()
    {
        parent::setUp();
        $this->xarfAbstract = new XarfAbstractTestStub();
    }

    public function tearDown()
    {
        unset($this->xarfAbstract);
        parent::tearDown();
    }

    public function testConstruct()
    {
        $this->assertEquals(XarfAbstract::XARF_VERSION, $this->xarfAbstract->getVersion());
        $this->assertEquals(XarfAbstract::XARF_ATTACHMENT_NONE, $this->xarfAbstract->getAttachment());
    }

    public function testReportedFromGetterAndSetter()
    {
        $validReportedFrom = 'some valid value';
        $this->xarfAbstract->setReportedFrom($validReportedFrom);
        $actualReportedFrom = $this->xarfAbstract->getReportedFrom();
        $this->assertEquals($validReportedFrom, $actualReportedFrom);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetCategoryThrowsExceptionWhenCategoryInvalid()
    {
        $invalidCategory = 'not a valid category';
        $this->xarfAbstract->setCategory($invalidCategory);
    }

    public function testCategoryGetterAndSetter()
    {
        $validCategories = array(
            XarfAbstract::XARF_CATEGORY_ABUSE,
            XarfAbstract::XARF_CATEGORY_FRAUD,
            XarfAbstract::XARF_CATEGORY_INFO,
        );
        foreach ($validCategories as $validCategory) {
            $this->xarfAbstract->setCategory($validCategory);
            $actualCategory = $this->xarfAbstract->getCategory();
            $this->assertEquals($validCategory, $actualCategory);
        }
    }

    public function testReportTypeGetterAndSetter()
    {
        $validReportType = 'some valid report type';
        $this->xarfAbstract->setReportType($validReportType);
        $actualReportType = $this->xarfAbstract->getReportType();
        $this->assertEquals($validReportType, $actualReportType);
    }

    public function testUserAgentGetterAndSetter()
    {
        $validUserAgent = 'some valid user agent';
        $this->xarfAbstract->setUserAgent($validUserAgent);
        $actualUserAgent = $this->xarfAbstract->getUserAgent();
        $this->assertEquals($validUserAgent, $actualUserAgent);
    }

    public function testReportIdGetterAndSetter()
    {
        $topLevelDomain = 'mydomain.com';
        $uuid = Uuid::uuid3(Uuid::NAMESPACE_DNS, $topLevelDomain);
        $expectedReportId = $uuid->toString() . '@' . $topLevelDomain;
        $this->xarfAbstract->setReportId($topLevelDomain);
        $actualReportId = $this->xarfAbstract->getReportId();
        $this->assertEquals($expectedReportId, $actualReportId);
    }
}
