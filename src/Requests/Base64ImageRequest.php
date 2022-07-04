<?php

namespace App\Requests;

use App\Validator\Constraints\Base64Image;
use Symfony\Component\Validator\Constraints\NotBlank;

class Base64ImageRequest extends ImageRequest
{
    #[NotBlank([])]
    #[Base64Image(mimeTypes: [
        'image/webp',
        'image/png',
        'image/apng',
        'image/jpg',
        'image/jpeg',
        'image/svg+xml',
        'image/avif',
        'image/gif',
    ])]
    protected $base64_image;

}
