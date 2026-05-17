<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

class ImpersonateController extends Controller
{
    public function startImpersonate(User $user): RedirectResponse
    {
        if (! auth()->user()->can('users.impersonate')) {
            abort(403);
        }
        session([
            'impersonator_id' => auth()->id(),
        ]);

        auth()->login($user);

        return redirect('/dashboard');
    }

    public function stopImpersonate(User $user): RedirectResponse
    {
        $impersonatorId = session('impersonator_id');

        if (! $impersonatorId) {
            return redirect('/dashboard');
        }

        $admin = User::findOrFail($impersonatorId);

        auth()->login($admin);

        session()->forget('impersonator_id');

        return redirect('/admin/manage-users');
    }
}
