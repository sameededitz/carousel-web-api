<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }} | {{ config('app.name') }}</title>
</head>

<body style="font-family: 'Arial', sans-serif; background-color: #f9f9f9; margin: 0; padding: 0;">
    <div class="container"
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding: 20px;">

        <!-- Header -->
        <div class="header" style="background-color: #007bff; color: white; text-align: center; padding: 20px 0;">
            <h1 style="margin: 0; font-size: 24px;">{{ $subject }}</h1>
        </div>

        <!-- Content -->
        <div class="content" style="padding: 20px;">
            <p>Dear, <span style="font-weight: 600">{{ $name ?? 'User' }}</span></p>
            <p>{{ $body }}</p>

            @if ($buttonText && $buttonUrl)
                <p style="text-align: center;">
                    <a href="{{ $buttonUrl }}"
                        style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
                        {{ $buttonText }}
                    </a>
                </p>
            @endif

            <p>Best regards,<br> <strong>{{ config('app.name') }} Team </strong></p>
        </div>

        <!-- Footer -->
        <div class="footer" style="text-align: center; padding: 20px; background-color: #f1f1f1;">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
