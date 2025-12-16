<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Statistik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    Selamat Datang, <strong>{{ Auth::user()->name }}</strong>! 
                    Anda login sebagai <span class="badge bg-gray-200 px-2 rounded">{{ ucfirst(Auth::user()->role) }}</span>.
                </div>
            </div>

            @if(Auth::user()->role === 'admin')
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm">Estimasi Pendapatan</div>
                    <div class="text-2xl font-bold text-green-600">
                        Rp {{ number_format($data['income'], 0, ',', '.') }}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-sm">Butuh Konfirmasi</div>
                    <div class="text-2xl font-bold text-yellow-600">
                        {{ $data['pending_bookings'] }} <span class="text-sm font-normal text-gray-400">Pesanan</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm">Reservasi Sukses</div>
                    <div class="text-2xl font-bold text-blue-600">
                        {{ $data['confirmed_bookings'] }} <span class="text-sm font-normal text-gray-400">Pesanan</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-purple-500">
                    <div class="text-gray-500 text-sm">Total Pengguna</div>
                    <div class="text-2xl font-bold text-purple-600">
                        {{ $data['total_users'] }} <span class="text-sm font-normal text-gray-400">Orang</span>
                    </div>
                </div>

            </div>

            <div class="mt-8">
                <a href="{{ route('admin.bookings') }}" class="text-blue-600 hover:underline">
                    &rarr; Kelola Semua Pesanan
                </a>
            </div>

            @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="text-gray-500 text-sm">Total Booking Saya</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $data['my_total'] }}</div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-yellow-400">
                    <div class="text-gray-500 text-sm">Menunggu Konfirmasi</div>
                    <div class="text-3xl font-bold text-yellow-600">{{ $data['my_pending'] }}</div>
                    <p class="text-xs text-gray-400 mt-1">Mohon tunggu admin/upload bukti bayar.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm">Siap Digunakan</div>
                    <div class="text-3xl font-bold text-green-600">{{ $data['my_confirmed'] }}</div>
                </div>

            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('calendar.index') }}" class="block p-4 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition">
                    + Buat Reservasi Baru
                </a>
                <a href="{{ route('booking.index') }}" class="block p-4 bg-gray-200 text-gray-700 text-center rounded-lg hover:bg-gray-300 transition">
                    Lihat Riwayat Saya
                </a>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>