<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Movie Ticket - {{ $cinemaName }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: #fff;
        }
        
        .ticket {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #007bff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 15px 20px;
            text-align: center;
            position: relative;
        }
        
        .logo {
            max-width: 80px;
            max-height: 50px;
            margin-bottom: 8px;
        }
        
        .cinema-name {
            font-size: 24px;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .ticket-title {
            font-size: 16px;
            margin: 5px 0;
            opacity: 0.9;
        }
        
        .content {
            padding: 20px;
        }
        
        .main-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        
        .movie-info, .booking-info {
            flex: 1;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-bottom: 2px solid #007bff;
            padding-bottom: 3px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            align-items: center;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
            font-size: 11px;
            min-width: 80px;
        }
        
        .info-value {
            color: #333;
            font-size: 11px;
            text-align: right;
            flex: 1;
        }
        
        .seats-section {
            margin-bottom: 20px;
        }
        
        .seats-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }
        
        .seats-table th {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: center;
            font-weight: bold;
            color: #007bff;
        }
        
        .seats-table td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: center;
        }
        
        .vip-badge {
            background-color: #ffc107;
            color: #000;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .regular-badge {
            background-color: #17a2b8;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .total-section {
            background-color: #f8f9fa;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }
        
        .total-label {
            font-weight: bold;
            color: #555;
            font-size: 12px;
        }
        
        .total-amount {
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
        }
        
        .footer {
            background-color: #f8f9fa;
            padding: 15px 20px;
            text-align: center;
            border-top: 1px solid #ddd;
        }
        
        .footer p {
            margin: 3px 0;
            font-size: 10px;
            color: #666;
        }
        
        .qr-section {
            text-align: center;
            margin: 15px 0;
        }
        
        .qr-placeholder {
            width: 60px;
            height: 60px;
            background-color: #eee;
            border: 2px dashed #ccc;
            display: inline-block;
            margin: 0 auto;
            font-size: 8px;
            color: #999;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            line-height: 1.2;
        }
        
        .status-badge {
            background-color: #28a745;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .payment-id {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <!-- Header -->
        <div class="header">
            @if(file_exists($cinemaLogo))
                <img src="{{ $cinemaLogo }}" alt="{{ $cinemaName }}" class="logo">
            @endif
            <div class="cinema-name">{{ $cinemaName }}</div>
            <div class="ticket-title">MOVIE TICKET</div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Main Information -->
            <div class="main-info">
                <div class="movie-info">
                    <div class="section-title">Movie Details</div>
                    <div class="info-row">
                        <span class="info-label">Movie:</span>
                        <span class="info-value">{{ $booking->movieShow->movie->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Date:</span>
                        <span class="info-value">{{ $booking->movieShow->show_time->format('D, M d, Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Time:</span>
                        <span class="info-value">{{ $booking->movieShow->show_time->format('h:i A') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Theater:</span>
                        <span class="info-value">{{ $booking->movieShow->theater->location }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Screen:</span>
                        <span class="info-value">{{ $booking->movieShow->screen->screen_name }}</span>
                    </div>
                </div>
                
                <div class="booking-info">
                    <div class="section-title">Booking Details</div>
                    <div class="info-row">
                        <span class="info-label">Booking ID:</span>
                        <span class="info-value">#{{ $booking->id }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Payment ID:</span>
                        <span class="info-value payment-id">{{ $booking->payment_id }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status:</span>
                        <span class="info-value">
                            <span class="status-badge">{{ ucfirst($booking->status) }}</span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Booked:</span>
                        <span class="info-value">{{ $booking->booking_date->format('M d, Y h:i A') }}</span>
                    </div>
                </div>
            </div>

            <!-- Seats Information -->
            <div class="seats-section">
                <div class="section-title">Seats Information</div>
                <table class="seats-table">
                    <thead>
                        <tr>
                            <th>Seat</th>
                            <th>Type</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($booking->tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->seat->row }}{{ $ticket->seat->number }}</td>
                            <td>
                                <span class="{{ $ticket->seat->type === 'vip' ? 'vip-badge' : 'regular-badge' }}">
                                    {{ strtoupper($ticket->seat->type) }}
                                </span>
                            </td>
                            <td>${{ number_format($ticket->price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Total and QR -->
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div class="total-section" style="flex: 1; margin-right: 20px;">
                    <div class="total-row">
                        <span class="total-label">Number of Tickets:</span>
                        <span>{{ $booking->number_of_tickets }}</span>
                    </div>
                    <div class="total-row">
                        <span class="total-label">Total Amount:</span>
                        <span class="total-amount">${{ number_format($booking->total_price, 2) }}</span>
                    </div>
                </div>
                
                <div class="qr-section">
                    <div class="qr-placeholder">
                        QR Code<br>
                        #{{ $booking->id }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Thank you for choosing {{ $cinemaName }}!</strong></p>
            <p>Please arrive 15 minutes before the show time</p>
            <p>This ticket is valid for one-time use only</p>
            <p>For support, contact us at support@goldencinema.com</p>
        </div>
    </div>
</body>
</html> 