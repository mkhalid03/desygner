<?php

namespace App\Requests;

use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UploadImageRequest extends ImageRequest
{

    #[Image(mimeTypes: [
        'image/webp',
        'image/png',
        'image/apng',
        'image/jpg',
        'image/jpeg',
        'image/svg+xml',
        'image/avif',
        'image/gif',
    ])]
    protected $image = true;

    public function __construct(protected ValidatorInterface $validator)
    {
        $this->populate();

        if ($this->autoValidateRequest()) {
            $this->validate();
        }
    }

    protected function populate(): void
    {
        foreach ($this->getRequest()->request->all() as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }

        foreach ($this->getRequest()->files as $property => $value) {
            if (empty($value)) {
                continue;
            }

            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

}
