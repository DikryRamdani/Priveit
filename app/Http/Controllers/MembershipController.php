<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memberships;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MembershipController extends Controller
{
    public function createPayment(Request $request)
    {
        $userId = auth()->id(); // Dapatkan ID pengguna yang sedang login

        // Langkah 1: Periksa langganan aktif yang sudah ada
        $activeMembership = Memberships::where('user_id', $userId)
            ->where('status', 'settlement') 
            ->where('expired_date', '>', now()) 
            ->first();

        if ($activeMembership) {
            // Jika pengguna sudah memiliki langganan aktif
            return response()->json([
                'error' => 'Anda sudah memiliki langganan yang aktif.',
                'message' => 'Langganan Anda saat ini (' . $activeMembership->kelas . ') masih aktif hingga ' . Carbon::parse($activeMembership->expired_date)->format('d F Y') . '.'
            ], 403); 
        }

        $membershipType = $request->membershipType;
        $price = 0; 
        $durations = 0; 

        $membershipType = $request->membershipType;
        switch ($membershipType) {
            case 'Reguler':
                $price = 1286000;
                $durations = 90;
                break;
            case 'Premium':
                $price = 3418000;
                $durations = 180;
                break;
            case 'Elite':
                $price = 6320000;
                $durations = 365;
                break;
            default:
                return response()->json(['error' => 'Invalid membership'], 400);
        }

        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$clientKey = config('services.midtrans.clientKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction', false);

        $order_id = 'ORDER-' . uniqid();

        $transactionDetails = [
            'order_id' => $order_id,
            'gross_amount' => $price,
        ];

        $transaction = [
            'transaction_details' => $transactionDetails,
            'customer_details' => [
                'first_name' => auth()->user()->username,
                'email' => auth()->user()->email,
            ],
        ];

        $membership = new Memberships();
        $membership->user_id = auth()->id();
        $membership->order_id = $order_id;
        $membership->username = auth()->user()->username;
        $membership->kelas = $membershipType;
        $membership->total_durations = $durations;
        $membership->status = 'pending';
        $membership->save();

        Log::info('Payment request data:', $request->all());
        Log::info('User:', [auth()->user()]);

        $snapToken = Snap::getSnapToken($transaction);

        return response()->json(['token' => $snapToken]);
    }

    public function handleNotification(Request $request)
    {
        Log::info('--- MIDTRANS CALLBACK START ---'); // Tandai awal log
        \Illuminate\Support\Facades\Log::info('Request Data:', $request->all());
        // return response()->json(['message' => 'Callback diterima dengan wildcard!']);

        // Pastikan konfigurasi Midtrans diatur untuk validasi notifikasi
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction', false); // Setel ke true untuk produksi
       
        try {
            // Buat instance objek notifikasi dari input POST
            $notif = new \Midtrans\Notification(); // new Notification($request->getContent())

            Log::info('Parsed notification object:', (array) $notif); //

            $transactionStatus = $notif->transaction_status;
            $orderId = $notif->order_id;
            $fraudStatus = $notif->fraud_status; // Biasanya 'accept', 'challenge', atau 'deny'

            $membership = Memberships::where('order_id', $orderId)->first(); //

            if (!$membership) {
                Log::warning('Membership not found for order_id: ' . $orderId); //
                return response()->json(['message' => 'Membership tidak ditemukan.'], 404);
            }

            Log::info("Processing Order ID: {$orderId}, Transaction Status: {$transactionStatus}, Fraud Status: {$fraudStatus}");

            // Tangani status transaksi yang berbeda
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    // Pembayaran di-capture dan status fraud adalah accept
                    $membership->status = 'settlement'; // Atau 'success'
                    if (!$membership->start_date) { 
                        $membership->start_date = now(); 
                        $membership->expired_date = now()->addDays($membership->total_durations); 
                    }
                }
            } else if ($transactionStatus == 'settlement') {
                // Pembayaran telah diselesaikan
                $membership->status = 'settlement'; 
                if (!$membership->start_date) { 
                    $membership->start_date = now(); 
                    $membership->expired_date = now()->addDays($membership->total_durations); 
                }
            } else if ($transactionStatus == 'pending') {
                $membership->status = 'pending'; //
            } else if ($transactionStatus == 'deny') {
                $membership->status = 'denied';
            } else if ($transactionStatus == 'expire') {
                $membership->status = 'expired';
            } else if ($transactionStatus == 'cancel') {
                $membership->status = 'cancelled';
            }
            
            $membership->save(); //
            Log::info('Membership updated for order_id: ' . $orderId . ' to status: ' . $membership->status);

            return response()->json(['message' => 'Notifikasi diterima dan diproses.']); //

        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Error memproses notifikasi.'], 500);
        }
    }


    public function showMembership()
    {
        $userId = auth()->id();

        $currentActiveMembership = Memberships::where('user_id', $userId)
            ->where('status', 'settlement') 
            ->where('expired_date', '>', now())
            ->latest('start_date') 
            ->first();

        $daysLeft = null;
        if ($currentActiveMembership && $currentActiveMembership->expired_date) {
            $now = Carbon::now();
            $expiredDate = Carbon::parse($currentActiveMembership->expired_date);
            $daysLeftFloat = $now->diffInDays($expiredDate, false);
            if ($daysLeftFloat < 0) {
                $daysLeft = 0;
            } else {
                $daysLeft = (int) floor($daysLeftFloat);
            }
        } else {
            $daysLeft = 0;
        }

        $membershipHistory = Memberships::where('user_id', $userId)
            ->whereIn('status', ['settlement', 'expired', 'cancelled', 'denied']) 
            // ->where('status', 'settlement')
            ->orderBy('created_at', 'desc') 
            ->take(5) 
            ->get();

        return view('dashboardUser', [
            'membership' => $currentActiveMembership, 
            'daysLeft' => $daysLeft,                  
            'recentOrders' => $membershipHistory,     
        ]);
    }
}
