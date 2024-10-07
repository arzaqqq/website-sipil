@extends('layout.template')

@section('title')
Beranda
@endsection

@section('content')

{{-- Awal Carousel --}}
<div
  class="hero lg:min-h-screen md:h-52 sm:h-40 w-full"
  style="background-image: url(https://img.daisyui.com/images/stock/photo-1507358522600-9f71e620c44e.webp);">
  <div class="hero-overlay bg-opacity-60"></div>
  <div class="hero-content text-neutral-content text-center">
    <div class="max-w-md">
      <h1 class="mb-5 text-5xl font-bold" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">Profil Lulusan</h1>
      <a href="https://sipil.unimal.ac.id/" target="_blank" class="btn btn-success text-white hover:bg-white hover:text-black" data-aos="fade-down" data-aos-duration="2000" data-aos-delay="200">Cek Website</a>
    </div>
  </div>
</div>
  {{-- Akhir Carousel --}}

  {{-- Awal Narasi --}}
  <div class="container mx-auto mt-8">
    <div class="flex">
      <div class="w-24 h-1 bg-green-600 ms-12 mb-8 mt-4 " data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200"></div>
      <h1 class="text-3xl font-bold ms-4" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">Sejarah Program Studi Teknik Sipil</h1>
    </div>
    <p class="font-normal ms-12 mb-2 leading-relaxed" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">Program Studi Teknik Sipil Universitas Malikussaleh (Unimal) memiliki sejarah panjang yang beriringan dengan perkembangan pendidikan tinggi di Aceh. Sejarah ini dimulai sejak awal pendirian Universitas Malikussaleh pada akhir tahun 1980-an. Universitas ini didirikan dengan tujuan untuk memenuhi kebutuhan akan pendidikan tinggi di wilayah Aceh yang saat itu sangat terbatas, terutama dalam bidang-bidang teknis yang sangat diperlukan untuk pembangunan daerah. Fakultas Teknik menjadi salah satu fakultas awal yang dikembangkan, dan menjadi fondasi penting bagi pertumbuhan universitas.</p>
    <p class="font-normal ms-12 mb-2 leading-relaxed" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200">Pada tahun 1993, Program Studi Teknik Sipil resmi dibuka sebagai salah satu program studi di bawah Fakultas Teknik Unimal. Pembukaan program studi ini didasari oleh kebutuhan akan tenaga ahli yang dapat mendukung pembangunan infrastruktur di Aceh, serta menyediakan kesempatan bagi putra-putri daerah untuk mengenyam pendidikan tinggi di bidang teknik sipil tanpa harus pergi jauh dari daerah asal mereka. Seiring waktu, program ini terus berkembang, baik dari segi jumlah mahasiswa maupun kualitas akademiknya.</p>
    <p class="font-normal leading-relaxed ms-12 mb-2" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">Selama bertahun-tahun, Prodi Teknik Sipil Unimal mengalami perkembangan signifikan, terutama setelah Aceh mulai mengalami kebangkitan pasca konflik dan bencana tsunami pada awal 2000-an. Pada masa ini, kebutuhan akan tenaga ahli di bidang rekonstruksi dan pembangunan infrastruktur semakin mendesak, mendorong Unimal untuk lebih serius dalam mengembangkan Prodi Teknik Sipil. Dengan dukungan pemerintah dan berbagai pihak lainnya, program ini berhasil memperluas cakupan kurikulumnya, meningkatkan kualitas pengajar, serta memperbaiki infrastruktur pendukung pendidikan, seperti laboratorium dan fasilitas penelitian.</p>
    <p class="font-normal ms-12 mb-2" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200">Masuk ke dekade 2010-an, Program Studi Teknik Sipil Unimal semakin memperkuat posisinya sebagai salah satu program unggulan universitas. Kerjasama dengan berbagai pihak, baik di tingkat nasional maupun internasional, mulai dibangun untuk mendukung peningkatan kualitas pendidikan dan penelitian. Kurikulum diperbarui agar sesuai dengan perkembangan teknologi dan standar global, memungkinkan lulusan dari program ini untuk bersaing di pasar kerja nasional dan internasional. Di sisi lain, jumlah lulusan yang sukses berkarir di bidang teknik sipil juga semakin meningkat, memberikan dampak nyata terhadap pembangunan di Aceh dan sekitarnya.</p>
    <p class="font-normal leading-relaxed ms-12 mb-2" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">Seiring waktu, Prodi Teknik Sipil Unimal terus berkembang dengan memanfaatkan teknologi digital dan penelitian terapan di bidang teknik sipil. Ke depannya, program studi ini diharapkan akan semakin berperan dalam mendukung pembangunan infrastruktur di Indonesia, terutama di wilayah-wilayah yang membutuhkan tenaga ahli di bidang teknik sipil. Dengan visi menjadi pusat pendidikan teknik sipil yang unggul, Prodi Teknik Sipil Unimal berkomitmen untuk terus berinovasi dan berkontribusi terhadap pembangunan bangsa.</p>
   
  </div>
  {{-- Akhir Narasi --}}

  {{-- Awal Profil Lulusan --}}
  <div class="container mx-auto mt-8">
    <div class="flex flex-row-reverse">
      <div class="w-24 h-1 bg-green-600 me-12 mb-4 mt-4 " data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200"></div>
      <h1 class="text-3xl font-bold me-4" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">Profil Lulusan</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
      <img
      src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
      alt="Shoes" class="ms-12 w-10/12 rounded-lg" data-aos="flip-left" data-aos-duration="1000" data-aos-delay="200"/>
      <div class="flex flex-col">
        <p class="font-normal leading-relaxed me-2 mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quidem, asperiores. Corrupti recusandae ex, quos dolorum magnam ab blanditiis porro praesentium.</p>
        <div class="overflow-x-auto md:mt-0">
          <table class="table table-responsive table-auto" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="200">
            <!-- head -->
            <thead class="bg-gray-200">
              <tr class="text-black text-base">
                <th>No</th>
                <th>Profil Lulusan (PL) </th>
                <th>Deskripsi Profil Lulusan</th>
              </tr>
            </thead>
            <tbody>
              <tr class="hover:bg-green-200">
                <th>1</th>
                <td>Cy Ganderton</td>
                <td>Quality Control Specialist</td>
              </tr>
              <tr class="hover:bg-green-200">
                <th>2</th>
                <td>Hart Hagerty</td>
                <td>Desktop Support Technician</td>
              </tr>
              <tr class="hover:bg-green-200">
                <th>3</th>
                <td>Hart Hagerty</td>
                <td>Desktop Support Technician</td>
              </tr>
              <tr class="hover:bg-green-200">
                <th>4</th>
                <td>Hart Hagerty</td>
                <td>Desktop Support Technician</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  {{-- Akhir Profil Lulusan --}}

  {{-- Awal  Dokumen Lainnya --}}
  <div class="container mx-auto mt-8">
    <div class="flex items-center justify-center">
      <div class="w-24 h-1 bg-green-600 ms-12 mb-4 mt-4 " data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200"></div>
      <h1 class="text-3xl font-bold ms-4" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="200">Dokumen Lainnya</h1>
      <div class="w-24 h-1 bg-green-600 ms-4 mb-4 mt-4 " data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200"></div>
    </div>
      <div class="collapse" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
        <input type="checkbox" />
        <div class="collapse-title flex items-center text-base">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
            <p class="text-base font-medium ms-1">Dokumen</p>
          </svg>          
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
        </div>
        
        <div class="collapse-content flex items-center ms-6">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m16.49 12 3.75 3.75m0 0-3.75 3.75m3.75-3.75H3.74V4.499" />
          </svg>
          <p class="text-sm">Dokumen Kurikulum</p>
        </div>
      </div>
      <div class="collapse" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
        <input type="checkbox" />
        <div class="collapse-title flex items-center text-base">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
            <p class="text-base font-medium ms-1">SK</p>
          </svg>          
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
        </div>
        
        <div class="collapse-content flex items-center ms-6">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m16.49 12 3.75 3.75m0 0-3.75 3.75m3.75-3.75H3.74V4.499" />
          </svg>
          <p class="text-sm">Dokumen SK</p>
        </div>
      </div>
      <div class="collapse" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
        <input type="checkbox" />
        <div class="collapse-title flex items-center text-base">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
            <p  class="text-base font-medium ms-1">SPMI</p>
          </svg>          
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
        </div>
        
        <div class="collapse-content flex items-center ms-6">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m16.49 12 3.75 3.75m0 0-3.75 3.75m3.75-3.75H3.74V4.499" />
          </svg>
          <a href="#" target="_blank" class="text-sm">Dokumen SPMI</a>
        </div>
      </div>
      <div class="collapse" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
        <input type="checkbox" />
        <div class="collapse-title flex items-center text-base">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
            <p class="text-base font-medium ms-1">AMI</p>
          </svg>          
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
        </div>
        
        <div class="collapse-content flex items-center ms-6">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m16.49 12 3.75 3.75m0 0-3.75 3.75m3.75-3.75H3.74V4.499" />
          </svg>
          <a href="#" target="_blank" class="text-sm">Dokumen AMI</a>
        </div>
      </div>
      
  </div>
  {{-- Akhir Dokumen Lainnya --}}
@endsection