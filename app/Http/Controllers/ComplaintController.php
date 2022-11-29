<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'customer') {
            $complaints = $user->complaints()->latest()->get();
        } else if ($user->role === 'admin' || $user->role === 'manager') {
            $complaints = DB::table('complaints')
                ->leftJoin('users', 'complaints.user_id', '=', 'users.id')
                ->select('complaints.*', 'users.name')->latest()->get();
        }

        $collection = $complaints->map( function ($complaint) {
            return [
                'id' => $complaint->id,
                'user_id' => $complaint->user_id,
                'title' => Str::limit($complaint->title, 30),
                'description' => Str::limit($complaint->description, 30),
                'url' => $complaint->url,
                'status' => $complaint->status,
                'created_at' => $complaint->created_at,
                'updated_at' => $complaint->updated_at,
                'name' => $complaint->name,
                'keterangan' => $complaint->keterangan,
            ];
        });

        return Inertia::render('Complaint/Index', [
            'complaints' => $collection,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->has('title')) {
            return Inertia::render('Complaint/Create', [
                'title' => $request->title
            ]);
        }
        return Inertia::render('Complaint/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'photo' => 'required'
        ]);

        $path = $request->file('photo')->store('public/complaints');

        Complaint::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $path,
            'url' => Storage::url($path)
        ]);

        return to_route('complaints.index')->with('message', 'Pengaduan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Complaint $complaint
     * @return \Illuminate\Http\Response
     */
    public function show(Complaint $complaint)
    {
        $username = $complaint->user->name;
        $status = ['pending', 'process', 'done'];

        return Inertia::render('Complaint/Show', [
            'complaint' => $complaint,
            'username' => $username,
            'status' => $status
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Complaint $complaint
     * @return \Illuminate\Http\Response
     */
    public function edit(Complaint $complaint)
    {
        return Inertia::render('Complaint/Edit', [
            'complaint' => $complaint
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Complaint $complaint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Complaint $complaint)
    {
        $this->authorize('update', $complaint);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $complaint->update($request->only(['title', 'description']));

        return to_route('complaints.index')->with('message', 'Pengaduan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Complaint $complaint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complaint $complaint)
    {
        Storage::delete($complaint->photo);

        $complaint->delete();

        return to_route('complaints.index')->with('message', 'Pengaduan berhasil dihapus');
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $this->authorize('update', $complaint);

        $request->validate([
            'status' => 'required',
            'keterangan' => 'required|string|max:255'
        ]);

        $complaint->update($request->only(['status', 'keterangan']));

        return to_route('complaints.index')->with('message', 'Pengaduan berhasil diupdate');
    }
}
