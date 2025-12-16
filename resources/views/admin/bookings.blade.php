<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin - Kelola Pesanan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div style="background-color: #d1fae5; color: #065f46; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr style="background-color: #f3f4f6; border-bottom: 2px solid #e5e7eb;">
                            <th class="p-3">Pemesan</th>
                            <th class="p-3">Layanan</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Bukti Bayar</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 font-medium">{{ $booking->user->name }}</td>
                            
                            <td class="p-3">
                                {{ $booking->service->name }}
                                <div class="text-xs text-gray-500">Rp {{ number_format($booking->service->price) }}</div>
                            </td>
                            
                            <td class="p-3 text-sm">
                                {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }} <br>
                                s/d <br>
                                {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}
                            </td>

                            <td class="p-3">
                                @if($booking->payment_proof)
                                    <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank" 
                                       style="color: #2563eb; text-decoration: underline; font-size: 14px;">
                                       Lihat Foto
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs text-center block">- Belum Upload -</span>
                                @endif
                            </td>

                            <td class="p-3">
                                @php
                                    $bg = '#f59e0b'; // Kuning
                                    if($booking->status == 'confirmed') $bg = '#10b981'; // Hijau
                                    if($booking->status == 'cancelled') $bg = '#ef4444'; // Merah
                                @endphp
                                <span style="background-color: {{ $bg }}; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>

                            <td class="p-3">
                                @if($booking->status == 'pending')
                                    <div class="flex gap-2">
                                        <form action="{{ route('admin.approve', $booking->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" style="background-color: #10b981; color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; cursor: pointer;">
                                                ✓ Terima
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.reject', $booking->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" style="background-color: #ef4444; color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; cursor: pointer;">
                                                ✕ Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>