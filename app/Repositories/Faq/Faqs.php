<?php

namespace App\Repositories\Faq;

use App\Models\Faq\Faqs as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Faqs extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
