<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Bookshelf;
use App\Models\Loan;
use App\Models\LoanDetail;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(){
        $data['books'] = Book::with('bookshelf')->get();
        return view('loan.index', $data);
    }
    public function create(Request $request)
    {
        $books = Book::all(); // Semua buku untuk dropdown jika user memilih lebih dari satu buku.
        $selectedBook = null;

        if ($request->has('book_id')) {
            $selectedBook = Book::find($request->book_id);
        }

        return view('loan.create', compact('books', 'selectedBook'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'loan_at' => 'required|date',
            'return_at' => 'required|date|after_or_equal:loan_at',
            'book_ids' => 'required|array',
            'book_ids.*' => 'exists:books,id',
        ]);

        // Simpan data peminjaman
        $loan = Loan::create([
            'user_id' => $validated['user_id'],
            'loan_at' => $validated['loan_at'],
            'return_at' => $validated['return_at'],
        ]);

        // Mengurangi stok buku
        foreach ($validated['book_ids'] as $bookId) {
            $book = Book::find($bookId);
            if ($book->stock > 0) {
                $book->decrement('stock');
            } else {
                return redirect()->back()->withErrors(['error' => "Stok buku '{$book->title}' habis!"]);
            }

            // Simpan relasi peminjaman dengan buku
            $loan->books()->attach($bookId);
        }

        return redirect()->route('loan')->with('success', 'Peminjaman berhasil!');
    }

}
