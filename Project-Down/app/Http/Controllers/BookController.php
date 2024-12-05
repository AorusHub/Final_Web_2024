<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $filter = $request->input('filter', 'title'); // Default ke 'title'

        // Validasi input
        $request->validate([
            'query' => 'required|string|max:255',
            'filter' => 'in:title,author,category',
        ]);

        // Query berdasarkan filter
        $books = Book::where($filter, 'LIKE', '%' . $query . '%')->get();

        // Return view dengan hasil pencarian
        return view('section.search', compact('books'));
    }
    // Menampilkan halaman katalog buku
    public function index()
    {
        $books = Book::paginate(10);
        return view('section.catalog', compact('books'));
    }

    // Menampilkan detail buku berdasarkan ID
    public function show($id)
    {
        $book = Book::find($id);

        // Jika buku tidak ditemukan, redirect ke halaman katalog
        if (!$book) {
            return redirect()->route('catalog')->with('error', 'Buku tidak ditemukan.');
        }

        return view('section.detail', compact('book'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:books|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|int|min:0',
            'stock' => 'required|integer|min:1',
            'category' => 'required|string|max:100',
            'book_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url'
        ], [
            'title.required' => 'Judul buku harus diisi.',
            'title.unique' => 'Judul buku sudah ada, silakan pilih judul lain.',
            'author.required' => 'Penulis buku harus diisi.',
            'price.required' => 'Harga buku harus diisi.',
            'price.integer' => 'Harga buku harus berupa angka.',
            'price.min' => 'Harga buku tidak boleh kurang dari 1.',
            'stock.required' => 'Stok buku harus diisi.',
            'stock.integer' => 'Stok buku harus berupa angka.',
            'stock.min' => 'Stok buku tidak boleh kurang dari 0.',
            'category.required' => 'Kategori buku harus diisi.',
        ]);

        // Simpan data produk
        // Menangani unggahan gambar (file)
        if ($request->hasFile('book_image')) {
            // Mendapatkan nama file dan menyimpan dengan nama unik
            $fileName = time() . '_' . $request->file('book_image')->getClientOriginalName();
            // Menyimpan gambar di folder public/images
            $filePath = $request->file('book_image')->storeAs('images', $fileName, 'public');
            // Menyimpan path gambar untuk database
            $validated['image_path'] = '/storage/' . $filePath;
        }
        // Menangani URL gambar eksternal
        elseif ($request->input('image_url')) {
            // Menyimpan URL gambar jika diberikan
            $validated['image_path'] = $request->input('image_url');
        }
        // Menangani kasus jika tidak ada gambar yang diberikan
        else {
            $validated['image_path'] = null;
        }
        
        $book = Book::create($validated);
        return redirect()->route('catalog.index')->with('success', 'Data buku berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $book = Book::find($id);

        // Jika buku tidak ditemukan, redirect ke halaman katalog
        if (!$book) {
            return redirect()->route('catalog')->with('error', 'Buku tidak ditemukan.');
        }

        return view('section.catalog.edit_catalog', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);
    
        if (!$book) {
            return redirect()->route('catalog.index')->with('error', 'Buku tidak ditemukan.');
        }
    
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('books')->ignore($book->id),
            ],
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:100',
            'book_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url',
        ], [
            'title.required' => 'Judul buku harus diisi.',
            'title.unique' => 'Judul buku sudah ada, silakan pilih judul lain.',
            'author.required' => 'Penulis buku harus diisi.',
            'stock.required' => 'Stok buku harus diisi.',
            'stock.integer' => 'Stok buku harus berupa angka.',
            'stock.min' => 'Stok buku tidak boleh kurang dari 0.',
            'category.required' => 'Kategori buku harus diisi.',
            'book_image.image' => 'File harus berupa gambar.',
            'book_image.mimes' => 'Jenis gambar harus berupa JPEG, PNG, JPG, atau GIF.',
            'book_image.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            'image_url.url' => 'URL gambar tidak valid.',
        ]);
    
        // Update the fields
        $book->title = $validated['title'];
        $book->author = $validated['author'];
        $book->publisher = $validated['publisher'];
        $book->description = $validated['description'];
        $book->stock = $validated['stock'];
        $book->category = $validated['category'];
    
    // Menangani gambar yang diupload
    // Menangani gambar yang diupload
    if ($request->hasFile('book_image')) {
        // Hapus gambar lama jika ada
        if ($book->image_path && Storage::exists(str_replace('/storage/', '', $book->image_path))) {
            Storage::delete(str_replace('/storage/', '', $book->image_path));
        }

        // Upload gambar baru
        $fileName = time() . '_' . $request->file('book_image')->getClientOriginalName();
        $filePath = $request->file('book_image')->storeAs('images', $fileName, 'public');
        $book->image_path = '/storage/' . $filePath;  // Menyimpan path gambar yang baru
    }
    // Menangani URL gambar eksternal
    elseif ($request->input('image_url')) {
        // Hapus gambar lama jika ada
        if ($book->image_path && Storage::exists(str_replace('/storage/', '', $book->image_path))) {
            Storage::delete(str_replace('/storage/', '', $book->image_path));
        }

        // Mendapatkan gambar dari URL eksternal
        $imageUrl = $request->input('image_url');
        $imageContents = file_get_contents($imageUrl);

        // Membuat nama file unik untuk gambar
        $fileName = Str::random(40) . '.' . pathinfo($imageUrl, PATHINFO_EXTENSION);

        // Simpan gambar yang diunduh di folder 'public/images'
        $filePath = Storage::disk('public')->put('images/' . $fileName, $imageContents);

        // Setel path gambar lokal yang baru
        $book->image_path = '/storage/images/' . $fileName;
    }
    
        $book->save();
    
        return redirect()->route('catalog.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return redirect()->route('catalog')->with('error', 'Buku tidak ditemukan.');
        }

        $book->delete();
        return redirect()->route('catalog.index')->with('success', 'Data buku berhasil dihapus.');
    }

}
