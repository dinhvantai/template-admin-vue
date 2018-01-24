<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\Helper;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Http\Controllers\Api\ApiController;

class MenuController extends ApiController
{
    protected $apiProvider = 'users';

    public function  __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menus = Menu::with(['childrenMenus' => function($query){
            $query->orderBy('prioty', 'desc');
        }])
        ->whereNull('parent_id')->orWhere('parent_id', 0)
        ->orderBy('prioty', 'desc')->get();

        return $this->response($menus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        if (Menu::create($request->all())) {
            return $this->response(['message' => trans('message.add_success')]);
        }

        return $this->response(['message' => trans('message.add_failed')], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        if ($menu->fill($request->all())->save()) {
            return $this->response(['message' => trans('message.edit_success')]);
        }

        return $this->response(['message' => trans('message.edit_failed')], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        if (!$menu->parent_id) {
            $menu->load('childrenMenus');
            if ($menu->childrenMenus()->count()) {
                return $this->response(['message' => trans('message.delete_children_before')], 401);
            }
        }
        if ($menu->delete()) {
            return $this->response(['message' => trans('message.delete_success')]);
        }

        return $this->response(['message' => trans('message.delete_failed')], 401);
    }
}
