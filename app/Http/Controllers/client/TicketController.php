<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    public function downloadTicket(\App\Models\Ticket $ticket)
    {
        $booking = $ticket->booking;
        if (!$booking || $booking->client_id !== Auth::guard('client')->id()) {
            abort(403, 'Unauthorized access to this booking.');
        }

        $booking->load(['movieShow.movie', 'movieShow.theater', 'movieShow.screen', 'tickets.seat']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('client.tickets.pdf', [
            'booking' => $booking,
            'ticket' => $ticket,
            'cinemaName' => 'GOLDEN CINEMA',
            'cinemaLogo' => public_path('img/Logo.PNG'),
        ]);

        $pdf->setPaper('A4', 'portrait');
        $filename = 'Ticket_' . $ticket->id . '_' . $booking->movieShow->movie->name . '.pdf';

        return $pdf->download($filename);
    }
} 