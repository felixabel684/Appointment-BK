<!-- Custom fonts for this template-->
<link href="{{ url('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ url('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">

<style>
    .badge-success {
        background-color: #28a745;
        color: #fff;
        padding: 0.4em 0.7em;
        border-radius: 0.2em;
    }

    .badge-danger {
        background-color: #dc3545;
        color: #fff;
        padding: 0.4em 0.7em;
        border-radius: 0.2em;
    }

    .table th {
        white-space: nowrap;
        /* Jangan turun baris */
        text-align: left;
        /* Rata kiri */
        padding: 10px;
        /* Jarak dalam */
        max-width: 200px;
        /* Batas lebar maksimal */
        overflow: hidden;
        /* Jika konten terlalu panjang, sembunyikan */
        text-overflow: ellipsis;
        /* Tambahkan ellipsis (...) untuk teks yang terlalu panjang */
    }

    .queue-number-text, .price-text {
        font-size: 1.5em;
        /* Perbesar ukuran teks */
        font-weight: bold;
        /* Buat teks lebih tebal */
        color: #343a40;
        /* Warna teks gelap (default Bootstrap) */
    }
</style>
