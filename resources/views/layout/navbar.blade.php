@php
  $logo = get_section_data('Gambar logo')
@endphp

<div class="navbar bg-base-100 sticky top-0 shadow-md z-50" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="200">
  <div class="flex justify-between items-center ms-8 w-full">
      <!-- Logo -->
      <div class="flex-1">
        <img src="{{Storage::url($logo->foto)}}" alt="logo" class="w-[180px]">
      </div>

      <!-- Hamburger Menu for Mobile -->
      <div class="block lg:hidden">
          <button id="menu-toggle" class="text-black focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
          </button>
      </div>

      <!-- Menu Items -->
      <div id="menu" class="hidden lg:flex flex-none">
          <ul class="menu menu-horizontal px-1 font-bold space-x-1">
              <li><a href="{{url('/')}}" class="hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300">Beranda</a></li>
              <li>
                  <details class="group">
                      <summary class="hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300 cursor-pointer">Perkuliahan</summary>
                      <ul class="bg-base-100 rounded-t-none p-2">
                          <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">Matakuliah</a></li>
                          <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">Kelas</a></li>
                      </ul>
                  </details>
              </li>
              <li>
                  <details class="group">
                      <summary class="hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300 cursor-pointer">Penilaian</summary>
                      <ul class="bg-base-100 rounded-t-none p-2">
                          <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">Soal</a></li>
                          <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">Sampel Jawaban</a></li>
                          <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">Rubrik Penilaian</a></li>
                      </ul>
                  </details>
              </li>
              <li>
                  <details class="group">
                      <summary class="hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300 cursor-pointer">Evaluasi & Hasil</summary>
                      <ul class="bg-base-100 rounded-t-none p-2">
                          <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">Hasil</a></li>
                          <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">Evaluasi</a></li>
                      </ul>
                  </details>
              </li>
              <li>
                <details class="group">
                    <summary class="hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300 cursor-pointer">Dokumen</summary>
                    <ul class="bg-base-100 rounded-t-none p-2">
                        <li><a href="#" class="hover:bg-green-600 hover:text-white">Kurikulum</a></li>
                        <li><a href="#" class="hover:bg-green-600 hover:text-white">SK</a></li>
                        <li><a href="#" class="hover:bg-green-600 hover:text-white">SPMI</a></li>
                        <li><a href="#" class="hover:bg-green-600 hover:text-white">AMI</a></li>
                    </ul>
                </details>
            </li>
              <li><a href="{{url('/survei')}}" class="hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300">Survei</a></li>
              <li class="flex items-center">
                <a href="{{url('/admin/login')}}" target="_blank" class="bg-green-600 text-white hover:bg-white hover:outline hover:outline-black hover:text-black flex items-center hover:outline-offset-[-2px]">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                  </svg>          
                  Masuk
                </a>
              </li>
          </ul>
      </div>
  </div>
</div>

<script>
  // Script to toggle the menu in mobile view
  const menuToggle = document.getElementById('menu-toggle');
  const menu = document.getElementById('menu');
  menuToggle.addEventListener('click', () => {
      menu.classList.toggle('hidden');
  });
</script>

