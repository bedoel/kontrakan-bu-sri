<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Sewa;
use Illuminate\Support\Facades\Auth;

class UserSewaComposer
{
    public function compose(View $view): void
    {
        $punyaSewaAktif = false;

        if (Auth::guard('user')->check()) {
            $punyaSewaAktif = Sewa::where('user_id', Auth::guard('user')->id())
                ->where('status', 'aktif')
                ->exists();
        }

        $view->with('punyaSewaAktif', $punyaSewaAktif);
    }
}
