@extends('backend.master')

@section('title','Send Email to Client')

@section('content')
<div class="container-fluid">

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h3 class="fw-bold">Send Email to Client</h3>
            <a href="{{ route('lead.manage.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form id="sendEmailForm" method="POST" enctype="multipart/form-data" action="{{ route('lead.client.send.email',$lead->id) }}">
                        @csrf

                        <!-- Client Info -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">To</label>
                            <input type="email" class="form-control" value="{{ $lead->email }}" readonly>
                        </div>

                        <!-- Subject -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="Enter email subject">
                        </div>

                        <!-- Message -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Message</label>
                            <textarea name="message" class="form-control" rows="6" placeholder="Write your message here..."></textarea>
                        </div>

                        <!-- Attachment -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Attachment (Optional)</label>
                            <input type="file" name="attachment" class="form-control">
                        </div>

                        <!-- Buttons -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-envelope-fill"></i> Send Email
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(document).ready(function(){

    $('#sendEmailForm').on('submit', function(e){
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData:false,
            contentType:false,
            success: function(response){
                toastr.success('Email sent successfully!');
                $('#sendEmailForm')[0].reset();
            },
            error: function(xhr){
                toastr.error('Failed to send email!');
            }
        });

    });

});
</script>
@endpush
