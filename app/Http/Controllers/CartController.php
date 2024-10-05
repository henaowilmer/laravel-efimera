<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Obtener el producto
        $product = Product::findOrFail($request->product_id);

        // Verificar stock
        if ($request->quantity > $product->stock) {
            return response()->json(['error' => 'Stock insuficiente'], 400);
        }

        // Calcular el total (puedes agregar lógica para impuestos aquí)
        $totalPrice = $product->price * $request->quantity;
        $taxes = $totalPrice * 0.15; // Ejemplo: 15% de impuestos

        // Crear el carrito
        $cart = Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice + $taxes,
            'taxes' => $taxes,
        ]);

        return response()->json(['message' => 'Producto añadido al carrito', 'cart' => $cart], 201);
    }

    public function viewCart()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        return response()->json($cartItems);
    }

    public function removeFromCart($id)
    {
        $cartItem = Cart::where('user_id', auth()->id())->findOrFail($id);
        $cartItem->delete();

        return response()->json(['message' => 'Producto eliminado del carrito'], 200);
    }
}
