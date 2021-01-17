<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $categories= DB::table('categories')
                    ->leftjoin('categories_description','categories.categories_id','=','categories_description.categories_id')
                    ->where('categories.categories_status',1)
                    ->get();

        $hometext= DB::table('hometexts')
                ->where('status',1)
                ->get();
    // dd($categories);
       return view('web.index',compact('categories','hometext'));
    }

    public function fastfood()
    {
        $categories= DB::table('categories')
                    ->leftjoin('categories_description','categories.categories_id','=','categories_description.categories_id')
                    ->where('categories.categories_status',1)
                    ->get();
        $hometext= DB::table('hometexts')
                ->where('status',1)
                ->get();
       // dd($categories);
       return view('web.fastfood.index',compact('categories','hometext'));
    }

    public function menudetails($id)
    {
        //dd($id);
       

        $menuitems= DB::table('menuitems')
                    ->leftjoin('itemsto_categories','itemsto_categories.item_id','=','menuitems.item_id')
                    ->leftjoin('categories','categories.categories_id','=','itemsto_categories.categories_id')
                    ->leftjoin('categories_description','categories_description.categories_id','=','itemsto_categories.categories_id')
                     ->where('menuitems.item_status',1)
                     ->where('itemsto_categories.categories_id',$id)
                     ->select('menuitems.*','categories.categories_id','categories_description.categories_name')
                     ->get();

        $tot_item= count($menuitems);
        $categories= DB::table('categories')
                    ->leftjoin('categories_description','categories.categories_id','=','categories_description.categories_id')
                    ->where('categories.categories_status',1)
                    ->get();
        //dd($categories);
        $cat_name= DB::table('categories_description')
        ->where('categories_id',$id)
        ->get();

        return view('web.menu.menudetails',compact('menuitems','tot_item','categories','cat_name'));
    }

    public function list()
    {
        $categories= DB::table('categories')
                    ->leftjoin('categories_description','categories.categories_id','=','categories_description.categories_id')
                    ->where('categories.categories_status',1)
                    ->get();
       // dd($categories);
       $hometext= DB::table('hometexts')
       ->where('status',1)
       ->get();
       
       return view('web.list',compact('categories','hometext'));
    }

    public function menulist($id)
    {
        $menuitems= DB::table('menuitems')
        ->leftjoin('itemsto_categories','itemsto_categories.item_id','=','menuitems.item_id')
        ->leftjoin('categories','categories.categories_id','=','itemsto_categories.categories_id')
        ->leftjoin('categories_description','categories_description.categories_id','=','itemsto_categories.categories_id')
         ->where('menuitems.item_status',1)
         ->where('itemsto_categories.categories_id',$id)
         ->select('menuitems.*','categories.categories_id','categories_description.categories_name')
         ->get();

        $tot_item= count($menuitems);

        $categories= DB::table('categories')
        ->leftjoin('categories_description','categories.categories_id','=','categories_description.categories_id')
        ->where('categories.categories_status',1)
        ->get();

        if($tot_item==0)
        {
            return view('web.menu.empty',compact('categories'));
        }
        
        return view('web.menu.menulist',compact('menuitems','tot_item','categories'));
    }

    public function menudetailsnew($id,$slug)
    {
       $id= $id;
       $slug= $slug;
       $menuitemsindividual= DB::table('menuitems')
                    ->leftjoin('itemsto_categories','itemsto_categories.item_id','=','menuitems.item_id')
                    ->leftjoin('categories','categories.categories_id','=','itemsto_categories.categories_id')
                    ->leftjoin('categories_description','categories_description.categories_id','=','itemsto_categories.categories_id')
                     ->where('menuitems.item_slug',$slug)
                     ->select('menuitems.*','categories.categories_id','categories_description.categories_name')
                     ->get();
         
        //dd($slug);
        $menuitems= DB::table('menuitems')
                    ->leftjoin('itemsto_categories','itemsto_categories.item_id','=','menuitems.item_id')
                    ->leftjoin('categories','categories.categories_id','=','itemsto_categories.categories_id')
                    ->leftjoin('categories_description','categories_description.categories_id','=','itemsto_categories.categories_id')
                     ->where('menuitems.item_status',1)
                     ->where('menuitems.item_slug','!=',$slug)
                     ->where('itemsto_categories.categories_id',$id)
                     ->select('menuitems.*','categories.categories_id','categories_description.categories_name')
                     ->get();
        //dd($menuitems);
        $tot_item= count($menuitems);
       // dd($tot_item);
        $categories= DB::table('categories')
                    ->leftjoin('categories_description','categories.categories_id','=','categories_description.categories_id')
                    ->where('categories.categories_status',1)
                    ->get();

        return view('web.menu.menudetails',compact('menuitemsindividual','menuitems','tot_item','categories'));

    }

}
