@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-6">
            <h3>Category List</h3>


            <div class="tree" id="categories">
                <ul class="list-group">
                    @foreach($rootCategories as $category)
                <li data-jstree='{ "opened" : true }' class="list-group-item justify-content-between my-3">
                            @if(count($category->children))
                                <span class="categoryItem p-0 m-0 flex-grow-1" id="categoryID{{$category->id}}">{{ $category->name }}</span>
                                <div class="btn-group float-right" role="group">
                                    <button type="button" class="btn btn-primary btn-sm add-category" data-item-id="{{ $category->id }}"  data-toggle="tooltip" title="Add category"><i class="fas fa-plus"></i></button>
                                    <button type="button" class="btn btn-primary btn-sm edit-category" data-item-id="{{ $category->id }}" data-item-name="{{ $category->name }}" data-toggle="tooltip" title="Edit category"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-primary btn-sm edit-permisson" data-item-id="{{ $category->id }}" data-toggle="tooltip" title="Edit permission"><i class="fas fa-user-shield"></i></button>
                                </div>
                                @include('categories.children',['children' => $category->children])

                            @else
                                <span class="categoryItem p-0 m-0 flex-grow-1" id="categoryID{{$category->id}}">{{ $category->name }}</span>
                                <div class="btn-group float-right" role="group">
                                    <button type="button" class="btn btn-primary btn-sm add-category" data-item-id="{{ $category->id }}" data-toggle="tooltip" title="Add category"><i class="fas fa-plus"></i></button>
                                    <button type="button" class="btn btn-primary btn-sm edit-category" data-item-id="{{ $category->id }}" data-item-name="{{ $category->name }}" data-toggle="tooltip" title="Edit category"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-primary btn-sm edit-permisson" data-item-id="{{ $category->id }}" data-toggle="tooltip" title="Edit permission"><i class="fas fa-user-shield"></i></button>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-6">
            <h3 class="documents-name">Documents</h3>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Version</th>
                    </tr>
                    @forelse ($documents as $document)
                    <tr class="data-row categoryID{{$document->category_id}} documentsTable" style="display:none;">
                        <td class="name">
                            <a href="{{route('document.download', $document->file_name)}}">
                                {{ $document->name }}
                            </a>
                        </td>
                        <td class="version">{{ $document->version }}</td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4">No documents.</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="add-category-modal" tabindex="-1" role="dialog" aria-labelledby="add-category-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-category-modal-label">Add category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add-category-form" class="form-horizontal" method="POST" action="{{route("categories.store")}}">
                <div class="modal-body" id="attachment-body-content">
                    <div class="card mb-0">
                        <div class="card-body">
                            <input type="hidden" name="modal-input-parent-id" id="modal-input-parent-id">
                            <div class="form-group">
                            <label class="col-form-label" for="modal-input-name">Name</label>
                            <input type="text" name="modal-input-name" class="form-control" id="modal-input-name" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <input type="submit" class="btn btn-primary" value="Add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="edit-category-modal" tabindex="-1" role="dialog" aria-labelledby="edit-category-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-category-modal-label">Edit category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-category-form" class="form-horizontal" method="POST" action="{{route("categories.update")}}">
                <div class="modal-body" id="attachment-body-content">
                    <div class="card mb-0">
                        <div class="card-body">
                            <input type="hidden" name="modal-edit-id" id="modal-edit-id">
                            <div class="form-group">
                            <label class="col-form-label" for="modal-edit-name">Name</label>
                            <input type="text" name="modal-edit-name" class="form-control" id="modal-edit-name" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <input type="submit" class="btn btn-primary" value="Edit">
                    <a href="" name="modal-edit-delete" id="modal-edit-delete" onclick="return confirm('Are you sure?')"
                        class="btn btn-danger">Delete
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Permission Modal -->
<div class="modal fade" id="edit-permisson-modal" tabindex="-1" role="dialog" aria-labelledby="edit-permisson-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-permisson-modal-label">Edit permisson</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-permisson-form" class="form-horizontal" method="POST" action="{{route("permissions.update")}}">
                <div class="modal-body" id="attachment-body-content">
                    <div class="card mb-0">
                        <div class="card-body">
                            <input type="hidden" name="modal-edit-permisson-id" id="modal-edit-permisson-id">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="modal-upload-permisson" name="modal-upload-permisson" value="">
                                <label class="col-form-label" for="modal-upload-permisson">Upload</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="modal-download-permisson" name="modal-download-permisson" value="">
                                <label class="col-form-label" for="modal-download-permisson">Download</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <input type="submit" class="btn btn-primary" value="Edit">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Upload Document Modal -->
<div class="modal fade" id="upload-document-modal" tabindex="-1" role="dialog" aria-labelledby="upload-document-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="upload-document-modal-label">Upload document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="upload-document-form" class="form-horizontal" method="POST" action="{{route("documents.upload")}}" enctype="multipart/form-data">
                <div class="modal-body" id="attachment-body-content">
                    <div class="card mb-0">
                        <div class="card-body">
                            <input type="hidden" name="modal-file-category-id" id="modal-file-category-id">
                            <div class="form-group">
                                <label class="col-form-label" for="modal-file-name">Name</label>
                                <input type="text" name="modal-file-name" class="form-control" id="modal-file-name" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="modal-file">Select file</label>
                                <input type="file" name="modal-file" class="form-control" id="modal-file" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <input type="submit" class="btn btn-primary" value="Upload">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('scripts')
$('#categories').jstree();

//Show and hide selected category's files
$(document).ready(function(){
    $('.categoryItem').click(function(){
        var selectedCategory = $(this).attr('id');
        $('.documentsTable').hide();
        $('.' + selectedCategory).show();
        $('.documents-name').html($(this).text());
    });
});


//Add category modal
$(document).ready(function() {
    /**
     * for showing edit item popup
     */
    $(document).on('click', ".add-category", function() {
        $(this).addClass('add-category-trigger-clicked');
        var options = {
        'backdrop': 'static'
        };
        $('#add-category-modal').modal(options)
    })

    // on modal show
    $('#add-category-modal').on('show.bs.modal', function() {
        var el = $(".add-category-trigger-clicked");
        // get the data
        var parentId = el.data('item-id');
        // fill the data in the input fields
        $("#modal-input-parent-id").val(parentId);
    })

    // on modal hide
    $('#add-category-modal').on('hide.bs.modal', function() {
        $('.add-category-trigger-clicked').removeClass('add-category-trigger-clicked')
        $("#add-category-form").trigger("reset");
    })
})

//Edit category modal
$(document).ready(function() {
    /**
     * for showing edit item popup
     */
    $(document).on('click', ".edit-category", function() {
        $(this).addClass('edit-category-trigger-clicked');
        var options = {
        'backdrop': 'static'
        };
        $('#edit-category-modal').modal(options)
    })

    // on modal show
    $('#edit-category-modal').on('show.bs.modal', function() {
        var el = $(".edit-category-trigger-clicked");
        // get the data
        var id = el.data('item-id');
        var name = el.data('item-name');
        var url = '{{route("categories.delete", ":id")}}';
        url = url.replace(':id', id);
        // fill the data in the input fields
        $("#modal-edit-id").val(id);
        $("#modal-edit-name").val(name);
        $("#modal-edit-delete").attr("href", url);

    })

    // on modal hide
    $('#edit-category-modal').on('hide.bs.modal', function() {
        $('.edit-category-trigger-clicked').removeClass('edit-category-trigger-clicked')
        $("#edit-category-form").trigger("reset");
    })
})

//Edit permissions modal
$(document).ready(function() {
    /**
     * for showing edit item popup
     */
    $(document).on('click', ".edit-permisson", function() {
        $(this).addClass('edit-permisson-trigger-clicked');
        var options = {
        'backdrop': 'static'
        };
        $('#edit-permisson-modal').modal(options)
    })

    // on modal show
    $('#edit-permisson-modal').on('show.bs.modal', function() {
        var el = $(".edit-permisson-trigger-clicked");
        // get the data
        var permissionId = el.data('item-id');
        console.log(permissionId);
        // fill the data in the input fields
        $("#modal-edit-permisson-id").val(permissionId);
    })

    // on modal hide
    $('#edit-permisson-modal').on('hide.bs.modal', function() {
        $('.edit-permisson-trigger-clicked').removeClass('edit-permisson-trigger-clicked')
        $("#edit-permisson-form").trigger("reset");
    })
})


//Upload document modal
$(document).ready(function() {
    /**
     * for showing edit item popup
     */
    $(document).on('click', ".upload-document", function() {
        $(this).addClass('upload-document-trigger-clicked');
        var options = {
        'backdrop': 'static'
        };
        $('#upload-document-modal').modal(options)
    })

    // on modal show
    $('#upload-document-modal').on('show.bs.modal', function() {
        var el = $(".upload-document-trigger-clicked");
        // get the data
        var categoryId = el.data('item-id');
        // fill the data in the input fields
        $("#modal-file-category-id").val(categoryId);
    })

    // on modal hide
    $('#upload-document-modal').on('hide.bs.modal', function() {
        $('.upload-document-trigger-clicked').removeClass('upload-document-trigger-clicked')
        $("#upload-document-form").trigger("reset");
    })
})



@endsection
