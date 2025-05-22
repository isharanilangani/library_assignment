<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BorrowedBook;
use Illuminate\Support\Facades\Auth;

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

    public function borrow($id)
    {
        $userId = 1;

        $alreadyBorrowed = BorrowedBook::where('user_id', $userId)
                                    ->where('book_id', $id)
                                    ->whereNull('returned_date')
                                    ->first();

        if (!$alreadyBorrowed) {
            BorrowedBook::create([
                'user_id' => $userId,
                'book_id' => $id,
                'borrowed_at' => now(),
                'status' => 'pending',
            ]);
        }

        return response()->json(['message' => 'Book borrowed']);
    }

    public function return($id)
    {
        $userId = 1;

        $borrow = BorrowedBook::where('user_id', $userId)
            ->where('book_id', $id)
            ->whereNull('returned_date')
            ->first();

        if (!$borrow) {
            return response()->json(['message' => 'Book not found or already returned'], 404);
        }

        $borrow->update([
            'returned_date' => now(),
            'status' => 'returned',
        ]);

        return response()->json(['message' => 'Book returned']);
    }
    public function borrowed()
    {
    $userId = 1;

    $books = Book::whereIn('id', function ($query) use ($userId) {
            $query->select('book_id')
                ->from('borrowed_books')
                ->where('user_id', $userId)
                ->whereNull('returned_date');
        })->get();
        
    return response()->json($books);
    }
}
