<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimpleUserImportCsvRequest;
use Illuminate\Support\Facades\DB;
use VoyagerInc\SimpleUserImportCsv\Services\Interfaces\CsvFileReaderInterface;
use VoyagerInc\SimpleUserImportCsv\Services\Interfaces\CsvWriterInterface;
use VoyagerInc\SimpleUserImportCsv\Services\Interfaces\UserImportServiceInterface;

class SimpleUserImportCsvController extends Controller
{
    private $csvFileReader;
    private $userImportService;
    private $csvWriter;

    public function __construct(
        CsvFileReaderInterface $csvFileReader,
        UserImportServiceInterface $userImportService,
        CsvWriterInterface $csvWriter
    ) {
        $this->csvFileReader = $csvFileReader;
        $this->userImportService = $userImportService;
        $this->csvWriter = $csvWriter;
    }

    public function index()
    {
        return view('simpleUserImportCsv');
    }

    public function import(SimpleUserImportCsvRequest $request)
    {
        try {
            $file = $request->file('file');
            $skipHeader = config('simple_user_import_csv.csv_reader.skip_header', true);

            $userData = $this->csvFileReader->read($file->getPathname(), $skipHeader);

            DB::beginTransaction();

            $this->userImportService->import($userData);

            DB::commit();

            return redirect()->back()->with('success', 'Users imported successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors('Error importing users: ' . $e->getMessage());
        }
    }

    public function downloadFileTemp()
    {
        try {
            return $this->csvWriter->download();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error: ' . $e->getMessage());
        }
    }
}
