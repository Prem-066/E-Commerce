<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message - TrendEra</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&display=swap');

        body {
            font-family: 'Outfit', sans-serif;
            line-height: 1.6;
            color: #2D3436;
            margin: 0;
            padding: 0;
            background-color: #f7f9fc;
        }

        .wrapper {
            width: 100%;
            padding: 30px 0;
            background-color: #f7f9fc;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        /* Header - Premium Theme */
        .header {
            background-color: #262626;
            padding: 50px 40px;
            text-align: center;
        }

        .logo-img {
            max-width: 150px;
            height: auto;
            margin: 0 auto;
            display: block;
        }

        .logo-text {
            color: #ffffff;
            font-size: 28px;
            font-weight: 900;
            letter-spacing: 6px;
            text-transform: uppercase;
        }

        /* Status Section */
        .status-section {
            text-align: center;
            padding: 40px 20px 25px;
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            background: #3498db;
            border-radius: 50%;
            margin: 0 auto 20px auto;
            display: table;
            box-shadow: 0 8px 15px rgba(52, 152, 219, 0.2);
        }

        .icon-inner {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .status-title {
            font-size: 24px;
            font-weight: 800;
            color: #1a1a1a;
            margin: 0;
            letter-spacing: -0.5px;
        }

        /* Content Area */
        .content {
            padding: 40px 50px 60px;
        }

        .greeting {
            font-size: 24px;
            font-weight: 700;
            color: #2d3436;
            margin-bottom: 12px;
            text-align: center;
        }

        .intro {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 40px;
            text-align: center;
        }

        /* Info Grid - Modern 2 Column */
        .info-grid {
            display: table;
            width: 100%;
            background: #f8fafc;
            border-radius: 20px;
            margin-bottom: 40px;
            border: 1px solid #edf2f7;
            padding: 20px 0;
        }

        .info-item {
            display: table-cell;
            text-align: center;
            width: 50%;
            vertical-align: middle;
        }

        .info-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #718096;
            font-weight: 700;
            letter-spacing: 1.2px;
            margin-bottom: 6px;
        }

        .info-value {
            font-size: 15px;
            color: #1a202c;
            font-weight: 800;
        }

        .v-divider {
            border-left: 1px solid #e2e8f0;
        }

        /* Message Card */
        .message-card {
            padding: 30px;
            border-radius: 20px;
            background-color: #fcfcfc;
            border: 1px solid #f1f2f6;
            margin-top: 20px;
        }

        .message-title {
            font-size: 12px;
            font-weight: 800;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 15px;
            display: block;
        }

        .subject-line {
            font-size: 18px;
            font-weight: 800;
            color: #2d3436;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        .message-body {
            font-size: 15px;
            color: #4a5568;
            line-height: 1.8;
            white-space: pre-line;
            padding-top: 15px;
            border-top: 1px dashed #e2e8f0;
        }

        /* Footer */
        .footer {
            padding: 50px 40px;
            text-align: center;
            background-color: #f8f9fa;
            border-top: 1px solid #f1f5f9;
        }

        .footer p {
            font-size: 12px;
            color: #95a5a6;
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                @if($logo && file_exists(storage_path('app/public/' . $logo)))
                <img src="{{ $message->embed(storage_path('app/public/' . $logo)) }}" alt="Store Logo" class="logo-img">
                @else
                <div class="logo-text">TRENDERA</div>
                @endif
            </div>

            <div class="status-section">
                <div class="icon-circle">
                    <div class="icon-inner">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                </div>
                <h1 class="status-title">New Support Inquiry</h1>
            </div>

            <div class="content">
                <div class="greeting">Hello Admin,</div>
                <p class="intro">You have received a new message from the contact form. Here are the details:</p>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Sender Name</div>
                        <div class="info-value">{{ $data['name'] }}</div>
                    </div>
                    <div class="info-item v-divider">
                        <div class="info-label">Sender Email</div>
                        <div class="info-value">{{ $data['email'] }}</div>
                    </div>
                </div>

                <div class="message-card">
                    <span class="message-title">Inquiry Subject</span>
                    <div class="subject-line">{{ $data['subject'] }}</div>
                    <div class="message-body">
                        {{ $data['message'] }}
                    </div>
                </div>
            </div>

            <div class="footer">
                <p>This is an automated notification from your website's contact form.</p>
                <p style="opacity: 0.8; margin-top: 15px;">&copy; {{ date('Y') }} TrendEra Collection. All rights reserved.</p>
                <p style="opacity: 0.8;">123 Fashion Hub, Gujarat, India</p>
            </div>
        </div>
    </div>
</body>

</html>