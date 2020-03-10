<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Document;
use Auth;


class CategoryController extends Controller
{
    /**
     * Get a list of all categories and documents
     */
    public function listCategories(){

        $rootCategories = Category::where('parent_category_id', '=', null)->get();
        $allCategories = Category::all();
        $documents = Document::all();

        return view('categories.index',compact('rootCategories','allCategories', 'documents'));
    }

    /**
     * Store a new category int the database
     */
    public function store(Request $request){

        //Check if user is authenticated
        if(!Auth::check()){
            return redirect(route('categoryView'))->with('error', 'You do not have rights to create category!');
        }

        //validate the request
        $this->validate($request, [
            'modal-input-parent-id' => 'required',
            'modal-input-name' => 'required'
        ]);

        //Check if user has permission to create a category
        $checkRights = Auth::user()->categories()->where('category_id', $request->input('modal-input-parent-id'))->first();
        $upladable = null;

        if($checkRights){
           $upladable = $checkRights->pivot->update;
        }

        //Create the category
        if($upladable == 1){
            $category = new Category;
            $category->name = $request->input('modal-input-name');
            $category->parent_category_id = $request->input('modal-input-parent-id');
            $category->save();

            return redirect(route('categoryView'))->with('success', 'Category has been created successfully!');
        }else{
            return redirect(route('categoryView'))->with('error', 'You do not have rights to create category!');
        }
    }

    /**
     * Edit a specified category
     */
    public function update(Request $request){

        //Check if user is authenticated
        if(!Auth::check()){
            return redirect(route('categoryView'))->with('error', 'You do not have rights to update category!');
        }

        //validate the request
        $this->validate($request, [
            'modal-edit-id' => 'required',
            'modal-edit-name' => 'required'
        ]);

        //Check if user has permission to update a category
        $checkRights = Auth::user()->categories()->where('category_id', $request->input('modal-edit-id'))->first();
        $upladable = null;

        if($checkRights){
           $upladable = $checkRights->pivot->update;
        }

        //Update the category
        if($upladable == 1){
            $category = Category::findOrFail($request->input('modal-edit-id'));
            $category->name = $request->input('modal-edit-name');
            $category->save();

            return redirect(route('categoryView'))->with('success', 'Category has been updated successfully!');
        }else{
            return redirect(route('categoryView'))->with('error', 'You do not have rights to update category!');
        }
    }

    /**
     * Edit user permission in a category
     */
    public function editPermisson(Request $request){

        //Check if user is authenticated
        if(!Auth::check()){
            return redirect(route('categoryView'))->with('error', 'You do not have rights to change permissions!');
        }

        //validate the request
        $this->validate($request, [
            'modal-edit-permisson-id' => 'required'
        ]);

        //Find the category
        $category = Category::findOrFail($request->input('modal-edit-permisson-id'));
        $uploadPesmission = 0;
        $downloadPermisson = 0;

        if($request->has('modal-upload-permisson')){
            $uploadPesmission = 1;
        }
        if($request->has('modal-download-permisson')){
            $downloadPermisson = 1;
        }

        //Check if the pivot table is exist, then create or update based on the request
        if($category->users->contains(Auth::user())){
            $category->users()->updateExistingPivot(Auth::user()->id, ['update' => $uploadPesmission, 'download' => $downloadPermisson], false);
        }else{
            $category->users()->attach(Auth::user()->id, ['update' => $uploadPesmission, 'download' => $downloadPermisson]);
        }

        return redirect(route('categoryView'))->with('success', 'Permissons have been updated successfully!');
    }

    /**
     * Delete a category from the database
     */
    public function destroy($id){

        //Check if user is authenticated
        if(!Auth::check()){
            return redirect(route('categoryView'))->with('error', 'You do not have rights to delete this category!');
        }

        //Check if user has permission to delete a category
        $checkRights = Auth::user()->categories()->where('category_id', $id)->first();
        $upladable = null;

        if($checkRights){
           $upladable = $checkRights->pivot->update;
        }

        //Delete the category
        if($upladable == 1){
            $category = Category::findOrFail($id);
            $category->delete();

            return redirect(route('categoryView'))->with('success', 'Category has been deleted successfully!');
        }else{
            return redirect(route('categoryView'))->with('error', 'You do not have rights to delete this category!');
        }

    }
}
