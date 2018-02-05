<?php

namespace App\Http\Controllers\User;

use App\Models\Menu;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $homeCategories = Category::with(['childrenCategories' => function($query){
            $query->where('status', Category::STATUS_SHOW)
                ->orderBy('prioty', 'desc')->orderBy('id');
        }])
        ->where('type', Category::TYPE_PRODUCT)
        ->where('status', Category::STATUS_SHOW)
        ->whereNull('parent_id')->orWhere('parent_id', 0)
        ->orderBy('prioty', 'desc')->orderBy('id')
        ->take(5)->get();

        foreach ($homeCategories as $key => $category) {
            $categoryIds = array_merge(
                [$category->id], 
                $category->childrenCategories()->pluck('id')->toArray()
            );
            
            $homeCategories[$key]->products = Product::where('status', Product::STATUS_SHOW)                
                ->whereIn('category_id', $categoryIds)
                ->orderBy('prioty', 'desc')->orderBy('id', 'desc')
                ->take(8)->get();
        }

        return view('user.index', compact(['homeCategories']));
    }

    public function categoryParent($parent)
    {
        $category = Category::with('childrenCategories')
            ->where('status', Category::STATUS_SHOW)->where('slug', $parent)
            ->whereNull('parent_id')->orWhere('parent_id', 0)
            ->first();

        if (!$category) {
            return redirect('/');
        }

        $categoryIds = array_merge(
            [$category->id], 
            $category->childrenCategories()->pluck('id')->toArray()
        );

        if ($category->type === Category::TYPE_PRODUCT) {
            $products = Product::where('status', Product::STATUS_SHOW)                
                ->whereIn('category_id', $categoryIds)
                ->orderBy('prioty', 'desc')->orderBy('id', 'desc')
                ->paginate(10);

            return view('user.category.parent-product', compact(['category', 'products']));
        }
    }

    public function categoryChildren($parent, $children)
    {
        $categoryParent = Category::with('childrenCategories')
            ->where('status', Category::STATUS_SHOW)->where('slug', $parent)
            ->whereNull('parent_id')->orWhere('parent_id', 0)
            ->first();
        
        if (!$categoryParent) {
            return redirect('/');
        }
        
        $category = Category::where('status', Category::STATUS_SHOW)
            ->where('parent_id', $categoryParent->id)
            ->where('slug', $children)->first();

        if (!$category) {
            return redirect()->route('user.category.parent', [$categoryParent->slug]);
        }

        if ($category->type === Category::TYPE_PRODUCT) {
            $products = Product::where('status', Product::STATUS_SHOW)                
                ->where('category_id', $category->id)
                ->orderBy('prioty', 'desc')->orderBy('id', 'desc')
                ->paginate(10);

            return view('user.category.children-product', compact(['category', 'products', 'categoryParent']));
        }
    }

    public function detailProduct($slug)
    {
        $data['product'] = Product::with('category.parentCategory')
            ->where('status', Product::STATUS_SHOW)
            ->where('slug', $slug)->first();
        
        if(!$data['product']) {
            return redirect('/');
        }

        if ($data['product']->category->parentCategory) {
            $parentCategory = $data['product']->category->parentCategory;
            $categoryIds =  $parentCategory->childrenCategories()->pluck('id')->toArray();
        } else {
            $categories = $data['product']->category->childrenCategories()->pluck('id')->toArray();
            $categoryIds = array_merge([$data['product']->category->id], $categories);
        }
        
        $data['productRelation'] = Product::where('status', Product::STATUS_SHOW)
            ->whereIn('category_id', $categoryIds)
            ->where('id', '<>', $data['product']->id)
            ->take(12)->get();

        return view('user.product.detail', compact(['data']));
    }
}
