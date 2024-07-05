<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\TodoCategory;

class TodoCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $categories = TodoCategory::all();
        return view('todocategory.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|unique:todo_categories',
        ]);
        
        $value = [
            'category' => $request->category,
            'user_id' => Auth::user()->id,
        ];

        TodoCategory::create($value);
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy(string $id)
    {
        $category= TodoCategory::find($id);// Ensure the authenticated user owns the category (optional)

        $category->delete(); // Delete the category
        return redirect()->route('todocategories.index')->with('success', 'Kategori berhasil dihapus!'); // Redirect with success message
    }
}
