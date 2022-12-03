<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

class CustomerController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        return Inertia::render('MasterData/Customer/Index', [
            'customers' => User::where('role', 'customer')->latest()->get()
        ]);
    }

    public function create()
    {
        $this->authorize('create', User::class);

        return Inertia::render('MasterData/Customer/Create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required',
            'address' => 'required',
            'password' => ['required', Rules\Password::default()]
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        return to_route('customers.index')->with('message', 'Pelanggan berhasil ditambahkan');
    }

    public function show($id)
    {
        $user = User::find($id);

       return Inertia::render('MasterData/Customer/Show', [
           'user' => $user
       ]);
    }

    public function edit($id)
    {
        $this->authorize('update', auth()->user());

        $user = User::findOrFail($id);

        return Inertia::render('MasterData/Customer/Edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', auth()->user());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'required',
            'address' => 'required',
        ]);

        DB::table('users')
            ->where('id', $request->id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'address' => $request->address
            ]);

        return to_route('customers.index')->with('message', 'Pelanggan berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return to_route('customers.index')->with('message', 'Pelanggan berhasil dihapus');
    }
}
