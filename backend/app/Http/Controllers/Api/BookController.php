<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
   public function index(Request $request)
    {
        $query = Book::query();

        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%")
                  ->orWhere('genre', 'like', "%{$request->search}%");
        }

        return response()->json($query->paginate(10));
    }

    public function borrow(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $borrowed = session()->get('borrowed', []);
        if (!in_array($id, $borrowed)) {
            $borrowed[] = $id;
        }
        session(['borrowed' => $borrowed]);
        return response()->json(['message' => 'Book borrowed']);
    }

    public function return($id)
    {
        $borrowed = session()->get('borrowed', []);
        $borrowed = array_diff($borrowed, [$id]);
        session(['borrowed' => $borrowed]);
        return response()->json(['message' => 'Book returned']);
    }

    public function borrowed()
    {
        $borrowedIds = session('borrowed', []);
        $books = Book::whereIn('id', $borrowedIds)->get();
        return response()->json($books);
    }
}
