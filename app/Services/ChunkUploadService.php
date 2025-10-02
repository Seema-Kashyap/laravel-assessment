<?php
namespace App\Services;

use App\Models\Upload;
use Illuminate\Support\Facades\Storage;

class ChunkUploadService
{
    public function handleChunk($request) {
        $chunk = $request->file('chunk');
        $identifier = $request->input('identifier');
        $chunkIndex = $request->input('chunkIndex');
        $totalChunks = $request->input('totalChunks');

        $dir = "chunks/{$identifier}";
        $chunk->storeAs($dir, $chunkIndex);

        if ($chunkIndex + 1 == $totalChunks) {
            $finalPath = "uploads/{$identifier}.bin";
            $out = fopen(storage_path("app/$finalPath"), 'wb');
            for ($i=0; $i<$totalChunks; $i++) {
                fwrite($out, Storage::get("$dir/$i"));
            }
            fclose($out);
            Storage::deleteDirectory($dir);

            $upload = Upload::create(['path'=>$finalPath]);
            return $upload;
        }
        return null;
    }
}
