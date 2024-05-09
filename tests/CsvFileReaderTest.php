<?php

namespace VoyagerInc\SimpleUserImportCsv\Tests;

class CsvFileReaderTest extends BaseTest
{
    private $csvFileReader;

    protected function setUp(): void
    {
        parent::setUp();

        $this->csvFileReader = new \VoyagerInc\SimpleUserImportCsv\Services\CsvFileReader();
    }

    protected function getPackageProviders()
    {
        return [\VoyagerInc\SimpleUserImportCsv\SimpleUserImportCsvServiceProvider::class];
    }

    #[test]
    public function test_instance_of_csv_file_reader()
    {
        $this->assertInstanceOf(\VoyagerInc\SimpleUserImportCsv\Services\CsvFileReader::class, $this->csvFileReader);
    }

    #[test]
    public function test_csv_reader_file_valid()
    {
        $pathFile = __DIR__ .'/files/valid.csv';

        $result = $this->csvFileReader->read($pathFile);

        $this->assertIsArray($result);
    }

    #[test]
    public function test_csv_file_reader_throws_exception_on_wrong_column_count()
    {
        $this->expectException(\Exception::class);

        $filePath = __DIR__ . '/files/invalid.csv';

        $this->csvFileReader->read($filePath);
    }

    #[test]
    public function test_csv_file_reader_can_read_with_header()
    {
        $pathFile = __DIR__ . '/files/valid_with_header.csv';

        $result = $this->csvFileReader->read($pathFile, $skipHeader = false);

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals('name', $result[0]['name']);
    }
}