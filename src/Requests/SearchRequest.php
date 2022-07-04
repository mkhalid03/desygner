<?php

namespace App\Requests;

use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SearchRequest extends BaseRequest
{
    #[Type('integer')]
    #[NotBlank()]
    #[GreaterThanOrEqual(value: 1)]
    protected $page = 1;


    #[Type('integer')]
    #[NotBlank()]
    #[GreaterThanOrEqual(value: 1)]
    protected $limit = 100;

    #[NotBlank()]
    #[Type(type: 'string')]
    protected $tag;

    #[Type(type: 'string')]
    protected $provider;

    public function __construct(protected ValidatorInterface $validator)
    {
        parent::__construct($validator);
    }

    public function data()
    {
        $data = json_decode($this->getRequest()->getContent(), true);
        $data['page'] = $data['page'] ?? $this->page;
        $data['limit'] = $data['limit'] ?? $this->limit;
        $data['tag'] = $data['tag'] ?? NULL;
        $data['provider'] = $data['provider'] ?? NULL;
        return $data;
    }
}
