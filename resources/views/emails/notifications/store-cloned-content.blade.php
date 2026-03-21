{{-- resources/views/emails/notifications/store-cloned-content.blade.php --}}
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Store is Ready!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 25px 0;
        }
        .stat-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #4a5568;
        }
        .stat-label {
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 10px 5px;
        }
        .button-success {
            background-color: #10b981;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #718096;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>🎉 Your Store is Ready!</h1>
    <p>Hello {{ $notifiable->name }}!</p>
</div>

<div class="content">
    <p>Great news! Your dropshipping store <strong>{{ $store->store_name }}</strong> has been successfully created.</p>

    <div style="background: #e8f4fd; padding: 15px; border-radius: 8px; margin: 20px 0;">
        <p style="margin: 5px 0;"><strong>Store Name:</strong> {{ $store->store_name }}</p>
        <p style="margin: 5px 0;"><strong>Brand:</strong> {{ $brand->brand_name }}</p>
        <p style="margin: 5px 0;"><strong>Created:</strong> {{ $store->created_at->format('F j, Y') }}</p>
    </div>

    <h2 style="font-size: 18px; margin-top: 30px;">Cloning Summary</h2>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['cloned_products'] ?? 0 }}</div>
            <div class="stat-label">Products Cloned</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['skipped_products'] ?? 0 }}</div>
            <div class="stat-label">Products Skipped</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['failed_products'] ?? 0 }}</div>
            <div class="stat-label">Failed Products</div>
        </div>
    </div>

    @if(($stats['failed_products'] ?? 0) > 0)
        <div style="background: #fffbeb; border-left: 4px solid #f59e0b; padding: 15px; margin: 20px 0;">
            <p style="margin: 0; color: #92400e;">
                <strong>⚠️ Note:</strong> Some products failed to clone. Our team has been notified and will look into this. You can also try manually syncing them from your store dashboard.
            </p>
        </div>
    @endif

    <h2 style="font-size: 18px; margin-top: 30px;">What's Next?</h2>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('dropshipper.store.dashboard', $store) }}" class="button">Go to Store Dashboard</a>
        <a href="{{ route('dropshipper.store.products', $store) }}" class="button button-success">Manage Products</a>
    </div>

    <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">

    <p style="font-size: 14px; color: #4b5563;">
        Need help? Check out our <a href="{{ config('app.url') }}/docs" style="color: #4f46e5;">documentation</a>
        or <a href="{{ config('app.url') }}/support" style="color: #4f46e5;">contact support</a>.
    </p>

    <div class="footer">
        <p>Thanks,<br>{{ config('app.name') }}</p>
        <p>© {{ $year }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
