<?php

namespace App\Http\Controllers\Api;

use App\Models\Gagasan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GagasanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'title' => 'required',
                'description' => 'required',
                'category_id' => 'required',
            ]

        );
        $userID =
            Auth::id();
        $gagasan = new Gagasan;
        $gagasan->title = $request->title;
        $gagasan->description = $request->description;
        $gagasan->category_id = $request->category_id;
        $gagasan->user_id = $userID;

        $gagasan->save();

        //save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/gagasans', $gagasan->id . '.' . $image->getClientOriginalExtension());
            $gagasan->image = 'storage/gagssana/' . $gagasan->id . '.' . $image->getClientOriginalExtension();
            $gagasan->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Gagasan anda berhasil disimpan dengan ID ' . $gagasan->id . '. Silahkan gunakan ID untuk memantau gagasan anda. Terima Kasih. '
        ], 201);
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
