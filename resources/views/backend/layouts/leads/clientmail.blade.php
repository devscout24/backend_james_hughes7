{{-- resources/views/emails/client_mail.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $data['subject'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f6fa;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .header {
            background-color: #0d6efd;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .body {
            padding: 25px;
            color: #333;
        }
        .body h3 {
            margin-top: 0;
        }
        .body p {
            line-height: 1.6;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .info-table th,
        .info-table td {
            text-align: left;
            padding: 8px 12px;
            border: 1px solid #ddd;
        }
        .footer {
            background-color: #f1f3f6;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .btn-primary {
            display: inline-block;
            background-color: #0d6efd;
            color: #fff;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 5px;
            margin-top: 15px;
        }
        @media (max-width: 600px){
            .email-container {
                width: 100% !important;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">

        @php
            $settings=App\Models\AdminSetting::first();
        @endphp
        <!-- Header -->
        <div class="header">
            <h2>{{ $settings->title ?? 'Default Title' }}</h2>
        </div>

        <!-- Body -->
        <div class="body">
            <h3>Hello {{ $data['lead']->fullName }},</h3>

            <p>{!! nl2br(e($data['message'])) !!}</p>

            <!-- Lead Info Table -->
            <table class="info-table">
                <tr>
                    <th>Full Name</th>
                    <td>{{ $data['lead']->fullName }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $data['lead']->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $data['lead']->phone }}</td>
                </tr>
                <tr>
                    <th>Asset</th>
                    <td>{{ $data['lead']->asset->assetType ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Condition</th>
                    <td>{{ $data['lead']->condition->condition ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Year</th>
                    <td>{{ $data['lead']->year ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Make / Model</th>
                    <td>{{ $data['lead']->make ?? 'N/A' }} / {{ $data['lead']->model ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Mileage</th>
                    <td>{{ $data['lead']->mileage ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>VIN</th>
                    <td>{{ $data['lead']->vin ?? 'N/A' }}</td>
                </tr>
            </table>

            <a href="{{ url('/') }}" class="btn-primary">Visit Our Website</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} Your Company. All rights reserved.
        </div>
    </div>
</body>
</html>
