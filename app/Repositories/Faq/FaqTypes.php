<?php

namespace App\Repositories\Faq;

use App\Models\Faq\FaqTypes as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class FaqTypes extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
