<?php

namespace GetnetTest\Api;

use Getnet\Api\Environment;
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    private $data;

    protected function setUp(): void
    {
        $this->data = $GLOBALS['configs']['environment'];
    }

    protected function tearDown(): void
    {
        unset($this->data);
    }

    public function testSetAndGetEnvironmentProduction()
    {
        $environment = new Environment();
        $environment->setEnvironment(Environment::PRODUCTION);

        self::assertEquals(Environment::PRODUCTION, $environment->getEnvironment());

        return $environment;
    }

    public function testSetAndGetEnvironmentStagging()
    {
        $environment = new Environment();
        $environment->setEnvironment(Environment::STAGGING);

        self::assertEquals(Environment::STAGGING, $environment->getEnvironment());

        return $environment;
    }

    /**
     * @depends testSetAndGetEnvironmentProduction
     * @param Environment $environment
     */
    public function testGetUrlProduction(Environment $environment)
    {
        self::assertEquals($this->data['P'], $environment->getUrl());
    }

    /**
     * @depends testSetAndGetEnvironmentStagging
     * @param Environment $environment
     */
    public function testGetUrlStagging(Environment $environment)
    {
        self::assertEquals($this->data['S'], $environment->getUrl());
    }
}
