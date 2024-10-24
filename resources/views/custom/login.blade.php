<style>
    .full-width-button {
        display: block; /* Agar elemen a menjadi blok dan memenuhi lebar penuh */
        width: 100%;
        height: 35px; /* Atur tinggi tombol secara absolut */
        background-color: rgb(50, 198, 13); /* Warna latar belakang merah */
        color: white; /* Warna teks putih */
        text-align: center; /* Teks di tengah */
        padding: 0; /* Menghapus padding untuk memusatkan teks */
        text-decoration: none; /* Menghapus garis bawah */
        border-radius: 10px; /* Sudut yang melengkung */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Bayangan untuk efek kedalaman */
        line-height: 35px; /* Memusatkan teks secara vertikal */
        font-weight: bold;
        font-size: 13px;
    }

    .full-width-button:hover {
        background-color: rgb(14, 133, 14); /* Warna latar belakang saat hover */
    }
</style>

<div>
    <a href="{{url('/')}}" class="full-width-button">Kembali</a>
</div>
