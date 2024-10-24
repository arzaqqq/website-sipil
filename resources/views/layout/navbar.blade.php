@php
  $logo = get_section_data('Gambar logo')
@endphp

{{-- <div class="navbar bg-white sticky top-0 shadow-md z-50" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="200">
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
              <li><a href="{{url('/')}}" class="hover:bg-green-600 hover:text-white text-slate-800 active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300">Beranda</a></li>
              <li>
                  <details class="group">
                      <summary class="hover:bg-green-600 hover:text-white  text-slate-800 active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300 cursor-pointer">Perkuliahan</summary>
                      <ul class="bg-base-100 rounded-t-none p-2">
                          <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">Matakuliah</a></li>
                          <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">Kelas</a></li>
                      </ul>
                  </details>
              </li>
              <li>
                  <details class="group">
                      <summary class="hover:bg-green-600 hover:text-white  text-slate-800 active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300 cursor-pointer">Penilaian</summary>
                      <ul class="bg-base-100 rounded-t-none p-2">
                          <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">Soal</a></li>
                          <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">Sampel Jawaban</a></li>
                          <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">Rubrik Penilaian</a></li>
                      </ul>
                  </details>
              </li>
              <li>
                  <details class="group">
                      <summary class="hover:bg-green-600  hover:text-white  text-slate-800 active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300 cursor-pointer">Evaluasi & Hasil</summary>
                      <ul class="bg-base-100 rounded-t-none p-2">
                          <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">Hasil</a></li>
                          <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">Evaluasi</a></li>
                      </ul>
                  </details>
              </li>
              <li>
                <details class="group">
                    <summary class="hover:bg-green-600 hover:text-white  text-slate-800 active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300 cursor-pointer">Dokumen</summary>
                    <ul class="bg-base-100 rounded-t-none p-2">
                        <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">Kurikulum</a></li>
                        <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">SK</a></li>
                        <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">SPMI</a></li>
                        <li><a href="{{url('/admin/login')}}" class="hover:bg-green-600 hover:text-white">AMI</a></li>
                    </ul>
                </details>
            </li>
              <li><a href="{{url('/survei')}}" class="hover:bg-green-600  text-slate-800 hover:text-white active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300">Survei</a></li>
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
</div> --}}





<nav class="bg-white sticky top-0 z-50 border-b border-gray-200">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between ms-8 mx-auto p-4">
        <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{Storage::url($logo->foto)}}" alt="logo" class="w-[180px]">
        </a>
        <button id="navbar-toggler" data-collapse-toggle="navbar-dropdown" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 " aria-controls="navbar-dropdown" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
            <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white ">
                <li>
                    <a href="{{url('/') }}" class="block py-3 px-4 text-[12px] md:text-[14px] text-gray-900 font-semibold rounded md:bg-transparent md:text-gray-700 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-green-700 md:p-0" aria-current="page">Beranda</a>
                </li>
                <li>
                    <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar1" class="flex font-semibold text-[12px] md:text-[14px] items-center justify-between w-full py-3 px-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-700 md:p-0 md:w-auto">Perkuliahan<svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                    </button>
                    <div id="dropdownNavbar1" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44  ">
                        <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdownLargeButton">
                            <li>
                                <a href="{{url('/admin/login') }}" class="block px-4 py-2 hover:bg-green-500 md:hover:bg-green-500 md:hover:text-white lg:hover:bg-green-500 lg:hover:text-white">Matakuliah</a>
                            </li>
                            <li>
                                <a href="{{url('/admin/login') }}" class="block px-4 py-2 hover:bg-green-500  md:hover:bg-green-500 md:hover:text-white lg:hover:bg-green-500 lg:hover:text-white">Kelas</a>
                            </li>
                            <li>
                                <a href="{{url('/admin/login') }}" class="block px-4 py-2 hover:bg-green-500  md:hover:bg-green-500 md:hover:text-white lg:hover:bg-green-500 lg:hover:text-white">Dokumen</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar2" class="flex font-semibold items-center text-[12px] md:text-[14px] justify-between w-full py-3 px-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-700 md:p-0 md:w-auto">Penilaian <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <div id="dropdownNavbar2" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                        <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdownLargeButton">
                            <li>
                                <a href="{{url('/admin/login') }}" class="block px-4 py-2  hover:bg-green-500 md:hover:bg-green-500 md:hover:text-white lg:hover:bg-green-500 lg:hover:text-white">Soal</a>
                            </li>
                            <li>
                                <a href="{{url('/admin/login') }}" class="block px-4 py-2 hover:bg-green-500  md:hover:bg-green-500 md:hover:text-white lg:hover:bg-green-500 lg:hover:text-white">Sampel Jawaban</a>
                            </li>
                            <li>
                                <a href="{{url('/admin/login') }}" class="block px-4 py-2 hover:bg-green-500  md:hover:bg-green-500 md:hover:text-white lg:hover:bg-green-500 lg:hover:text-white">Evaluasi</a>
                            </li>
                            <li>
                                <a href="{{url('/admin/login') }}" class="block px-4 py-2 hover:bg-green-500  md:hover:bg-green-500 md:hover:text-white lg:hover:bg-green-500 lg:hover:text-white">Hasil Penilaian</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{url('/survei') }}" class="block py-3 px-4 text-[12px] md:text-[14px] text-gray-900 font-semibold rounded md:bg-transparent md:text-gray-700 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-green-700 md:p-0 " aria-current="page">Survei</a>
                </li>
                <li class="flex items-center mx-2 bg-green-100 px-2 py-0.5 rounded-lg ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-black">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <a href="{{url('/admin/login') }}" class="block py-3 px-4 text-[12px] md:text-[14px] text-gray-900 font-semibold rounded md:bg-transparent md:text-gray-700 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-green-700 md:p-0 " aria-current="page">Masuk</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


  


