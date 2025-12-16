<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Jadwal Reservasi
            </h2>

            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'booking-modal')"
                style="background-color: #2563eb; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; border: none; cursor: pointer;"
                class="hover:bg-blue-700 shadow-lg transition ease-in-out duration-150">
                + Buat Booking Baru
            </button>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div id='calendar'></div>

            </div>
        </div>
    </div>

    <x-modal name="booking-modal" :show="$errors->any()" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Form Reservasi Baru
            </h2>

            <form action="{{ route('booking.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Layanan</label>
                    <select name="service_id"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @foreach(\App\Models\Service::all() as $service)
                            <option value="{{ $service->id }}">
                                {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" name="end_date"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">

                    <button type="button" x-on:click="$dispatch('close')"
                        style="background-color: #e5e7eb; color: #374151; padding: 8px 16px; border-radius: 6px;"
                        class="hover:bg-gray-300">
                        Batal
                    </button>

                    <button type="submit"
                        style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 6px;"
                        class="hover:bg-blue-700">
                        Simpan Booking
                    </button>

                </div>
            </form>
        </div>
    </x-modal>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                events: @json($events),
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listMonth'
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    list: 'List'
                }
            });
            calendar.render();
        });
    </script>
</x-app-layout>