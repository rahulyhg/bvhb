<?php

namespace Botble\Member;

use Botble\Base\Interfaces\PluginInterface;
use Schema;

class Plugin implements PluginInterface
{

    /**
     * @author DGL Custom
     */
    public static function activate()
    {
    }

    /**
     * @author DGL Custom
     */
    public static function deactivate()
    {
    }

    /**
     * @author DGL Custom
     */
    public static function remove()
    {
        Schema::dropIfExists('members');
        Schema::dropIfExists('member_password_resets');
    }
}
