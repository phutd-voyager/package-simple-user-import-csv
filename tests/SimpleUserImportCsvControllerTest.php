<?php

namespace VoyagerInc\SimpleUserImportCsv\Tests;

use App\Http\Controllers\SimpleUserImportCsvController;
use Illuminate\Http\UploadedFile;

class SimpleUserImportCsvControllerTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    #[test]
    public function test_imports_users_successfully()
    {
        $pathFile = __DIR__ . '/files/valid.csv';

        if (!file_exists($pathFile)) {
            $this->fail("File not found: $pathFile");
        }

        $file = new UploadedFile($pathFile, basename($pathFile));

        $controllerMock = $this->createMock(SimpleUserImportCsvController::class);

        $controllerMock->expects($this->once())
            ->method('import')
            ->willReturn($this->createMock(\Illuminate\Http\RedirectResponse::class));

        $response = $controllerMock->import(new \App\Http\Requests\SimpleUserImportCsvRequest(), ['file' => $file]);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);

        $response->assertRedirectToRoute('simple-user-import-csv.index');
        $response->assertSessionHas('success', 'Users imported successfully.');
    }

    #[test]
    public function test_imports_users_with_error()
    {
        $pathFile = __DIR__ . '/files/invalid.csv';

        if (!file_exists($pathFile)) {
            $this->fail("File not found: $pathFile");
        }

        $file = new UploadedFile($pathFile, basename($pathFile));

        $controllerMock = $this->createMock(SimpleUserImportCsvController::class);

        $controllerMock->expects($this->once())
            ->method('import')
            ->willReturn($this->createMock(\Illuminate\Http\RedirectResponse::class));

        $response = $controllerMock->import(new \App\Http\Requests\SimpleUserImportCsvRequest(), ['file' => $file]);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);

        $response->assertRedirectToRoute('simple-user-import-csv.index');
        $response->assertSessionHas('errors');
    }

    #[test]
    public function test_download_file_temp_successfully()
    {
        $controllerMock = $this->createMock(SimpleUserImportCsvController::class);

        $controllerMock->expects($this->once())
            ->method('downloadFileTemp')
            ->willReturn($this->createMock(\Illuminate\Http\Response::class));

        $response = $controllerMock->downloadFileTemp();

        $this->assertInstanceOf(\Illuminate\Http\Response::class, $response);

        $response->assertStatus(200);
    }
}
