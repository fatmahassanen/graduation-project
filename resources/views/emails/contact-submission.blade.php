<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #1a096e;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            color: #1a096e;
        }
        .field-value {
            margin-top: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Form Submission</h2>
        </div>
        
        <div class="content">
            <div class="field">
                <div class="field-label">Name:</div>
                <div class="field-value">{{ $submission->name }}</div>
            </div>

            <div class="field">
                <div class="field-label">Email:</div>
                <div class="field-value">
                    <a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a>
                </div>
            </div>

            @if($submission->phone)
            <div class="field">
                <div class="field-label">Phone:</div>
                <div class="field-value">{{ $submission->phone }}</div>
            </div>
            @endif

            <div class="field">
                <div class="field-label">Subject:</div>
                <div class="field-value">{{ $submission->subject }}</div>
            </div>

            <div class="field">
                <div class="field-label">Message:</div>
                <div class="field-value">{{ $submission->message }}</div>
            </div>

            <div class="field">
                <div class="field-label">Submitted:</div>
                <div class="field-value">{{ $submission->created_at->format('F j, Y g:i A') }}</div>
            </div>

            <div class="field">
                <div class="field-label">IP Address:</div>
                <div class="field-value">{{ $submission->ip_address }}</div>
            </div>
        </div>

        <div class="footer">
            <p>This is an automated message from the New Cairo University of Technology website.</p>
        </div>
    </div>
</body>
</html>
