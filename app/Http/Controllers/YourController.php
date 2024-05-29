<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YourController extends Controller
{
    public function getList()
    {
        return view('list', ['items' => session('items', [])]);
    }

    public function addItem(Request $request)
    {
        $field1 = $request->input('field1');
        $field2 = $request->input('field2');

        $item = $field1 . ' - ' . $field2;
        
        $items = session()->get('items', []);
        $items[] = $item;
        session(['items' => $items]);

        return response()->json(['items' => $items]);
    }
}

