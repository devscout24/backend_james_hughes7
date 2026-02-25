@extends('backend.master')
<style>
    .card-custom {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 8px rgb(0 0 0 / 0.05);
        transition: box-shadow 0.3s ease;
    }

    .card-custom:hover {
        box-shadow: 0 8px 20px rgb(0 0 0 / 0.12);
    }

    #digitalClock {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: #2563eb;
        /* blue-600 */
        user-select: none;
        min-width: 100px;
        text-align: center;
    }

    .welcome-text {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-weight: 600;
        color: #475569;
        /* slate-600 */
        margin-bottom: 0;
    }

    .icon-circle {
        width: 56px;
        height: 56px;
        background: #e0e7ff;
        /* light indigo */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 0 0 6px #c7d2fe;
    }

    .username {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-weight: 600;
        font-size: 1.1rem;
        color: #1e293b;
        /* slate-900 */
        margin-left: 16px;
    }
</style>

@section('content')
    <div class="container-fluid">

        <div class="row  ">

            <div class="col-xl-6 col-lg-6 mb-5">
                <div class="card h-100 rounded-3 shadow-sm card-custom">
                    <div class="card-body p-4 d-flex flex-column align-items-center">

                        <!-- Top row: Clock and Welcome message -->
                        <div class="d-flex justify-content-center align-items-center gap-3 mb-4 w-100">
                            <!-- Digital Clock -->
                            <div id="digitalClock">--:--:--</div>

                            <!-- Welcome Text -->
                            <h5 class="welcome-text">Welcome To Dashboard</h5>
                        </div>

                        <!-- Bottom row: Icon and Username -->
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"
                                    stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-smile">
                                    <circle cx="14" cy="14" r="13"></circle>
                                    <path d="M9 20s3.5 3.5 10.5 0"></path>
                                    <line x1="10" y1="13" x2="10.01" y2="13"></line>
                                    <line x1="18" y1="13" x2="18.01" y2="13"></line>
                                </svg>
                            </div>

                            <span class="username">{{ Auth::user()->name }}</span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 mb-5">
                <div class="card h-100 card-lift">
                    <div class="card-body">
                        <!-- Title and Icon -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fw-semi-bold">Total Lead</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-shopping-bag text-primary">
                                    <path d="M6 2l1.5 4h9L18 2"></path>
                                    <path d="M3 6h18v14H3z"></path>
                                </svg>
                            </span>
                        </div>

                        <span class="username">{{ $totalleads??0 }}</span>
                    </div>
                </div>
            </div>



        </div>


<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Latest 5 Leads</h5>

                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Asset</th>
                            <th>Condition</th>
                            <th>Title/Situation</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leads as $key => $lead)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $lead->fullName ?? 'N/A' }}</td>
                                <td>{{ $lead->asset->assetType ?? 'N/A' }}</td>
                                <td>{{ $lead->condition->condition ?? 'N/A' }}</td>
                                <td>{{ $lead->title->titleSituation ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        $statusClass = match($lead->status) {
                                            'new' => 'bg-primary',
                                            'in_progress' => 'bg-warning',
                                            'completed' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                        @if($leads->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">No Leads Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>






    </div>
@endsection

