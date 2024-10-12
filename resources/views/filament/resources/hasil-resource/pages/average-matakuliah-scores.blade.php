<x-filament::page>
    <form action="{{ route('filament.pages.average-matakuliah-scores') }}" method="GET">
        <label for="matakuliah_id">Pilih Matakuliah:</label>
        <select name="matakuliah_id" onchange="this.form.submit()">
            <!-- Daftar opsi matakuliah, Anda bisa memodifikasi sesuai kebutuhan -->
            <option value="">Pilih Matakuliah</option>
            @foreach (App\Models\Matakuliah::all() as $matakuliah)
                <option value="{{ $matakuliah->id }}" {{ request('matakuliah_id') == $matakuliah->id ? 'selected' : '' }}>
                    {{ $matakuliah->nama_mk }}
                </option>
            @endforeach
        </select>
    </form>

    @if($averageData)
        <table class="table-auto w-full mt-6">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Komponen</th>
                    <th class="border px-4 py-2">Rata-rata</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-4 py-2">Absen</td>
                    <td class="border px-4 py-2">{{ $averageData['average_absen'] }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Tugas</td>
                    <td class="border px-4 py-2">{{ $averageData['average_tugas'] }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">UTS</td>
                    <td class="border px-4 py-2">{{ $averageData['average_uts'] }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">UAS</td>
                    <td class="border px-4 py-2">{{ $averageData['average_uas'] }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <p class="mt-6">Pilih matakuliah untuk melihat rata-rata nilai.</p>
    @endif
</x-filament::page>
