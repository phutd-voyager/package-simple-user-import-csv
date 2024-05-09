<?php

namespace VoyagerInc\SimpleUserImportCsv\Tests;

use Illuminate\Support\Facades\Response;

class CsvWritterTest extends BaseTest
{
    private $csvWritter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->csvWritter = new \VoyagerInc\SimpleUserImportCsv\Services\CsvWritter();
    }

    #[test]
    public function test_instance_of_csv_file_writter()
    {
        $this->assertInstanceOf(\VoyagerInc\SimpleUserImportCsv\Services\CsvWritter::class, $this->csvWritter);
    }

    #[test]
    public function it_sets_correct_headers()
    {
        $headers = $this->csvWritter->getHeaders();

        $this->assertArrayHasKey('Content-Type', $headers);
        $this->assertEquals('text/csv', $headers['Content-Type']);
    }

    #[test]
    public function test_csv_download_with_data()
    {
        $mockData = [
            ['Funky','funky@gmail.com','password'],
            ['PhuTran','phutd@voyager-hcm.com','password'],
        ];

        Response::shouldReceive('streamDownload')->once()->andReturnUsing(function ($callback, $filename, $headers) use ($mockData) {
            $file = fopen('php://temp', 'w+');
            fputcsv($file, ['name', 'email', 'password']);
            foreach ($mockData as $row) {
                fputcsv($file, $row);
            }
            rewind($file);
            $csv = stream_get_contents($file);
            fclose($file);

            $expectedCsv = "name,email,password\nFunky,funky@gmail.com,password\nPhuTran,phutd@voyager-hcm.com,password\n";
            $this->assertEquals($expectedCsv, $csv);

            $expectedHeaders = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="users.csv"'
            ];
            $this->assertEquals($expectedHeaders, $headers);
        });

        $this->csvWritter->download($mockData);
    }

    public function test_csv_download_with_empty_data()
    {
        $data = [];

        Response::shouldReceive('streamDownload')->once()->andReturnUsing(function ($callback, $filename, $headers) use ($data) {
            $file = fopen('php://temp', 'w+');
            fputcsv($file, ['name', 'email', 'password']);
            rewind($file);
            $csv = stream_get_contents($file);
            fclose($file);

            $expectedCsv = "name,email,password\n";
            $this->assertEquals($expectedCsv, $csv);

            $expectedHeaders = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="users.csv"'
            ];
            $this->assertEquals($expectedHeaders, $headers);
        });

        $this->csvWritter->download($data);
    }

    #[test]
    public function testCsvDownloadWithCustomHeaders()
    {
        $mockData = [
            ['Funky','funky@gmail.com','password'],
            ['PhuTran','phutd@voyager-hcm.com','password'],
        ];

        $customHeaders = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="custom_users.csv"'
        ];

        Response::shouldReceive('streamDownload')->once()->andReturnUsing(function ($callback, $filename, $headers) use ($mockData, $customHeaders) {
            $file = fopen('php://temp', 'w+');
            fputcsv($file, ['name', 'email', 'password']);
            foreach ($mockData as $row) {
                fputcsv($file, $row);
            }
            rewind($file);
            $csv = stream_get_contents($file);
            fclose($file);

            $expectedCsv = "name,email,password\nFunky,funky@gmail.com,password\nPhuTran,phutd@voyager-hcm.com,password\n";
            $this->assertEquals($expectedCsv, $csv);

            $this->assertEquals($customHeaders, $headers);
        });

        $this->csvWritter->download($mockData);
    }
}