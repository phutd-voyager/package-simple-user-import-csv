<?php

namespace VoyagerInc\SimpleUserImportCsv\Tests;

class BaseTest extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [\VoyagerInc\SimpleUserImportCsv\SimpleUserImportCsvServiceProvider::class];
    }
}