<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - TrendEra</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&display=swap');

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            line-height: 1.6;
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

        .status-section {
            text-align: center;
            padding: 40px 20px 25px;
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            background: #f1c40f;
            border-radius: 50%;
            margin: 0 auto 20px auto;
            display: table;
            box-shadow: 0 8px 15px rgba(241, 196, 15, 0.2);
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

        .content {
            padding: 40px 50px 60px;
            text-align: center;
        }

        .greeting {
            font-size: 26px;
            font-weight: 700;
            color: #2d3436;
            margin-bottom: 15px;
        }

        .message-text {
            color: #636e72;
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .summary-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 25px;
            border: 1px solid #edf2f7;
            text-align: left;
            margin-top: 30px;
        }

        .summary-title {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #718096;
            margin-bottom: 12px;
            display: block;
        }

        .subject-line {
            font-size: 16px;
            font-weight: 700;
            color: #2d3748;
        }

        .footer {
            padding: 40px;
            text-align: center;
            background-color: #fcfcfc;
            border-top: 1px solid #f1f5f9;
        }

        .footer p {
            font-size: 12px;
            color: #95a5a6;
            margin: 5px 0;
        }

        .social-links {
            margin-top: 20px;
        }

        .social-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #d1d5db;
            border-radius: 50%;
            margin: 0 5px;
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
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                </div>
                <h1 class="status-title">Message Received!</h1>
            </div>

            <div class="content">
                <div class="greeting">Hi {{ $data['name'] }},</div>
                <div class="message-text">
                    Thank you for reaching out to us. We have successfully received your inquiry and our team is already reviewing it.
                    Someone will get back to you shortly at <strong>{{ $data['email'] }}</strong>.
                </div>

                <div class="summary-card">
                    <span class="summary-title">Inquiry Subject</span>
                    <div class="subject-line">"{{ $data['subject'] }}"</div>
                </div>

                <p style="margin-top: 40px; color: #a0aec0; font-size: 14px; font-weight: 600;">
                    Have a wonderful day!
                </p>
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} TrendEra Collection. All rights reserved.</p>
                <div class="social-links">
                    <div class="social-dot"></div>
                    <div class="social-dot"></div>
                    <div class="social-dot"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>