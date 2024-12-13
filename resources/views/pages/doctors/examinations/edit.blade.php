@extends('layouts.doctor')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Pemeriksaan Pasien {{ $examinations_patient->patient->patientName }}</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('examinations.update', $examinations->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="list_clinics_id" value="{{ $examinations->list_clinics_id }}">

                    <div class="form-group">
                        <label for="patientName">No RM</label>
                        <input type="text" class="form-control" name="patientName" id="patientName"
                            value="{{ $examinations_patient->patient->rmNumber }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="examinationDate">Tanggal Pemeriksaan</label>
                        <input type="datetime-local" class="form-control" name="examinationDate" id="examinationDate"
                            value="{{ old('examinationDate', \Carbon\Carbon::parse($examinations->examinationDate)->format('Y-m-d\TH:i')) }}"
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="note">Catatan</label>
                        <textarea name="note" rows="5" class="d-block w-100 form-control">{{ old('note', $examinations->note) }}</textarea>
                    </div>

                    <div class="form-group position-relative">
                        <label for="medicine-search">Cari Obat</label>
                        <input type="text" id="medicine-search" class="form-control"
                            placeholder="Ketik nama atau kemasan obat...">
                        <div id="medicine-dropdown" class="dropdown-menu" style="display: none;"></div>
                    </div>

                    <div id="selected-medicines" class="mt-3">
                        @foreach ($examinations->examination_medicines as $medicine)
                            <div class="medicine-item">
                                <span>{{ $medicine->medicineName }} | {{ $medicine->packaging }} | Rp.
                                    {{ $medicine->price }}</span>
                                <button type="button" class="btn btn-danger btn-sm ml-2 remove-medicine"
                                    data-price="{{ $medicine->price }}" data-id="{{ $medicine->id }}">Hapus</button>
                                <input type="hidden" name="medicines[]" value="{{ $medicine->id }}">
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label for="price">Harga Total</label>
                        <input type="text" id="price" name="price" class="form-control" readonly
                            value="{{ old('price', $examinations->price) }}">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Update
                    </button>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('medicine-search');
                const dropdown = document.getElementById('medicine-dropdown');
                const selectedMedicinesContainer = document.getElementById('selected-medicines');
                const priceInput = document.getElementById('price');
                let totalPrice = parseInt(priceInput.value); // Mengambil total harga yang sudah ada

                // Mencari obat saat mengetik
                searchInput.addEventListener('input', function() {
                    const query = this.value;

                    if (query.length > 2) {
                        fetch(`{{ route('medicines.search') }}?query=${query}`)
                            .then(response => response.json())
                            .then(medicines => {
                                dropdown.innerHTML = '';
                                dropdown.style.display = 'block';

                                medicines.forEach(medicine => {
                                    const item = document.createElement('a');
                                    item.classList.add('dropdown-item');
                                    item.textContent =
                                        `${medicine.medicineName} | ${medicine.packaging} | Rp. ${medicine.price.toLocaleString()}`;
                                    item.setAttribute('data-id', medicine.id);
                                    item.setAttribute('data-name', medicine.medicineName);
                                    item.setAttribute('data-price', medicine.price);
                                    item.addEventListener('click', addMedicine);
                                    dropdown.appendChild(item);
                                });
                            });
                    } else {
                        dropdown.style.display = 'none';
                    }
                });

                // Menambahkan obat ke daftar
                function addMedicine(event) {
                    event.preventDefault();
                    const medicineId = this.getAttribute('data-id');
                    const medicineName = this.getAttribute('data-name');
                    const medicinePrice = parseInt(this.getAttribute('data-price'));
                    const medicinePackaging = this.textContent.split('|')[1].trim();

                    const listItem = document.createElement('div');
                    listItem.classList.add('medicine-item');
                    listItem.innerHTML = `<span>${medicineName} | ${medicinePackaging} | Rp. ${medicinePrice.toLocaleString()}</span>
                        <button type="button" class="btn btn-danger btn-sm ml-2 remove-medicine" data-price="${medicinePrice}">Hapus</button>
                        <input type="hidden" name="medicines[]" value="${medicineId}">`;
                    listItem.querySelector('.remove-medicine').addEventListener('click', removeMedicine);

                    selectedMedicinesContainer.appendChild(listItem);
                    dropdown.style.display = 'none';

                    totalPrice += medicinePrice;
                    updateTotalPrice();
                }

                // Menghapus obat dari daftar
                function removeMedicine() {
                    const button = event.target;
                    const medicinePrice = parseInt(this.getAttribute('data-price'));
                    this.parentElement.remove();

                    totalPrice -= medicinePrice;
                    updateTotalPrice();
                }

                // Tambahkan event listener untuk tombol "Hapus" pada obat yang sudah ada saat halaman dimuat
                const existingRemoveButtons = selectedMedicinesContainer.querySelectorAll('.remove-medicine');
                existingRemoveButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const medicinePrice = parseInt(this.getAttribute('data-price'));
                        this.parentElement.remove();

                        totalPrice -= medicinePrice;
                        updateTotalPrice();
                    });
                });

                // Memperbarui total harga
                function updateTotalPrice() {
                    priceInput.value = totalPrice.toLocaleString();
                }
            });
        </script>

    </div>
@endsection
