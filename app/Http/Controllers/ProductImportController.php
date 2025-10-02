<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductImportService;
class ProductImportController extends Controller
{
    public function import(Request $request, ProductImportService $service) {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $summary = $service->importCsv($request->file('file'));
        return response()->json($summary);
    }
}
