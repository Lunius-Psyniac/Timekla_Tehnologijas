<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function delete(Request $request)
    {
        $index = $request->input('index');
        $items = session()->get('items', []);
        unset($items[$index]);
        session()->put('items', $items);

        return response()->json(['items' => $items]);
    }
}