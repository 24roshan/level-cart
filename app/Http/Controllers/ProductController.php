<?php

namespace App\Http\Controllers;

class ProductController extends Controller
{
    public function index()
    {
        $products = [
            1 => ['id' => 1, 'name' => 'Laptop', 'price' => 50000],
            2 => ['id' => 2, 'name' => 'Smartphone', 'price' => 20000],
            3 => ['id' => 3, 'name' => 'Headphones', 'price' => 3000],
        ];

        return view('products', compact('products'));
    }
}
