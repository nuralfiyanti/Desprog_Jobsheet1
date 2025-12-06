<?php 

include('auth.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Dengan Ajax</title>

    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTIWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<nav class="navbar navbar-dark bg-primary">
    <a class="navbar-brand" href="#" style="color: white;">CRUD Dengan Ajax</a>
</nav>

<div class="container mt-4">
    <h2 class="text-center mb-4">Data Anggota</h2>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form id="form-anggota">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nama">Nama:</label>
                        <input type="text" id="nama" name="nama" class="form-control" required="true">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Jenis Kelamin:</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="L" required>
                            <label class="form-check-label" for="laki">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="P">
                            <label class="form-check-label" for="perempuan">Perempuan</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <input type="text" id="alamat" name="alamat" class="form-control" required="true">
                </div>
                
                <div class="form-group">
                    <label for="no_telp">No. Telp:</label>
                    <input type="text" id="no_telp" name="no_telp" class="form-control" required="true">
                </div>

                <input type="hidden" name="aksi" id="aksi" value="tambah">
                <input type="hidden" name="id" id="id">

                <hr>
                
                <div class="form-group text-right">
                    <button type="submit" id="btn-simpan" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="reset" id="btn-reset" class="btn btn-secondary d-none">Batal</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="data-container mt-4">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>No Telp</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
        </table>
    </div>

    <div class="text-center mt-3 text-muted">
        <p>Desprog JSI | Copyright 2025 by ....</p>
    </div>

</div>

<div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data anggota ini?
                <input type="hidden" id="delete-id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="btn-konfirmasi-hapus">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>


<script type="text/javascript">
$(document).ready(function() {
    // Ambil Token CSRF dari meta tag
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    // Konfigurasi Header Default untuk AJAX (Menambahkan CSRF Token)
    $.ajaxSetup({
        headers: {
            'Csrf-Token': csrfToken
        }
    });

    // 1. INISIALISASI DATATABLES
    let tabelAnggota = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "data.php", // Panggil file data.php
            "type": "POST"
        },
        // Definisikan kolom untuk DataTables Server-Side Processing
        "columns": [
            {"data": "no", "orderable": false, "searchable": false},
            {"data": "nama"},
            {"data": "jenis_kelamin"},
            {"data": "alamat"},
            {"data": "no_telp"},
            {"data": "aksi", "orderable": false, "searchable": false}
        ]
    });

    // 2. LOGIKA CREATE & UPDATE (SUBMIT FORM)
    $('#form-anggota').on('submit', function(e) {
        e.preventDefault();
        let dataForm = $(this).serialize(); // Ambil semua data form
        let aksiUrl = $('#aksi').val(); // 'tambah' atau 'edit'

        $.ajax({
            url: "proses.php", 
            type: "POST",
            data: dataForm,
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    // Reset form dan refresh tabel
                    $('#form-anggota')[0].reset();
                    $('#aksi').val('tambah'); // Kembalikan aksi ke 'tambah'
                    $('#btn-simpan').html('<i class="fa fa-save"></i> Simpan');
                    $('#btn-reset').addClass('d-none');
                    
                    tabelAnggota.ajax.reload(null, false); // Reload DataTables
                    alert((aksiUrl == 'tambah' ? 'Data berhasil ditambahkan!' : 'Data berhasil diupdate!'));
                } else {
                    alert('Gagal: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan server: ' + xhr.responseJSON.error);
            }
        });
    });

    // 3. LOGIKA GET DATA UNTUK EDIT
    $('#example tbody').on('click', '.edit_data', function() {
        let id = $(this).attr('id'); // Ambil ID dari atribut ID tombol
        
        $.ajax({
            url: "proses.php",
            type: "GET",
            data: { aksi: 'getDataById', id: id },
            dataType: "json",
            success: function(data) {
                // Isi form dengan data yang didapatkan
                $('#id').val(data.id);
                $('#nama').val(data.nama);
                $(`input[name="jenis_kelamin"][value="${data.jenis_kelamin}"]`).prop('checked', true);
                $('#alamat').val(data.alamat);
                $('#no_telp').val(data.no_telp);
                
                // Ubah status form menjadi EDIT
                $('#aksi').val('edit');
                $('#btn-simpan').html('<i class="fa fa-edit"></i> Update');
                $('#btn-reset').removeClass('d-none');
            }
        });
    });

    // Tombol Batal Edit
    $('#btn-reset').on('click', function() {
        $('#form-anggota')[0].reset();
        $('#aksi').val('tambah');
        $('#btn-simpan').html('<i class="fa fa-save"></i> Simpan');
        $(this).addClass('d-none');
    });

    // 4. LOGIKA DELETE (AJAX & Modal)
    $('#example tbody').on('click', '.hapus_data', function() {
        let id = $(this).attr('id');
        $('#delete-id').val(id); // Simpan ID di modal hidden input
        $('#hapusModal').modal('show');
    });

    $('#btn-konfirmasi-hapus').on('click', function() {
        let id = $('#delete-id').val();

        $.ajax({
            url: "proses.php",
            type: "POST",
            data: { aksi: 'hapus', id: id },
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    $('#hapusModal').modal('hide');
                    tabelAnggota.ajax.reload(null, false);
                    alert('Data berhasil dihapus!');
                } else {
                    alert('Gagal: ' + response.message);
                }
            },
            error: function(xhr) {
                 alert('Terjadi kesalahan server: ' + xhr.responseJSON.error);
            }
        });
    });
});
</script>
</body>
</html>