@extends('backend.master')

@section('title','Lead Management')

@section('content')

<div class="row mb-4">
    <div class="col-lg-12">
        <h3 class="fw-bold">Lead Management</h3>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white text-dark">
        <h5 class="mb-0">Lead List</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="leadTable" class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Asset</th>
                        <th>Condition</th>
                        <th>Year</th>
                        <th>Status</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){

$.ajaxSetup({
headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

const table = $('#leadTable').DataTable({
processing:true,
serverSide:true,
ajax:"{{ route('lead.manage.getdata') }}",
columns:[
{data:'DT_RowIndex',orderable:false,searchable:false},
{data:'fullName'},
{data:'phone'},
{data:'email'},
{data:'asset_name'},
{data:'condition_name'},
{data:'year'},
{data:'status'},
{data:'action',orderable:false,searchable:false},
]
});





// Status Change
$(document).on('change','.change-status',function(){

let id = $(this).data('id');
let status = $(this).val();

$.ajax({
    url:`/admin/leads/change-status/${id}`,
    method:'POST',
    data:{ status:status },
    success:function(){
        toastr.success('Status Updated Successfully');
    }
});

});





$(document).on('click','.delete',function(){

let id = $(this).data('id');

Swal.fire({
title:'Delete this lead?',
icon:'warning',
showCancelButton:true,
confirmButtonColor:'#d33',
}).then((result)=>{

if(result.isConfirmed){

$.post(`/admin/leads/delete/${id}`,function(){
table.ajax.reload();
toastr.success('Lead Deleted Successfully');
});

}
});

});

});
</script>
@endpush
