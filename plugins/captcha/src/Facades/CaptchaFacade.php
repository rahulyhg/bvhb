<?php

namespace Botble\Captcha\Facades;

use Botble\Captcha\Captcha;
use Illuminate\Support\Facades\Facade;

class CaptchaFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @author DGL Custom
     */
    protected static function getFacadeAccessor()
    {
        return Captcha::class;
    }
}
