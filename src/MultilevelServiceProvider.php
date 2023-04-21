<?php

namespace Ake\Multilevel;

use Ake\Multilevel\Form\Multilevel;
use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Form;

class MultilevelServiceProvider extends ServiceProvider
{
	protected $js = [
        'js/index.js',
    ];
	protected $css = [
		'css/index.css',
	];

	public function register()
	{
		//
	}

	public function init()
	{
		parent::init();

        Form::extend('multilevel', Multilevel::class);

        $this->publishable();

	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
