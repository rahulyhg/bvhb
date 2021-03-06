<?php

namespace Botble\Gallery;

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
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('gallery_meta');
    }
}
