<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Fine;

class FineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role === 'Mahasiswa') {
            // Jika mahasiswa, tampilkan hanya data peminjaman miliknya
            $fines = Fine::whereHas('loan', function ($query) {
                $query->where('user_id', Auth::id());
            })->with('loan.book', 'loan.user')->paginate(10);
        } else {
            // Jika bukan mahasiswa, tampilkan semua data denda
            $fines = Fine::with('loan.book', 'loan.user')->paginate(10);
        }
    
        return view('section.fine', compact('fines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
