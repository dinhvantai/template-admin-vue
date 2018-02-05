<?php

namespace App\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Menu;
use App\Models\Category;

class DataComposer
{
	protected $menu;
    protected $category;
    
    public function __construct(
    	Menu $menu,
    	Category $category
    ){
        $this->menu = $menu;
        $this->category = $category;
    }
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Schema::hasTable($this->menu->getTable())) {
            $menu['left'] = $this->menu
                ->where('position', Menu::POSITION_ON_TOP_LEFT)
                ->orderBy('prioty', 'desc')->get();
            
            $menu['right'] = $this->menu
                ->where('position', Menu::POSITION_ON_TOP_RIGHT)
                ->orderBy('prioty', 'desc')->get();

          
            $view->with('userMenu', $menu);
        }
        
        if (Schema::hasTable($this->category->getTable())) {
            $categories = $this->category->with(['childrenCategories' => function($query){
                    $query->where('status', Category::STATUS_SHOW)
                        ->orderBy('prioty', 'desc')->orderBy('id');
                }])
                ->where('type', Category::TYPE_PRODUCT)
                ->where('status', Category::STATUS_SHOW)
                ->whereNull('parent_id')->orWhere('parent_id', 0)
                ->orderBy('prioty', 'desc')->orderBy('id')
                ->get();

            $view->with('userCategories', $categories);
        }
    }
}
