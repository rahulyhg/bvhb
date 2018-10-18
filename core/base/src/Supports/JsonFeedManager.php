<?php

namespace Botble\Base\Supports;

class JsonFeedManager
{
    /**
     * @var mixed
     */
    protected $items = [];

    /**
     * JsonFeedManager constructor.
     * @author DGL Custom
     */
    public function __construct()
    {
        admin_bar()->setIsDisplay(false);
    }

    /**
     * @param array $item
     * @return $this
     * @author DGL Custom
     */
    public function addItem($key, array $item)
    {
        $this->items[$key][] = $item;
        return $this;
    }

    /**
     * @return mixed
     * @author DGL Custom
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return mixed
     * @author DGL Custom
     */
    public function render()
    {
        return [
            'version' => 'https://jsonfeed.org/version/1',
            'title' => 'Json Feed',
            'home_page_url' => route('public.index'),
            'feed_url' => route('public.feed.json'),
            'icon' => config('core.base.general.favicon'),
            'favicon' => config('core.base.general.favicon'),
            'items' => $this->getItems(),
        ];
    }
}
