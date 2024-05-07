<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimpleUserImportCsvRequest;
use Illuminate\Support\Facades\DB;
use VoyagerInc\SimpleUserImportCsv\Services\Interfaces\CsvFileReaderInterface;
use VoyagerInc\SimpleUserImportCsv\Services\Interfaces\UserImportServiceInterface;

class SimpleUserImportCsvController extends Controller
{
    private $csvFileReader;
    private $userImportService;

    public function __construct(CsvFileReaderInterface $csvFileReader, UserImportServiceInterface $userImportService)
    {
        $this->csvFileReader = $csvFileReader;
        $this->userImportService = $userImportService;
    }

    public function index()
    {
        return view('simpleUserImportCsv');
    }

    public function import(SimpleUserImportCsvRequest $request)
    {
        try {
            $file = $request->file('file');
            $skipHeader = config('simple_user_import_csv.skip_header', true);

            $userData = $this->csvFileReader->read($file->getPathname(), $skipHeader);

            // Start transaction
            DB::beginTransaction();

            $this->userImportService->import($userData);

            // Commit transaction
            DB::commit();

            return redirect()->back()->with('success', 'Users imported successfully.');
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();

            // Handle any errors
            return redirect()->back()->with('error', 'Error importing users: ' . $e->getMessage())->withInput();
        }
    }
}
