<?php

namespace App\Http\Controllers;

use App\Models\Kontrakan;
use Illuminate\Http\Request;

class UserKontrakanController extends Controller
{
    public function index()
    {
        $kontrakans = Kontrakan::with('foto_kontrakans')
            ->orderByRaw("FIELD(status, 'tersedia', 'disewa')")
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('user.kontrakan.index', compact('kontrakans'));
    }


    public function show($slug)
    {
        $kontrakan = Kontrakan::with('foto_kontrakans')->where('slug', $slug)->firstOrFail();

        return view('user.kontrakan.show', compact('kontrakan'));
    }
}
