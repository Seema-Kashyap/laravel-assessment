<?php
namespace App\Services;
use Intervention\Image\Facades\Image as Img;

class ImageService
{
    public function generateVariants($upload, $product) {
        $sizes = [256,512,1024];
        foreach ($sizes as $s) {
            $img = Img::make(storage_path("app/{$upload->path}"))
                ->resize($s, null, function($c){ $c->aspectRatio(); });
            $path = "images/{$s}_{$upload->id}.jpg";
            $img->save(storage_path("app/$path"));
            $product->images()->create([
                'upload_id'=>$upload->id,
                'size'=>$s,
                'path'=>$path,
                'is_primary'=>($s==512),
            ]);
        }
    }
}
