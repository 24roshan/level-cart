<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart', compact('cart', 'total'));
    }

    public function add($id)
    {
        $products = [
            1 => ['id' => 1, 'name' => 'Laptop', 'price' => 50000],
            2 => ['id' => 2, 'name' => 'Smartphone', 'price' => 20000],
            3 => ['id' => 3, 'name' => 'Headphones', 'price' => 3000],
        ];

        if (!isset($products[$id])) {
            return back()->with('success', 'Invalid product!');
        }

        $product = $products[$id];
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product['name'],
                "quantity" => 1,
                "price" => $product['price'],
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $quantity = max(1, (int)$request->input('quantity',1));
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Product removed!');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared!');
    }

    public function checkout()
    {
        session()->forget('cart');
        return redirect('/')->with('success', 'Thank you for your purchase!');
    }
}
