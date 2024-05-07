<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimpleUserImportCsvRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use VoyagerInc\SimpleUserImportCsv\Services\Interfaces\CsvFileReaderInterface;
use VoyagerInc\SimpleUserImportCsv\Services\Interfaces\UserImportServiceInterface;

class SimpleUserImportCsvController extends Controller
{
    private $csvFileReader;
    private $userImportService;

    private $filePath = 'app/temp/user.csv';

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
            $filePath = public_path($this->filePath);

            $checkFileExist = File::exists($filePath);

            if (!$checkFileExist) {
                return redirect()->back()->withErrors('File not found.');
            }

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="user.csv"',
            ];

            return response()->download($filePath, 'user.csv', $headers);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
