@php
    $pertanyaan = get_questions('_pertanyaan');
    $totalPertanyaan = count($pertanyaan);
    $pertanyaanPerPage = 5;
    $pages = ceil($totalPertanyaan / $pertanyaanPerPage);
@endphp

@extends('layout.template')

@section('title')
Survei
@endsection

@section('content')


{{-- Awal Survei --}}

<div class="container p-10 mx-auto bg-cover bg-center" style="background-image: url('img/bg4.jpg')">
    <div class="flex items-center justify-center">
        <div class="w-24 h-1 bg-green-600 me-4 mb-4 mt-4" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200"></div>
        <h1 class="text-2xl font-bold text-center">Survei Evaluasi</h1>
        <div class="w-24 h-1 bg-green-600 ms-4 mb-4 mt-4" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200"></div>
    </div>    

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg"> <!-- Tambahkan max-w-4xl untuk batas lebar -->
        <form id="surveyForm" action="{{ route('survey.store') }}" method="POST">
                @if (session('success'))
                <div id="success-alert" class="text-sm p-2 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
                </div>
                @endif
            @csrf
            <div class="space-y-12 step" style="display: block">
                <div class="mb-8 border-b border-gray-300 pb-4">
                    <h2 class="text-lg font-semibold text-gray-900">PETUNJUK PENGISIAN</h2>
                    <ol class="list-decimal ml-5 text-gray-700">
                        <li>Kuesioner ini wajib diisi oleh setiap mahasiswa Jurusan Teknik Sipil Fakultas Teknik Universitas Malikussaleh.</li>
                        <li>Setiap kuesioner berlaku untuk satu dosen (mohon isi ulang/ submit respons baru untuk mengevaluasi dosen lainnya).</li>
                        <li>Mahasiswa wajib mengisi sejumlah matakuliah yang diambil untuk setiap dosen pengampu (Misal: jika mengambil 12 MK dengan masing-masing 2 dosen pengampu, maka harap mengisi form 24 kali).</li>
                        <li>Kuesioner bersifat rahasia (tidak disebarluaskan).</li>
                        <li>Kuesioner tidak mempengaruhi nilai Matakuliah.</li>
                        <li>Mohon diisi dengan SERIUS dan JUJUR ke dalam form ini.</li>
                    </ol>
                </div>
                <div class="border-b border-gray-900/10 pb-12 mt-2">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Data Mahasiswa</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Data anda bersifat rahasia</p>
          
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="nama" class="block text-sm font-medium leading-6 text-gray-900">Nama Lengkap</label>
                            <div class="mt-2">
                                <input type="text" name="nama" id="nama" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
            
                        <div class="sm:col-span-4">
                            <label for="nim" class="block text-sm font-medium leading-6 text-gray-900">NIM</label>
                            <div class="mt-2">
                                <input type="text" name="nim" id="nim" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
            
                        <div class="sm:col-span-4">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email Mahasiswa</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <label for="matakuliah_id" class="block text-sm font-medium leading-6 text-gray-900">Matakuliah</label>
                            <div class="mt-2">
                                <select id="matakuliah_id" name="matakuliah_id" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" required>
                                    <option value="">-- Pilih Matakuliah --</option>
                                    @foreach(get_matakuliahs() as $matakuliah)
                                    <option value="{{ $matakuliah->id }}">{{ $matakuliah->nama_mk }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <label for="kelas_id" class="block text-sm font-medium leading-6 text-gray-900">Kelas</label>
                            <div class="mt-2">
                                <select id="kelas_id" name="kelas_id" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @if(old('matakuliah_id'))
                                        @foreach(get_kelas_by_matakuliah(old('matakuliah_id')) as $kelas)
                                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
            
                        <div class="sm:col-span-4">
                            <label for="nama_dosen" class="block text-sm font-medium leading-6 text-gray-900">Dosen</label>
                            <div class="mt-2">
                                <input type="text" name="nama_dosen" id="nama_dosen" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @foreach(range(1, $pages) as $page)
            <div class="space-y-12 step" style="display: {{ $page == 0 ? 'block' : 'none' }}">
                    @php
                        $start = ($page - 1) * $pertanyaanPerPage;
                        $end = min($start + $pertanyaanPerPage, $totalPertanyaan);
                    @endphp
                    @for($i = $start; $i < $end; $i++)
                    @php
                        $pertanyaanItem = $pertanyaan[$i];
                    @endphp
                        <fieldset>
                            <legend class="text-sm font-semibold leading-6 text-gray-900">{{ $pertanyaanItem->label }}</legend>
                            <p class="mt-1 text-sm leading-6 text-gray-600">{{ $pertanyaanItem->value }}</p>
                            <div class="mt-6 space-y-6">
                                @foreach([1 => 'Sangat Buruk', 2 => 'Buruk', 3 => 'Cukup', 4 => 'Baik', 5 => 'Sangat Baik'] as $ratingValue => $ratingLabel)
                                    <div class="flex items-center gap-x-3">
                                        <input name="ratings[{{ $pertanyaanItem->id }}][rating]" type="radio" value="{{ $ratingValue }}" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" required>
                                        <label class="block text-sm font-medium leading-6 text-gray-900">{{ $ratingLabel }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>
                    @endfor
                </div>
                @endforeach
                <div class="mt-6 flex items-center justify-center gap-x-6">
                    <button type="button" class="prevBtn rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">Sebelumya</button>
                    <button type="button" class="nextBtn rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Selanjutnya</button>
                    <button type="submit" class="submitBtn rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Kirim</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let currentStep = 0;
    const steps = document.querySelectorAll(".step");
    const nextBtn = document.querySelectorAll(".nextBtn");
    const prevBtn = document.querySelectorAll(".prevBtn");
    const submitBtn = document.querySelectorAll(".submitBtn");

    // Button naik ke atas
    document.querySelectorAll('.nextBtn').forEach(function(button) {
            button.addEventListener('click', function() {
                // Scroll ke bagian atas halaman
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        document.querySelectorAll('.prevBtn').forEach(function(button) {
            button.addEventListener('click', function() {
                // Scroll ke bagian atas halaman
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        // Button otomatis
    function updateButtons() {
        if (currentStep === steps.length - 1) {
            // Halaman terakhir
            nextBtn.forEach(btn => btn.style.display = "none");
            submitBtn.forEach(btn => btn.style.display = "inline-block");
        } else {
            // Bukan halaman terakhir
            nextBtn.forEach(btn => btn.style.display = "inline-block");
            submitBtn.forEach(btn => btn.style.display = "none");
        }

        // Tombol "Sebelumnya" hanya ditampilkan jika bukan di langkah pertama
        prevBtn.forEach(btn => btn.style.display = currentStep === 0 ? "none" : "inline-block");
    }

    nextBtn.forEach(button => {
        button.addEventListener("click", () => {
            if (currentStep < steps.length - 1) {
                steps[currentStep].style.display = "none";
                currentStep++;
                steps[currentStep].style.display = "block";
                updateButtons();
            }
        });
    });

    prevBtn.forEach(button => {
        button.addEventListener("click", () => {
            if (currentStep > 0) {
                steps[currentStep].style.display = "none";
                currentStep--;
                steps[currentStep].style.display = "block";
                updateButtons();
            }
        });
    });

    // Update tombol saat pertama kali halaman dimuat
    updateButtons();

    // Kelas Matakuliah
    document.getElementById('matakuliah_id').addEventListener('change', function() {
        const matakuliahId = this.value;
        const kelasSelect = document.getElementById('kelas_id');
        
        kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>'; // Reset pilihan kelas

        if (matakuliahId) {
            fetch(`/kelas/${matakuliahId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(kelas => {
                        const option = document.createElement('option');
                        option.value = kelas.id;
                        option.textContent = kelas.nama_kelas;
                        kelasSelect.appendChild(option);
                    });
                });
        }
    });

    // Untuk alert
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.getElementById('success-alert');
        
        if (successAlert) {
            // Atur untuk menghilang setelah 3 detik (3000 ms)
            setTimeout(function() {
                successAlert.style.display = 'none';
            }, 2000); // Ubah angka 3000 sesuai kebutuhan
        }
    });

</script>

{{-- Akhir Survei --}}

@endsection