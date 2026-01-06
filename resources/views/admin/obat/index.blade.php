<x-layouts.app title="Data Obat">
    <div class="container-fluid px-4 mt-4">
        <div class="row">
            <div class="col-lg-12">

                {{-- ALERT FLASH MESSAGE --}}
                @if (session('message'))
                    <div class="alert alert-{{ session('type', 'success') }} alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <h1 class="mb-4">Data Obat</h1>

                <a href="{{ route('admin.obat.create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus"></i> Tambah Obat
                </a>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Nama Obat</th>
                                <th>Kemasan</th>
                                <th>Harga</th>
                                {{-- PERBAIKAN: Menambahkan Header Kolom Stok --}}
                                <th>Stok</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($obats as $obat)
                                <tr>
                                    <td>{{ $obat->id }}</td>
                                    <td>{{ $obat->nama_obat }}</td>
                                    <td>{{ $obat->kemasan }}</td>
                                    <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>

                                    {{-- PERBAIKAN: Menambahkan Data Stok dengan Indikator Warna --}}
                                    <td>
                                        @if($obat->stok <= 0)
                                            <span class="badge bg-danger">Habis (0)</span>
                                        @elseif($obat->stok < 10)
                                            <span class="badge bg-warning text-dark">{{ $obat->stok }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $obat->stok }}</span>
                                        @endif
                                    </td>

                                    <td style="width: 150px;">
                                        {{-- Edit --}}
                                        <a href="{{ route('admin.obat.edit', $obat->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        {{-- Hapus --}}
                                        <form action="{{ route('admin.obat.destroy', $obat->id) }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus Data Obat ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    {{-- Sesuaikan colspan karena jumlah kolom bertambah --}}
                                    <td colspan="6" class="text-center">Belum ada Data Obat</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 500);
            }
        }, 2000);
    </script>
</x-layouts.app>
