@extends('backend.master')

@section('title','Asset Management')

@section('content')

<div class="row">
    <div class="col-lg-12 mb-4">
        <h3 class="fw-bold">Asset Management</h3>
    </div>
</div>

<div class="row">

    <!-- Asset List -->
    <div class="col-lg-7 col-12">
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0">Asset List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="assetTable" class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Asset Name</th>
                                <th>Description</th>
                                <th>Properties</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add / Edit Form -->
    <div class="col-lg-5 col-12">

        <!-- Add Asset -->
        <div id="addForm">
            <form id="addAssetForm" enctype="multipart/form-data">
                @csrf
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">Add New Asset</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Asset Name</label>
                            <input type="text" name="asset_name" class="form-control" placeholder="Enter asset name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="3"
                                placeholder="Enter description"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Asset Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Properties</label>
                            <div id="propertyWrapper">
                                <div class="input-group mb-2 property-row">
                                    <input type="text" name="properties[]" class="form-control"
                                           placeholder="Enter property">
                                    <button type="button" class="btn btn-success addProperty">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-primary px-4" id="createAssetBtn">
                                Create
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>

        <!-- Edit Asset -->
        <div id="editForm" class="d-none">
            <form id="editAssetForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="editAssetId" name="id">

                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-header bg-warning text-dark text-center">
                        <h5 class="mb-0">Edit Asset</h5>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Asset Name</label>
                            <input type="text" name="asset_name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Asset Image</label>
                            <input type="file" name="image" class="form-control">
                            <div class="mt-2">
                                <img id="editImagePreview" width="100" class="rounded border">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Properties</label>
                            <div id="editPropertyWrapper"></div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-success" id="updateAssetBtn">
                                Update
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="hideEditForm()">
                                Cancel
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .error-text{
        color:#dc3545;
        font-size:13px;
        margin-top:4px;
    }
    .input-error{
        border:1px solid #dc3545 !important;
    }
</style>

<script>

function hideEditForm(){
    $('#editForm').addClass('d-none');
    $('#addForm').removeClass('d-none');
    $('#editAssetForm')[0].reset();
    $('#editPropertyWrapper').html('');
}

$(document).ready(function(){

    $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    const table = $('#assetTable').DataTable({
        processing:true,
        serverSide:true,
        ajax:"{{ route('asset.getData') }}",
        columns:[
            {data:'DT_RowIndex', orderable:false, searchable:false},
            {data:'image', orderable:false, searchable:false},
            {data:'assetType'},
            {data:'description'},
            {data:'properties', orderable:false, searchable:false},
            {data:'action', orderable:false, searchable:false},
        ]
    });

    // Add Property (Add Form)
    $(document).on('click','.addProperty',function(){
        $('#propertyWrapper').append(`
            <div class="input-group mb-2 property-row">
                <input type="text" name="properties[]" class="form-control" placeholder="Enter property">
                <button type="button" class="btn btn-danger removeProperty">Remove</button>
            </div>
        `);
    });

    $(document).on('click','.removeProperty',function(){
        $(this).closest('.property-row').remove();
    });

    // Create Asset - Frontend Validation
    $('#createAssetBtn').click(function(){

        $('.error-text').remove();
        $('.form-control').removeClass('input-error');

        let isValid = true;
        let assetName = $('input[name="asset_name"]').val().trim();
        let image = $('input[name="image"]')[0].files[0];

        // Asset Name
        if(assetName === ''){
            $('input[name="asset_name"]').addClass('input-error').after('<div class="error-text">Asset name is required</div>');
            isValid = false;
        }

        // Image Validation (if selected)
        if(image){
            let allowedTypes = ['image/jpeg','image/png','image/jpg'];
            if(!allowedTypes.includes(image.type)){
                $('input[name="image"]').addClass('input-error').after('<div class="error-text">Only JPG, JPEG, PNG allowed</div>');
                isValid = false;
            }
            if(image.size > 2 * 1024 * 1024){
                $('input[name="image"]').addClass('input-error').after('<div class="error-text">Image must be less than 2MB</div>');
                isValid = false;
            }
        }

        if(!isValid) return;

        let formData = new FormData($('#addAssetForm')[0]);

        $.ajax({
            url:"{{ route('asset.store') }}",
            method:"POST",
            data:formData,
            processData:false,
            contentType:false,
            success:function(){
                $('#addAssetForm')[0].reset();
                $('#propertyWrapper').html(`
                    <div class="input-group mb-2 property-row">
                        <input type="text" name="properties[]" class="form-control" placeholder="Enter property">
                        <button type="button" class="btn btn-success addProperty">+</button>
                    </div>
                `);
                table.ajax.reload();
                toastr.success('Asset Created Successfully');
            },
            error:function(){
                toastr.error('Server validation failed');
            }
        });

    });

    // Edit Click
    $(document).on('click','.edit',function(){

        let id = $(this).data('id');
        let name = $(this).data('asset_name');
        let description = $(this).data('description');
        let image = $(this).data('image');
        let properties = $(this).data('properties') || [];

        $('#addForm').addClass('d-none');
        $('#editForm').removeClass('d-none');

        $('#editAssetId').val(id);
        $('#editAssetForm input[name="asset_name"]').val(name);
        $('#editAssetForm textarea[name="description"]').val(description);
        $('#editImagePreview').attr('src', image);

        $('#editPropertyWrapper').html('');

        // Existing properties
        properties.forEach(function(prop){
            $('#editPropertyWrapper').append(`
                <div class="input-group mb-2 property-row">
                    <input type="text" name="properties[]" class="form-control" value="${prop}">
                    <button type="button" class="btn btn-danger removeProperty">Remove</button>
                </div>
            `);
        });

        // Always add plus row
        $('#editPropertyWrapper').append(`
            <div class="input-group mb-2 property-row">
                <input type="text" name="properties[]" class="form-control" placeholder="Enter property">
                <button type="button" class="btn btn-success addEditProperty">+</button>
            </div>
        `);

    });

    // Add property in Edit form
    $(document).on('click','.addEditProperty',function(){
        $('#editPropertyWrapper').append(`
            <div class="input-group mb-2 property-row">
                <input type="text" name="properties[]" class="form-control" placeholder="Enter property">
                <button type="button" class="btn btn-danger removeProperty">Remove</button>
            </div>
        `);
    });

    // Update Asset - Frontend Validation
    $('#updateAssetBtn').click(function(){

        $('.error-text').remove();
        $('.form-control').removeClass('input-error');

        let isValid = true;
        let assetName = $('#editAssetForm input[name="asset_name"]').val().trim();
        let image = $('#editAssetForm input[name="image"]')[0].files[0];

        if(assetName === ''){
            $('#editAssetForm input[name="asset_name"]').addClass('input-error').after('<div class="error-text">Asset name is required</div>');
            isValid = false;
        }

        if(image){
            let allowedTypes = ['image/jpeg','image/png','image/jpg'];
            if(!allowedTypes.includes(image.type)){
                $('#editAssetForm input[name="image"]').addClass('input-error').after('<div class="error-text">Only JPG, JPEG, PNG allowed</div>');
                isValid = false;
            }
            if(image.size > 2 * 1024 * 1024){
                $('#editAssetForm input[name="image"]').addClass('input-error').after('<div class="error-text">Image must be less than 2MB</div>');
                isValid = false;
            }
        }

        if(!isValid) return;

        let id = $('#editAssetId').val();
        let formData = new FormData($('#editAssetForm')[0]);

        $.ajax({
            url:`/admin/asset/update/${id}`,
            method:"POST",
            data:formData,
            processData:false,
            contentType:false,
            success:function(){
                table.ajax.reload();
                hideEditForm();
                toastr.success('Asset Updated Successfully');
            },
            error:function(){
                toastr.error('Server validation failed');
            }
        });

    });

    // Delete
    $(document).on('click','.delete',function(){

        let id = $(this).data('id');

        Swal.fire({
            title:'Are you sure?',
            icon:'warning',
            showCancelButton:true,
            confirmButtonColor:'#d33',
        }).then((result)=>{

            if(result.isConfirmed){

                $.ajax({
                    url:`/admin/asset/delete/${id}`,
                    method:'POST',
                    success:function(){
                        table.ajax.reload();
                        toastr.success('Asset Deleted Successfully');
                    }
                });

            }

        });

    });

});
</script>

@endpush
