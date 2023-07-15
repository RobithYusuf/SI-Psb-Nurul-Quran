<x-filament::page :title="'Pengumuman Seleksi'">
    <!-- <h1 class="text-center text-2xl font-bold text-blue-600 mb-4">PENGUMUMAN KELULUSAN</h1> -->
    @if (is_iterable($seleksi))
        @foreach($seleksi as $result)
        <div class="my-4 p-4 bg-white rounded shadow-lg">
            <h1 class="text-center text-2xl font-bold text-blue-600 mb-4">PENGUMUMAN KELULUSAN</h1>
            <p class="text-gray-700 mb-2">
                Kepada:<h2 class="text-xl font-bold text-blue-600 mb-2">{{ optional($result->user)->name }}</h2>
                @if(empty($result->seleksi))
                    <h2 class="text-xl font-bold text-blue-600 mb-2">Pengumuman kelulusan di umumkan di sini, silahkan akses web secara berkala!</h2>
                @elseif(now() < \Carbon\Carbon::parse($result->seleksi->tanggal_pengumuman))
                    <h2 class="text-xl font-bold text-blue-600 mb-2">Pengumuman akan dapat diakses pada tanggal: {{ \Carbon\Carbon::parse($result->seleksi->tanggal_pengumuman)->format('d-m-Y') }}</h2>
                @else
                    @if(optional($result->seleksi)->status_seleksi === 'LOLOS')
                        DI NYATAKAN
                        <h2 class="text-xl font-bold text-blue-600 mb-2">SELAMAT ANDA DITERIMA, DI PONDOK PESANTREN NURUL QURAN.</h2>
                    @elseif(optional($result->seleksi)->status_seleksi === 'TIDAK LOLOS')
                        DI NYATAKAN
                        <h2 class="text-xl font-bold text-red-600 mb-2"> MOHON MAAF ANDA BELUM DITERIMA, DI PONDOK PESANTREN NURUL QURAN.</h2>
                    @endif
                @endif
            </p>
        </div>
        @endforeach
    @else
        <h2 class="text-center text-2xl font-bold text-red-600">Belum ada pengumuman.</h2>
    @endif
</x-filament::page>
