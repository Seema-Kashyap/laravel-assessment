<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChunkUploadService;
class ChunkUploadController extends Controller
{
    public function upload(Request $request, ChunkUploadService $service) {
        $request->validate([
            'chunk' => 'required|file',
            'identifier' => 'required|string',
            'chunkIndex' => 'required|integer',
            'totalChunks' => 'required|integer',
        ]);

        $upload = $service->handleChunk($request);
        return response()->json([
            'message' => $upload ? 'Upload completed' : 'Chunk received',
            'upload' => $upload
        ]);
    }
}
