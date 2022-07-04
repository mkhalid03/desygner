<?php

namespace App\Requests;

use App\Validator\Constraints\RemoteImageUrl;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class RemoteImageRequest extends ImageRequest
{
    #[NotBlank([])]
    #[RemoteImageUrl([])]
    protected $path;

    #[Type(type: 'bool')]
    protected $copy = true;
}
