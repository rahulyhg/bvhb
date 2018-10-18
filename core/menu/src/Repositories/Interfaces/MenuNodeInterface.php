<?php

namespace Botble\Menu\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface MenuNodeInterface extends RepositoryInterface
{
    /**
     * @param $parent_id
     * @param null array
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     * @author DGL Custom
     */
    public function getByMenuId($menu_id, $parent_id, $select = ['*']);
}
