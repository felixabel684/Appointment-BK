<!-- Custom fonts for this template-->
<link href="{{ url('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ url('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">

<style>
    .form-group.position-relative {
        position: relative;
    }

    .container-fluid {
        overflow: visible;
        /* Pastikan tidak memotong dropdown */
    }

    #medicine-dropdown {
        position: absolute;
        /* Posisi absolut untuk menjaga posisi relatif terhadap input */
        z-index: 1050;
        /* Pastikan dropdown berada di atas elemen lain */
        background-color: #ffffff;
        /* Warna latar belakang dropdown */
        border: 1px solid #ced4da;
        /* Border dropdown */
        border-radius: 0.25rem;
        /* Membuat sudut dropdown melengkung */
        max-height: 200px;
        /* Maksimal tinggi dropdown */
        overflow-y: auto;
        /* Tambahkan scroll jika item banyak */
        width: 100%;
        /* Samakan lebar dropdown dengan input */
    }

    #medicine-dropdown .dropdown-item {
        padding: 0.5rem 1rem;
        /* Padding untuk item dropdown */
        cursor: pointer;
        /* Ubah kursor saat hover */
    }

    #medicine-dropdown .dropdown-item:hover {
        background-color: #f8f9fa;
        /* Warna latar belakang saat hover */
    }

    #selected-medicines {
        margin-top: 10px;
        /* Beri sedikit jarak dari elemen di atasnya */
    }

    #selected-medicines .medicine-item {
        display: flex;
        /* Gunakan flexbox untuk tata letak horizontal */
        justify-content: space-between;
        /* Jarak antara teks obat dan tombol hapus */
        align-items: center;
        /* Ratakan secara vertikal */
        padding: 10px;
        /* Beri ruang dalam untuk item */
        margin-bottom: 10px;
        /* Jarak antar item */
        border: 1px solid #ced4da;
        /* Tambahkan border untuk memperjelas batas item */
        border-radius: 5px;
        /* Tambahkan sudut melengkung */
        background-color: #f8f9fa;
        /* Latar belakang item */
    }

    #selected-medicines .medicine-item .medicine-name {
        flex-grow: 1;
        /* Pastikan teks obat mengambil ruang yang tersisa */
        margin-right: 10px;
        /* Beri jarak antara teks dan tombol hapus */
    }

    #selected-medicines .medicine-item .remove-medicine-btn {
        color: #dc3545;
        /* Warna tombol hapus */
        cursor: pointer;
        /* Ubah kursor saat hover */
    }

    #selected-medicines .medicine-item .remove-medicine-btn:hover {
        color: #a71d2a;
        /* Warna tombol saat di-hover */
    }
</style>
