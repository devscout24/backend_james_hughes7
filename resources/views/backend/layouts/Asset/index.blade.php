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
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white text-white">
                <h5 class="mb-0">Asset List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="assetTable" class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Asset Name</th>
                                <th>Description</th>
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
            <form id="addAssetForm">
                @csrf
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0 text-white">Add New Asset</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Asset Name</label>
                            <input type="text" name="asset_name" class="form-control" placeholder="Enter asset name">
                            <div class="text-danger error-field" id="error-asset_name"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter description"></textarea>
                            <div class="text-danger error-field" id="error-description"></div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-success" id="createAssetBtn">
                                <i class="bi bi-plus-circle"></i> Create
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>

        <!-- Edit Asset -->
        <div id="editForm" class="d-none">
            <form id="editAssetForm">
                @csrf
                <input type="hidden" id="editAssetId" name="id">

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark text-center">
                        <h5 class="mb-0">Edit Asset</h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Asset Name</label>
                            <input type="text" name="asset_name" class="form-control">
                            <div class="text-danger error-field" id="edit-error-asset_name"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                            <div class="text-danger error-field" id="edit-error-description"></div>
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
<script>
function hideEditForm(){
    $('#editForm').addClass('d-none');
    $('#addForm').removeClass('d-none');
    $('#editAssetForm')[0].reset();
    $('.error-field').text('');
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
            {data:'DT_RowIndex', name:'DT_RowIndex', orderable:false, searchable:false},
            {data:'assetType', name:'assetType'},
            {data:'description', name:'description'},
            {data:'action', name:'action', orderable:false, searchable:false},
        ]
    });

    // Create Asset
    $('#createAssetBtn').click(function(){

        let formData = new FormData($('#addAssetForm')[0]);

        $.ajax({
            url:"{{ route('asset.store') }}",
            method:"POST",
            data:formData,
            processData:false,
            contentType:false,
            success:function(response){
                table.ajax.reload();
                $('#addAssetForm')[0].reset();
                toastr.success('Asset Created Successfully');
            },
            error:function(){
                toastr.error('Failed to create asset');
            }
        });

    });

    // Show Edit Form
    $(document).on('click','.edit',function(){

        let id = $(this).data('id');
        let name = $(this).data('asset_name');
        let description = $(this).data('description');

        $('#addForm').addClass('d-none');
        $('#editForm').removeClass('d-none');

        $('#editAssetId').val(id);
        $('#editAssetForm input[name="asset_name"]').val(name);
        $('#editAssetForm textarea[name="description"]').val(description);

    });

    // Update Asset
    $('#updateAssetBtn').click(function(){

        let id = $('#editAssetId').val();
        let formData = new FormData($('#editAssetForm')[0]);

        $.ajax({
            url:`/admin/asset/update/${id}`,
            method:"POST",
            data:formData,
            processData:false,
            contentType:false,
            success:function(response){
                table.ajax.reload();
                hideEditForm();
                toastr.success('Asset Updated Successfully');
            },
            error:function(){
                toastr.error('Failed to update asset');
            }
        });

    });

    // Delete Asset
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
                    success:function(response){
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
