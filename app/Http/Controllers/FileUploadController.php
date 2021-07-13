<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;


class FileUploadController extends Controller
{
    public function store(Request $request)
    {
         
        $validatedData = $request->validate([
         'file' => 'required|mimes:webm|max:5000',
        ]);

        $name = $request->file('file')->getClientOriginalName();
        $path = $request->file('file')->store('public/files');
 
        $save = new File;
        $save->name = $name;
        $save->path = $path;
 

        if($save->save()){
           return back()->with('success','File Has been uploaded successfully');
        }else{
            return back()->with('fail','There was somthing wrong');
        }
 
 
    }
}
