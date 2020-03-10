<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Document;
use Auth;
use Carbon\Carbon;

class DocumentsController extends Controller
{

    /**
     * Downloads a file by file name
     */
    public function download($file_name){

        //Check if user is authenticated
        if(!Auth::check()){
            return redirect(route('categoryView'))->with('error', 'You do not have rights to download this file!');
        }

        //Check if user has permission to download the file
        $file = Document::where('file_name', $file_name)->first();
        $userFile = Auth::user()->categories()->where('category_id', $file->category_id)->first();
        $downloadable = null;

        if($userFile){
           $downloadable = $userFile->pivot->download;
        }

        //Handle file download
        if($downloadable == 1){
            $path = storage_path().'\app\private\\'.$file_name;

            if (file_exists($path)){
                return response()->download(storage_path().'\app\private\\'.$file_name);
            }else{
                return redirect(route('categoryView'))->with('error', 'File not found!');
            }
        }else{
            return redirect(route('categoryView'))->with('error', 'You do not have rights to download this file!');
        }


    }

    /**
     * Store the updated file in the database and in the storage folder
     */
    public function store(Request $request){

        //Check if user is authenticated
        if(!Auth::check()){
            return redirect(route('categoryView'))->with('error', 'You do not have rights to upload files!');
        }

        //Validate the request
        $this->validate($request, [
            'modal-file-name' => 'required',
            'modal-file-category-id' => 'required',
            'modal-file' => 'required|max:1999'
        ]);

        //Check if the specified category is in the root
        if(Category::where('id', $request->input('modal-file-category-id'))->value('parent_category_id') == null){
            return redirect(route('categoryView'))->with('error', 'You cannot upload files in a root category!');
        }

        //Check if user has permission to update the file
        $checkRights = Auth::user()->categories()->where('category_id', $request->input('modal-file-category-id'))->first();
        $upladable = null;

        if($checkRights){
           $upladable = $checkRights->pivot->update;
        }

        //Update file
        if($upladable == 1){

            //Upload file to the storage
            if($request->hasFile('modal-file')){
                // Get filename with the extension
                $filenameWithExt = $request->file('modal-file')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('modal-file')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore= $filename.'_'.time().'.'.$extension;
                // Upload Image
                $path = $request->file('modal-file')->storeAs('private', $fileNameToStore);
            } else {
                return redirect(route('categoryView'))->with('error', 'No files found!');
            }

            $document = new Document;
            $version = 1;

            //Check if the document has previous versions, if has, get the latest plus one
            if(Document::where('name', $request->input('modal-file-name'))->where('category_id', $request->input('modal-file-category-id'))->exists()){
                $latestDocument = Document::where('name', $request->input('modal-file-name'))->orderBy('version', 'desc')->first();
                $version = $latestDocument->version + 1;
            }

            //Add file to the database
            $document->name = $request->input('modal-file-name');
            $document->category_id = $request->input('modal-file-category-id');
            $document->version = $version;
            $document->updatedBy_id = Auth::user()->id;
            $document->file_name = $fileNameToStore;
            $document->created_at= Carbon::now()->format('Y-m-d H:i:s');
            $document->updated_at= Carbon::now()->format('Y-m-d H:i:s');
            $document->save();

            return redirect(route('categoryView'))->with('success', 'Upload successfull');
        }else{
            return redirect(route('categoryView'))->with('error', 'You do not have rights to upload files!');
        }

    }



}
