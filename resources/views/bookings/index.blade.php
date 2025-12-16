<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Pesanan Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="p-3 font-bold">Layanan</th>
                            <th class="p-3 font-bold">Tanggal</th>
                            <th class="p-3 font-bold">Status</th>
                            <th class="p-3 font-bold">Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">
                                    <div class="font-bold">{{ $booking->service->name }}</div>
                                    <div class="text-sm text-gray-500">Rp {{ number_format($booking->service->price) }}
                                    </div>
                                </td>
                                <td class="p-3">
                                    {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                    s/d
                                    {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                </td>
                                <td class="p-3">
                                    @php
                                        $warnabg = '#f59e0b'; // Kuning (Pending)
                                        if ($booking->status == 'confirmed')
                                            $warnabg = '#10b981'; // Hijau
                                        if ($booking->status == 'cancelled')
                                            $warnabg = '#ef4444'; // Merah
                                    @endphp

                                    <span
                                        style="background-color: {{ $warnabg }}; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="p-3">
                                    @if($booking->payment_proof)
                                        <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank"
                                            style="color: #2563eb; text-decoration: underline; font-size: 14px;">
                                            Lihat Bukti
                                        </a>
                                    @else
                                        <form action="{{ route('booking.upload', $booking->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')
                                            <input type="file" name="payment_proof" style="font-size: 12px; margin-bottom: 5px;"
                                                required>
                                            <br>
                                            <button type="submit"
                                                style="background-color: #2563eb; color: white; padding: 4px 12px; border-radius: 4px; font-size: 12px; cursor: pointer;">
                                                submit
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($bookings->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Belum ada booking.</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>