<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusChanged extends Notification
{
    use Queueable;

    public $booking; // Variabel untuk menyimpan data booking

    // Terima data booking saat notifikasi dipanggil
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via(object $notifiable): array
    {
        return ['mail']; // Kirim via Email
    }

    public function toMail(object $notifiable): MailMessage
    {
        // LOGIKA ISI EMAIL BERDASARKAN STATUS
        $status = $this->booking->status;
        $url = url('/my-bookings'); // Link ke halaman riwayat

        if ($status == 'pending') {
            return (new MailMessage)
                ->subject('Pesanan Diterima - Menunggu Pembayaran')
                ->greeting('Halo, ' . $notifiable->name)
                ->line('Terima kasih! Pesanan ruangan Anda telah kami terima.')
                ->line('Detail: ' . $this->booking->service->name)
                ->line('Tanggal: ' . $this->booking->start_date)
                ->line('Silakan segera upload bukti pembayaran agar diproses admin.')
                ->action('Upload Bukti Bayar', $url);
        } 
        elseif ($status == 'confirmed') {
            return (new MailMessage)
                ->subject('Hore! Booking Disetujui ✅')
                ->greeting('Halo, ' . $notifiable->name)
                ->line('Selamat! Bukti pembayaran Anda valid dan booking telah DISETUJUI Admin.')
                ->line('Silakan datang sesuai jadwal yang ditentukan.')
                ->action('Lihat Tiket Saya', $url);
        } 
        else { // Cancelled
            return (new MailMessage)
                ->subject('Mohon Maaf, Booking Ditolak ❌')
                ->greeting('Halo, ' . $notifiable->name)
                ->line('Maaf, pesanan Anda tidak dapat kami proses saat ini.')
                ->line('Silakan hubungi admin untuk informasi lebih lanjut.')
                ->action('Cek Status', $url);
        }
    }
}