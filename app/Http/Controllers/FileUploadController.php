<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;


class FileUploadController extends Controller
{
 

    public function store(Request $request)
    {
        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('public/videos');
            $file = basename($path);
            $save = new File;
            $save->name = "Screen record";
            $save->path = $file;
            if($save->save()){
            return back()->with('success','File Has been uploaded successfully');
            }else{
                return back()->with('fail','There was somthing wrong');
            }

         }
    }

    public function destroy($id)
    {
      $file=File::find($id);
      Storage::delete('file.jpg');
      $path = 'videos/';
      $store_path = $path . $file->path;
      Storage::disk('public')->delete($store_path);

      if($file->delete()){
        return redirect('/admin/dashboard')->with('success','Record was deleted successfully!');
    }else{
            return redirect('/admin/dashboard')->with('fail','There was somthing wrong!');
        }
    }

}
