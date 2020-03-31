<?php


namespace App\Admin\Extensions;


use App\Admin\Models\AppMenu;
use App\Admin\Models\AppRoleMenu;
use App\Admin\Models\AuthMenu;
use App\Admin\Models\AuthRole;
use App\Admin\Models\AuthRoleMenu;
use Encore\Admin\Form\Field;

class CompanyBankCode extends Field
{
    protected $view = 'admin.companyBankCode';

    protected static $css = [
    ];

    protected static $js = [
    ];

    public function __construct($column, $arguments = [])
    {
        parent::__construct($column, $arguments);
    }

    public function render()
    {
        return parent::render();
    }


}

