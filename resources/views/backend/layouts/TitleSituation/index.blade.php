@extends('backend.master')

@section('title','Title Situation Management')

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4">
        <h3 class="fw-bold">Title Situation Management</h3>
    </div>
</div>

<div class="row">

    <!-- Title Situation List -->
    <div class="col-lg-7 col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Title Situation List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="titleSituationTable" class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Title Situation</th>
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

        <!-- Add -->
        <div id="addForm">
            <form id="addTitleSituationForm">
                @csrf
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0 text-white">Add New Title Situation</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title Situation</label>
                            <input type="text" name="titleSituation" class="form-control" placeholder="Enter title situation">
                            <div class="text-danger" id="error-titleSituation"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter description"></textarea>
                            <div class="text-danger" id="error-description"></div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-success" id="createBtn">
                                Create
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>

        <!-- Edit -->
        <div id="editForm" class="d-none">
            <form id="editTitleSituationForm">
                @csrf
                <input type="hidden" id="editId" name="id">

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark text-center">
                        <h5 class="mb-0">Edit Title Situation</h5>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title Situation</label>
                            <input type="text" name="titleSituation" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-success" id="updateBtn">
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
    $('#editTitleSituationForm')[0].reset();
}

$(document).ready(function(){

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const table = $('#titleSituationTable').DataTable({
        processing:true,
        serverSide:true,
        ajax:"{{ route('titleSituation.getData') }}",
        columns:[
            {data:'DT_RowIndex', name:'DT_RowIndex', orderable:false, searchable:false},
            {data:'titleSituation', name:'titleSituation'},
            {data:'description', name:'description'},
            {data:'action', name:'action', orderable:false, searchable:false},
        ]
    });

    // Create
    $('#createBtn').click(function(){

        let formData = new FormData($('#addTitleSituationForm')[0]);

        $.ajax({
            url:"{{ route('titleSituation.store') }}",
            method:"POST",
            data:formData,
            processData:false,
            contentType:false,
            success:function(){
                table.ajax.reload();
                $('#addTitleSituationForm')[0].reset();
                toastr.success('Created Successfully');
            }
        });
    });

    // Show Edit
    $(document).on('click','.edit',function(){

        $('#addForm').addClass('d-none');
        $('#editForm').removeClass('d-none');

        $('#editId').val($(this).data('id'));
        $('#editTitleSituationForm input[name="titleSituation"]').val($(this).data('titlesituation'));
        $('#editTitleSituationForm textarea[name="description"]').val($(this).data('description'));
    });

    // Update
    $('#updateBtn').click(function(){

        let id = $('#editId').val();
        let formData = new FormData($('#editTitleSituationForm')[0]);

        $.ajax({
            url:`/admin/title-situation/update/${id}`,
            method:"POST",
            data:formData,
            processData:false,
            contentType:false,
            success:function(){
                table.ajax.reload();
                hideEditForm();
                toastr.success('Updated Successfully');
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
                    url:`/admin/title-situation/delete/${id}`,
                    method:'POST',
                    success:function(){
                        table.ajax.reload();
                        toastr.success('Deleted Successfully');
                    }
                });

            }

        });

    });

});
</script>
@endpush
