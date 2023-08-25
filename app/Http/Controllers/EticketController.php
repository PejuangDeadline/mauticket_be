<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionHeader;
use PDF;

use Illuminate\Http\Request;

class EticketController extends Controller
{
    public function index($id){
        $id = decrypt($id);
        $id = 4;

        $eventInfo = TransactionHeader::select(
            'transaction_headers.id AS transaction_header_id',
            'transaction_headers.id_user',
            'transaction_headers.no_transaction',
            'transaction_headers.qty',
            'transaction_headers.grand_total',
            'transaction_details.id AS transaction_detail_id',
            'transaction_details.id_ticket_category',
            'transaction_details.id_event',
            'transaction_details.price',
            'transaction_details.no_seat',
            'transaction_details.no_ticket',
            'showtimes.showtime_start',
            'showtimes.showtime_finish',
            'events.event_name',
            'events.exchange_ticket_info',
            'events.tc_info',
            'events.including_info',
            'events.excluding_info',
            'events.facility',
            'ticket_categories.category AS ticket_category',
            'users.email',
            'users.phonenumber',
            'users.firstname',
            'users.lastname'
        )
        ->join('transaction_details', 'transaction_headers.id', '=', 'transaction_details.transaction_header_id')
        ->join('showtimes', 'transaction_details.id_showtime', '=', 'showtimes.id')
        ->join('events', 'transaction_details.id_event', '=', 'events.id')
        ->join('ticket_categories', 'transaction_details.id_ticket_category', '=', 'ticket_categories.id')
        ->join('users', 'transaction_headers.id_user', '=', 'users.id')
        ->where('transaction_headers.id', $id)
        ->first();

        $pdf = PDF::loadView('pdf.eticket', ['eventInfo' => $eventInfo]);

        $fileName = 'transaction_details.pdf';

        return $pdf->download($fileName);


    }
}
