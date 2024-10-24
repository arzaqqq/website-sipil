@php
  $foto_bg = get_section_data('Gambar Background');
  $foto_kelulusan = get_section_data('Gambar Profil Kelulusan');
  $nama_website = get_setting_value('_nama_website');
  $judul_web = get_setting_value('_site_name');
  $subjudul1 = get_setting_value('_subjudul1');
  $subjudul2 = get_setting_value('_subjudul2');
  $narasi1 = get_setting_value('_narasi1');
  $narasi2 = get_setting_value('_narasi2');
  $nama = get_header_value('_nama');
  $deskripsi = get_header_value('_deskripsi');
@endphp


@extends('layout.template')

@section('title')
Beranda
@endsection

@section('content')

{{-- Awal Carousel --}}
<div
  class="hero lg:min-h-screen md:h-52 sm:h-40 w-full"
  style="background-image: url('{{ Storage::url($foto_bg->foto) }}');">
  <div class="hero-overlay bg-opacity-60"></div>
  <div class="hero-content text-neutral-content text-center">
    <div class=" max-w-xl">
      <h1 class="mb-3 text-4xl font-bold text-slate-800" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">{{$nama_website}}</h1>
      <h3 class="mb-5 text-3xl font-bold text-slate-800" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">{{$judul_web}}</h3>
      <a href="https://sipil.unimal.ac.id/" target="_blank" class="btn btn-success text-white hover:bg-white hover:text-black" data-aos="fade-down" data-aos-duration="2000" data-aos-delay="200">Cek Website</a>
    </div>
  </div>
</div>
  {{-- Akhir Carousel --}}

  {{-- Awal Narasi --}}
  <div class="container mx-auto mt-8">
    <div class="flex">
      <div class="w-24 h-1 bg-green-600 ms-12 mb-8 mt-4 " data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200"></div>
      <h1 class="text-3xl font-bold ms-4 text-slate-800" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">{{ $subjudul1 }}</h1>
    </div>
    <div class="font-normal ms-12 mb-2 leading-relaxed text-slate-8 text-slate-800" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">{!! ($narasi1) !!}</div> 
  </div>
  {{-- Akhir Narasi --}}

  {{-- Awal Profil Lulusan --}}
  <div class="container mx-auto mt-8">
    <div class="flex flex-row-reverse">
      <div class="w-24 h-1 bg-green-600 me-12 mb-4 mt-4 " data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200"></div>
      <h1 class="text-3xl font-bold me-4 text-slate-800" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">{{ $subjudul2 }}</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
      <img
      src="{{Storage::url($foto_kelulusan->foto)}}"
      alt="Shoes" class="ms-12 w-10/12 rounded-lg" data-aos="flip-left" data-aos-duration="1000" data-aos-delay="200"/>
      <div class="flex flex-col">
        <div class="font-normal leading-relaxed me-2 mb-4 text-slate-800" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">{!! $narasi2 !!}</div>
        <div class="overflow-x-auto md:mt-0">
          <table class="table table-responsive table-auto" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="200">
            <!-- head -->
            <thead class="bg-gray-200">
              <tr class="text-black text-base">
                <th>No</th>
                <th>{{$nama}}</th>
                <th>{{$deskripsi}}</th>
              </tr>
            </thead>
            <tbody>
              @php
              $no = 1;
              @endphp
              @foreach (get_profile()->take(5) as $profile)
              <tr class="hover:bg-green-200 text-slate-8">
                <th>{{ $no++ }}</th>
                <td>{{ $profile->nama_profil}}</td>
                <td>{!! $profile->deskripsi_profil !!}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  {{-- Akhir Profil Lulusan --}}
@endsection