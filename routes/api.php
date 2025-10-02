<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ChunkUploadController, DiscountDemoController, ProductImportController};

// routes/api.php
Route::post('/import/products', [ProductImportController::class,'import']);
Route::post('/upload/chunk', [ChunkUploadController::class,'upload']);
Route::post('/discounts/demo', [DiscountDemoController::class,'demo']);


Route::prefix('discounts')->group(function () {
    Route::post('/assign', [DiscountDemoController::class, 'assignDiscount']);
    Route::post('/revoke', [DiscountDemoController::class, 'revokeDiscount']);
    Route::post('/apply', [DiscountDemoController::class, 'applyDiscount']);
});


Route::get('/ping', function () {
    return response()->json(['message' => 'API is working!']);
});
