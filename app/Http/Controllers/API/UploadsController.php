<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Uploads;

class UploadsController extends Controller
{
    public function index()
    {   
        return response()->json(['uploads' => Uploads::all()]);
    }

    public function store(Request $request)
    {
        
        $file = $request->file->store('public/uploads');
        $name = $request->file->getClientOriginalName();
        
        $uploads = Uploads::create([
            'title' => $name,
            'path' => $file,
            'user_id' => $request->user_id,
            'author_id' => $request->author_id
        ]);

        return response()->json(['success' => $uploads], 200);
    }
}
