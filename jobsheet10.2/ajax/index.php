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
                        <input type="text" id="nama" name="nama" class="form-control">
                        <p class="text-danger" id="err_nama"></p>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Jenis Kelamin:</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="L">
                            <label class="form-check-label" for="laki">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="P">
                            <label class="form-check-label" for="perempuan">Perempuan</label>
                        </div>
                        <p class="text-danger" id="err_jenis_kelamin"></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <input type="text" id="alamat" name="alamat" class="form-control">
                    <p class="text-danger" id="err_alamat"></p>
                </div>
                
                <div class="form-group">
                    <label for="no_telp">No. Telp:</label>
                    <input type="text" id="no_telp" name="no_telp" class="form-control">
                    <p class="text-danger" id="err_no_telp"></p>
                </div>

                <input type="hidden" name="aksi" id="aksi" value="tambah">
                <input type="hidden" name="id" id="id">

                <hr>
                
                <div class="form-group text-right">
                    <button type="button" id="btn-simpan" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
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
            "url": "data.php",
            "type": "POST"
        },
        "columns": [
            {"data": "no", "orderable": false, "searchable": false},
            {"data": "nama"},
            {"data": "jenis_kelamin"},
            {"data": "alamat"},
            {"data": "no_telp"},
            {"data": "aksi", "orderable": false, "searchable": false}
        ]
    });

    // Fungsi Reset Pesan Error
    function resetErrors() {
        $("#err_nama").html("");
        $("#err_jenis_kelamin").html("");
        $("#err_alamat").html("");
        $("#err_no_telp").html("");
    }

    // Fungsi Reset Form & UI ke mode Tambah
    function resetFormUI() {
        $('#form-anggota')[0].reset();
        $('#aksi').val('tambah'); 
        $('#id').val(''); // Pastikan ID dikosongkan
        $('#btn-simpan').html('<i class="fa fa-save"></i> Simpan');
        $('#btn-reset').addClass('d-none');
        resetErrors(); // Bersihkan pesan error saat batal
    }


    // 2. LOGIKA CREATE & UPDATE (TOMBOL SIMPAN / UPDATE)
    $("#btn-simpan").click(function(e) {
        e.preventDefault(); 
        resetErrors(); 

        let nama = $("#nama").val().trim();
        let alamat = $("#alamat").val().trim();
        let no_telp = $("#no_telp").val().trim();
        let is_jenkel_checked = $("#laki").is(":checked") || $("#perempuan").is(":checked");
        let aksiUrl = $('#aksi').val(); // 'tambah' atau 'edit'
        
        let isValid = true;

        // Validasi
        if (nama === "") {
            $("#err_nama").html("Nama Harus Diisi");
            isValid = false;
        }
        if (alamat === "") {
            $("#err_alamat").html("Alamat Harus Diisi");
            isValid = false;
        }
        if (no_telp === "") {
            $("#err_no_telp").html("No Telepon Harus Diisi");
            isValid = false;
        }
        if (!is_jenkel_checked) {
            $("#err_jenis_kelamin").html("Jenis Kelamin Harus Dipilih");
            isValid = false;
        }

        // Jika validasi sukses, kirim AJAX
        if (isValid) {
            let dataForm = $('#form-anggota').serialize(); 

            $.ajax({
                type: 'POST',
                url: "form_action.php", // File yang menangani CREATE dan UPDATE
                data: dataForm,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        resetFormUI(); // Reset form dan UI ke mode 'tambah'
                        tabelAnggota.ajax.reload(null, false);
                        alert((aksiUrl == 'tambah' ? 'Data berhasil ditambahkan!' : 'Data berhasil diupdate!'));
                    } else {
                         alert('Gagal: ' + response.message);
                    }
                },
                error: function (xhr) {
                    alert('Terjadi kesalahan server: ' + (xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Terjadi Kesalahan!'));
                }
            });
        }
    });

    // 3. LOGIKA GET DATA UNTUK EDIT
    $('#example tbody').on('click', '.edit_data', function() {
        // Pindah ke atas form
        $('html, body').animate({ scrollTop: 0}, 'slow');
        
        let id = $(this).attr('id'); 
        
        $.ajax({
            url: "get_data.php", // Menggunakan get_data.php
            type: "POST", 
            data: { id: id },
            dataType: "json",
            success: function(data) {
                resetErrors(); 
                
                // Isi form dengan data yang didapatkan
                $('#id').val(data.id);
                $('#nama').val(data.nama);
                // Menentukan radio button
                if (data.jenis_kelamin === 'L') {
                    $('#laki').prop('checked', true);
                } else {
                    $('#perempuan').prop('checked', true);
                }
                $('#alamat').val(data.alamat);
                $('#no_telp').val(data.no_telp);
                
                // Ubah status form menjadi EDIT
                $('#aksi').val('edit');
                $('#btn-simpan').html('<i class="fa fa-edit"></i> Update');
                $('#btn-reset').removeClass('d-none');
            },
            error: function(xhr) {
                alert('Gagal mengambil data untuk edit.');
            }
        });
    });

    // Tombol Batal Edit
    $('#btn-reset').on('click', function() {
        resetFormUI();
    });

    // 4. LOGIKA DELETE 
    $('#example tbody').on('click', '.hapus_data', function() {
        let id = $(this).attr('id');

        if(confirm("Apakah Anda yakin ingin menghapus data ini?")) {
            $.ajax({
                url: "hapus_data.php", 
                type: "POST",
                data: { id: id },
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        tabelAnggota.ajax.reload(null, false);
                        alert('Data berhasil dihapus!');
                    } else {
                        alert('Gagal: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan server saat menghapus data.');
                }
            });
        }
    });
});

$(document).on('click', '.hapus_data', function() {
    var id = $(this).attr('id');

    if (!confirm("Yakin ingin menghapus data ini?")) return;

    $.ajax({
        type: 'POST',
        url: "hapus_data.php",
        data: { id: id },
        success: function(response) {
            $('#example').DataTable().ajax.reload(); // refresh tabel
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
});
</script>
</body>
</html>