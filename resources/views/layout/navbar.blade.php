@php
  $logo = get_section_data('Gambar logo')
@endphp

<div class="navbar bg-white sticky top-0 shadow-md z-50" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="200">
    <div class="flex-1 ms-8">
      <img src="{{Storage::url($logo->foto)}}" alt="logo" class="w-1/5">
    </div>
    <div class="flex-none">
      <ul class="menu menu-horizontal px-1 font-bold">
        <li><a href="{{url('/home')}}" class="hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300 me-1">Beranda</a></li>
        <li><a href="{{url('/survei')}}"  class="hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300 me-2">Survei</a></li> 
        <li class="flex items-center">
          <a href="{{url('/admin/login')}}" target="_blank" class="bg-green-600 text-white hover:bg-white hover:outline hover:outline-black hover:text-black flex items-center hover:outline-offset-[-2px]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>          
            Masuk
          </a>
        </li>
        
        
        {{-- <li>
          <details>
            <summary>Parent</summary>
            <ul class="bg-base-100 rounded-t-none p-2">
              <li><a>Link 1</a></li>
              <li><a>Link 2</a></li>
            </ul>
          </details>
        </li> --}}
      </ul>
    </div>
  </div>
