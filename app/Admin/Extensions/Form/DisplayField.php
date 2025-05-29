<?php

namespace App\Admin\Extensions\Form;

use Dcat\Admin\Form\Field\Display;

class DisplayField extends Display{
    protected $view = 'admin.form.display';

    public function render(){
        return parent::render();
    }
}