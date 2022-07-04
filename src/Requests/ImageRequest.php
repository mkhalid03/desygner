<?php

namespace App\Requests;

use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ImageRequest extends BaseRequest
{
    #[NotBlank([])]
    #[Length(max: 255)]
    protected $provider;

    #[Count(min: 1)]
    protected $tags = [];

}
