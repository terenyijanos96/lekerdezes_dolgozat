<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BasketController extends Controller
{
    public function index()
    {
        return response()->json(Basket::all());
    }

    public function show($user_id, $item_id)
    {
        $basket = Basket::where('user_id', $user_id)
            ->where('item_id', "=", $item_id)
            ->get();
        return $basket[0];
    }

    public function store(Request $request)
    {
        $item = new Basket();
        $item->user_id = $request->user_id;
        $item->item_id = $request->item_id;

        $item->save();
    }

    public function update(Request $request, $user_id, $item_id)
    {
        $item = $this->show($user_id, $item_id);
        $item->user_id = $request->user_id;
        $item->item_id = $request->item_id;

        $item->save();
    }

    public function destroy($user_id, $item_id)
    {
        $this->show($user_id, $item_id)->delete();
    }

    public function feladatKetto()
    {

        $user = Auth::user()->id;
        return DB::table('baskets as b')
            ->select('pt.type_id', 'pt.name')
            ->join('products as p', 'b.item_id', '=', 'p.item_id')
            ->join('product_types as pt', 'p.type_id', '=', 'pt.type_id')
            ->where('user_id', '=', $user)
            ->where('pt.name', 'like', 'B%')
            ->get();
    }

    public function feladatHarom($item_id)
    {
        $user_id = Auth::user()->id;
        $ido = now();

        DB::insert('insert into baskets (user_id, item_id, created_at, updated_at) values (?,?, ?, ?)', [$user_id, $item_id, $ido, $ido]);
    }
}
