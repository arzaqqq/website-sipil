@php
    $pertanyaan = get_questions('_pertanyaan');
@endphp

@extends('layout.template')

@section('title')
Survei
@endsection

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- Awal Survei --}}

<div class="container p-10 mx-auto bg-cover bg-center" style="background-image: url('img/bg4.jpg')">
    <div class="flex items-center justify-center">
        <div class="w-24 h-1 bg-green-600 me-4 mb-4 mt-4" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200"></div>
        <h1 class="text-2xl font-bold text-center">Survei Evaluasi</h1>
        <div class="w-24 h-1 bg-green-600 ms-4 mb-4 mt-4" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200"></div>
    </div>    

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg"> <!-- Tambahkan max-w-4xl untuk batas lebar -->
        <form id="surveyForm" action="{{ route('survey.store') }}" method="POST">
            @csrf
            <div class="space-y-12 step" style="display: block">
                <div class="border-b border-gray-900/10 pb-12 mt-8">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Informasi Personal</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Use a permanent address where you can receive mail.</p>
          
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
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
                                    @foreach(get_kelas() as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
            
                        <div class="sm:col-span-3">
                            <label for="nama_dosen" class="block text-sm font-medium leading-6 text-gray-900">Dosen</label>
                            <div class="mt-2">
                                <input type="text" name="nama_dosen" id="nama_dosen" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
                            </div>
                        </div>
            
                        {{-- <div class="col-span-full">
                            <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Alamat</label>
                            <div class="mt-2">
                                <input type="text" name="street-address" id="street-address" autocomplete="street-address" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div> --}}
                    </div>
                </div>
            
                <div class="mt-6 flex items-center justify-center gap-x-6">
                    <button type="button" class="nextBtn rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Selanjutnya</button>
                </div>
            </div>
            
            <div class="space-y-12 step" style="display: none">
                <div class="mt-10 space-y-10">
                    @foreach(get_questions('_pertanyaan') as $pertanyaan)
                    <fieldset>
                        <legend class="text-sm font-semibold leading-6 text-gray-900">{{ $pertanyaan->label }}</legend>
                        <p class="mt-1 text-sm leading-6 text-gray-600">{{ $pertanyaan->value }}</p>
                        <div class="mt-6 space-y-6">
                            @foreach([1 => 'Sangat Buruk', 2 => 'Buruk', 3 => 'Cukup', 4 => 'Baik', 5 => 'Sangat Baik'] as $ratingValue => $ratingLabel)
                                <div class="flex items-center gap-x-3">
                                    <input name="ratings[{{ $pertanyaan->id }}][rating]" type="radio" value="{{ $ratingValue }}" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" required>
                                    <label class="block text-sm font-medium leading-6 text-gray-900">{{ $ratingLabel }}</label>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>
                    @endforeach
                    
                    {{-- <fieldset>
                        <legend class="text-sm font-semibold leading-6 text-gray-900">Pertanyaan 2</legend>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Apakah kamu senang dengan dosennya?</p>
                        <div class="mt-6 space-y-6">
                            <div class="flex items-center gap-x-3">
                                <input id="push-everything" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                <label for="push-everything" class="block text-sm font-medium leading-6 text-gray-900">Sangat Buruk</label>
                            </div>
                            <div class="flex items-center gap-x-3">
                                <input id="push-email" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                <label for="push-email" class="block text-sm font-medium leading-6 text-gray-900">Buruk</label>
                            </div>
                            <div class="flex items-center gap-x-3">
                                <input id="push-nothing" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                <label for="push-nothing" class="block text-sm font-medium leading-6 text-gray-900">Cukup</label>
                            </div>
                            <div class="flex items-center gap-x-3">
                                <input id="push-nothing" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                <label for="push-nothing" class="block text-sm font-medium leading-6 text-gray-900">Baik</label>
                            </div>
                            <div class="flex items-center gap-x-3">
                                <input id="push-nothing" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                <label for="push-nothing" class="block text-sm font-medium leading-6 text-gray-900">Sangat Baik</label>
                            </div>
                        </div>
                    </fieldset> --}}
                </div>
                <div class="mt-6 flex items-center justify-center gap-x-6">
                    <button type="button" class="prevBtn rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sebelumya</button>
                    <button type="submit" class="nextBtn rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Kirim</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let currentStep = 0;
    const steps = document.querySelectorAll(".step");

    document.querySelectorAll(".nextBtn").forEach(button => {
        button.addEventListener("click", () => {
            steps[currentStep].style.display = "none";
            currentStep++;
            steps[currentStep].style.display = "block";
        });
    });

    document.querySelectorAll(".prevBtn").forEach(button => {
        button.addEventListener("click", () => {
            steps[currentStep].style.display = "none";
            currentStep--;
            steps[currentStep].style.display = "block";
        });
    });

    document.getElementById("surveyForm").addEventListener("submit", function(e) {
        alert("Survei berhasil dikirim!");
    });
  </script>

{{-- Akhir Survei --}}

@endsection