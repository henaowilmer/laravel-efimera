<?php

// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Obtener productos con filtros
        $query = Product::query();

        if ($request->has('active')) {
            $query->where('active', $request->input('active'));
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        if ($request->has('ean13')) {
            $query->where('ean13', $request->input('ean13'));
        }

        $products = $query->get();

        return response()->json($products);
    }


    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        // Crear un nuevo producto
        $product = Product::create([
            'name' => $request->name,
            'active' => $request->active,
            'price' => $request->price,
            'stock' => $request->stock,
            'ean13' => $request->ean13,
        ]);

        return response()->json(['success' => true, 'product' => $product], 201);
    }

    public function update(Request $request, $id)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        // Encontrar el producto
        $product = Product::findOrFail($id);

        // Verificar que el usuario autenticado sea el propietario del producto
        if ($product->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Actualizar el producto
        $product->update([
            'name' => $request->name,
            'active' => $request->active,
            'price' => $request->price,
            'stock' => $request->stock,
            'ean13' => $request->ean13,
        ]);

        return response()->json(['success' => true, 'product' => $product]);
    }

    public function destroy($id)
    {
        // Encontrar el producto
        $product = Product::findOrFail($id);

        // Verificar que el usuario autenticado sea el propietario del producto
        if ($product->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Eliminar el producto
        $product->delete();

        return response()->json(['success' => true]);
    }
}
