<?php

namespace Botble\Menu\Models;

use Eloquent;

class Menu extends Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * @return mixed
     * @author DGL Custom
     */
    public function menuNodes()
    {
        return $this->hasMany(MenuNode::class, 'menu_id');
    }

    /**
     * @author DGL Custom
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Menu $menu) {
            MenuNode::where('menu_id', $menu->id)->delete();
        });
    }
}
