<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::withCount('videos')->get();

        return response()->json([
            'message' => 'Categories retrieved successfully',
            'status' => true,
            'data' => $categories
        ]);
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        $category->load('videos');

        return response()->json([
            'message' => 'Category retrieved successfully',
            'status' => true,
            'data' => $category
        ]);
    }
}
