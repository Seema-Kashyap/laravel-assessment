<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductImportService
{
     /**
      * Import products from a CSV file.
      * Returns summary: total, imported, updated, invalid, duplicates
      */
    public function importCsv($file) {
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle);
        $summary = ['total'=>0,'imported'=>0,'updated'=>0,'invalid'=>0,'duplicates'=>0];

        while (($row = fgetcsv($handle)) !== false) {
            $summary['total']++;
            $data = array_combine($header, $row);

            if (empty($data['sku']) || empty($data['name'])) {
                $summary['invalid']++; continue;
            }

            $product = Product::where('sku',$data['sku'])->first();
            if ($product) {
                $product->update($data);
                $summary['updated']++;
            } else {
                Product::create($data);
                $summary['imported']++;
            }
        }
        fclose($handle);
        return $summary;
    }
}
