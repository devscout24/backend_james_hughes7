@extends('backend.master')

@section('title','Condition Management')

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4">
        <h3 class="fw-bold">Condition Management</h3>
    </div>
</div>

<div class="row">

    <!-- Condition List -->
    <div class="col-lg-7 col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Condition List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="conditionTable" class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Condition</th>
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

        <!-- Add Condition -->
        <div id="addForm">
            <form id="addConditionForm">
                @csrf
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0 text-white">Add New Condition</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Condition</label>
                            <input type="text" name="condition" class="form-control" placeholder="Enter condition name">
                            <div class="text-danger error-field" id="error-condition"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="describtion" class="form-control" rows="3" placeholder="Enter description"></textarea>
                            <div class="text-danger error-field" id="error-describtion"></div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-success" id="createConditionBtn">
                                Create
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>

        <!-- Edit Condition -->
        <div id="editForm" class="d-none">
            <form id="editConditionForm">
                @csrf
                <input type="hidden" id="editConditionId" name="id">

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark text-center">
                        <h5 class="mb-0">Edit Condition</h5>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Condition</label>
                            <input type="text" name="condition" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="describtion" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-success" id="updateConditionBtn">
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
    $('#editConditionForm')[0].reset();
}

$(document).ready(function(){

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

    const table = $('#conditionTable').DataTable({
        processing:true,
        serverSide:true,
        ajax:"{{route('getData.Condition')}}",
        columns:[
            {data:'DT_RowIndex', name:'DT_RowIndex', orderable:false, searchable:false},
            {data:'condition', name:'condition'},
            {data:'describtion', name:'describtion'},
            {data:'action', name:'action', orderable:false, searchable:false},
        ]
    });

    // Create
    $('#createConditionBtn').click(function(){

        let formData = new FormData($('#addConditionForm')[0]);

        $.ajax({
            url:"{{ route('condition.store') }}",
            method:"POST",
            data:formData,
            processData:false,
            contentType:false,
            success:function(){
                table.ajax.reload();
                $('#addConditionForm')[0].reset();
                toastr.success('Condition Created Successfully');
            }
        });
    });

    // Edit show
    $(document).on('click','.edit',function(){

        $('#addForm').addClass('d-none');
        $('#editForm').removeClass('d-none');

        $('#editConditionId').val($(this).data('id'));
        $('#editConditionForm input[name="condition"]').val($(this).data('condition'));
        $('#editConditionForm textarea[name="describtion"]').val($(this).data('describtion'));
    });

    // Update
    $('#updateConditionBtn').click(function(){

        let id = $('#editConditionId').val();
        let formData = new FormData($('#editConditionForm')[0]);

        $.ajax({
            url:`/admin/condition/update/${id}`,
            method:"POST",
            data:formData,
            processData:false,
            contentType:false,
            success:function(){
                table.ajax.reload();
                hideEditForm();
                toastr.success('Condition Updated Successfully');
            }
        });
    });

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
                    url:`/admin/condition/delete/${id}`,
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
