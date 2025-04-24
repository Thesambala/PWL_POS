<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-penjualan">
    @csrf
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaksi Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                {{-- Data Umum --}}
                <div class="form-group">
                    <label>Nama Pembeli</label>
                    <input type="text" name="pembeli" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Kasir</label>
                    <select class="form-control" name="user_id" required>
                        <option value="">- Pilih -</option>
                        @foreach ($user as $item)
                            <option value="{{ $item->user_id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Kode Penjualan</label>
                    <input type="text" name="penjualan_kode" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Pembelian</label>
                    <input type="date" name="penjualan_tanggal" id="tanggal" class="form-control" required>
                </div>

                {{-- Detail Barang --}}
                <h6>Barang</h6>
                <table class="table table-sm" id="table-barang">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th><button type="button" class="btn btn-sm btn-success" id="addRow">+</button></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="barang_id[]" class="form-control barang-select" required>
                                    <option value="">Pilih</option>
                                    @foreach ($barang as $b)
                                        <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}">
                                            {{ $b->barang_kode }} - {{ $b->barang_nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="harga[]" class="form-control harga" readonly></td>
                            <td><input type="number" name="jumlah[]" class="form-control jumlah" value="1"
                                    required></td>
                            <td><input type="number" name="subtotal[]" class="form-control subtotal" readonly></td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-right">
                    <strong>Total: <span id="total">Rp 0</span></strong>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</form>

<script>
    $('#form-penjualan').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: "POST",
            data: $(this).serialize(),
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                    }).then(() => {
                        location.reload(); // atau reset form
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: res.message,
                    });
                }
            },
            error: function(xhr) {
                let msg = xhr.responseJSON?.message || 'Terjadi kesalahan.';
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                });
            }
        });
    });
    $(document).ready(function() {
        // Auto-set tanggal ke hari ini
        $('#tanggal').val(new Date().toISOString().slice(0, 10));

        function formatRupiah(angka) {
            return 'Rp ' + angka.toLocaleString('id-ID');
        }

        function hitungSubtotal(row) {
            let harga = parseFloat(row.find('.harga').val()) || 0;
            let jumlah = parseInt(row.find('.jumlah').val()) || 0;
            let subtotal = harga * jumlah;
            row.find('.subtotal').val(subtotal);
            return subtotal;
        }

        function hitungTotal() {
            let total = 0;
            $('#table-barang tbody tr').each(function() {
                total += hitungSubtotal($(this));
            });
            $('#total').text(formatRupiah(total));
        }

        $('#table-barang').on('change', '.barang-select', function() {
            let harga = parseFloat($(this).find(':selected').data('harga')) || 0;
            let row = $(this).closest('tr');
            row.find('.harga').val(harga);
            hitungSubtotal(row);
            hitungTotal();
        });

        $('#table-barang').on('input', '.jumlah', function() {
            let row = $(this).closest('tr');
            hitungSubtotal(row);
            hitungTotal();
        });

        $('#addRow').click(function() {
            const newRow = `
            <tr>
            <td>
                <select name="barang_id[]" class="form-control barang-select" required>
                    <option value="">Pilih</option>
                    @foreach ($barang as $b)
                        <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}">
                            {{ $b->barang_kode }} - {{ $b->barang_nama }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="harga[]" class="form-control harga" readonly></td>
            <td><input type="number" name="jumlah[]" class="form-control jumlah" value="1" required></td>
            <td><input type="number" name="subtotal[]" class="form-control subtotal" readonly></td>
            <td>
                <button type="button" class="btn btn-danger removeRow">Hapus</button>
            </td>
        </tr>
        `;
            $("#table-barang tbody").append(newRow);
        });
        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
            hitungTotal();
        });
    });
</script>