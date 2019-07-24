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
        // dd($request->all());
        $file = $request->file->store('/public/uploads');
        $name = $request->file->getClientOriginalName();


        $remove = 'public/';
        $filename = str_replace($remove, "", $file);

        $uploads = Uploads::create([
            'title' => $name,
            'path' => 'storage/' .$filename,
            'user_id' => $request->user_id,
            'author_id' => $request->author_id
        ]);
        
        return response()->json(['success' => $uploads], 200);
    }

    public function show($id)
    {
        $file = Uploads::where('user_id' , $id)->get();

        if(!$file){
            return response()->json('File Not Found');
        }
        
        return response()->json(['file' => $file]);
        
    }

    public function destroy($id)
    {   
        $upload = Uploads::find($id);    
        // Storage::delete($upload->title);
        // $documents = Document::where('title', $upload->title)->get();
        //     foreach ($documents as $document) {
        //         Storage::disk('uploads')->delete($document->title);
        //         $document->delete();
        //     }
        $upload->delete();

        return response()->json(['success' => 'file Deleted']);
    }

    public function storeExcel(Request $request){
        dd($request->file);
        if($request->hasFile('file')){
            $extension = File::extension($request->file->getClientOriginalName());
           
             $data = Excel::load($path, function($reader) {
             })->get();
            
            }
        return response()->json(['success' => 'I am here']); 
    }
}
