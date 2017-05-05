<?php

namespace Eureka\Helpers\Transformers\Server;

use App\Photo;
use League\Fractal\TransformerAbstract;
class PhotoTransformer extends TransformerAbstract
{
    public function transform(Photo $photo)
    {
        return [
            'type' => $photo->type,
            'path' => asset($photo->path)
        ];
    }
}