<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index(){
        $types = response()->json(ProductType::all());
        return $types;
    }

    public function show($id){
        $type = response()->json(ProductType::find($id));
        return $type;
    }

    public function store(Request $request){
        $type = new ProductType();
        $type->name = $request->name;
        $type->description = $request->description;
        $type->cost = $request->cost;
        
        $type->save();
    }

    public function update(Request $request, $id){
        $type = ProductType::find($id);
        $type->name = $request->name;
        $type->description = $request->description;
        $type->cost = $request->cost;

        $type->save();
    }

    public function destroy($id){
        ProductType::find($id)->delete();
    }

    public function elsoFeladat($id){
        $ertek = ProductType::with('product')
            ->where('type_id', '=', $id)
            ->get();

        return $ertek;
    }
}
