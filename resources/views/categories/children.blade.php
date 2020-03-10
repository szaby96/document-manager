<ul class="nested">

    @foreach($children as $child)
    <li data-jstree='{ "opened" : true }' class="my-3">

        @if(count($child->children))

            <span class="categoryItem" id="categoryID{{$child->id}}">{{ $child->name }}</span>
            <div class="btn-group float-right" role="group">
                <button type="button" class="btn btn-primary btn-sm add-category" data-item-id="{{ $child->id }}" data-toggle="tooltip" title="Add category"><i class="fas fa-plus"></i></button>
                <button type="button" class="btn btn-primary btn-sm edit-category" data-item-id="{{ $child->id }}" data-item-name="{{ $child->name }}" data-toggle="tooltip" title="Edit category"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-primary btn-sm upload-document" data-item-id="{{ $child->id }}" data-toggle="tooltip" title="Upload file"><i class="fas fa-file"></i></button>
                <button type="button" class="btn btn-primary btn-sm edit-permisson" data-item-id="{{ $child->id }}" data-toggle="tooltip" title="Edit permission"><i class="fas fa-user-shield"></i></button>
            </div>

            @include('categories.children',['children' => $child->children])

        @else
            <span class="categoryItem" id="categoryID{{$child->id}}">{{ $child->name }}</span>
            <div class="btn-group float-right" role="group">
                <button type="button" class="btn btn-primary btn-sm add-category" data-item-id="{{ $child->id }}" data-toggle="tooltip" title="Add category"><i class="fas fa-plus"></i></button>
                <button type="button" class="btn btn-primary btn-sm edit-category" data-item-id="{{ $child->id }}" data-item-name="{{ $child->name }}" data-toggle="tooltip" title="Edit category"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-primary btn-sm upload-document" data-item-id="{{ $child->id }}" data-toggle="tooltip" title="Upload file"><i class="fas fa-file"></i></button>
                <button type="button" class="btn btn-primary btn-sm edit-permisson" data-item-id="{{ $child->id }}" data-toggle="tooltip" title="Edit permission"><i class="fas fa-user-shield"></i></button>
            </div>
        @endif

    </li>
    @endforeach

</ul>
