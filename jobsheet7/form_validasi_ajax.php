<!DOCTYPE html>
<html>
<head>
    <title>Form Input dengan Validasi (AJAX)</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    
    <h1>Form Input dengan Validasi (AJAX)</h1>
    <form id="myForm"> 
        <label for="nama">Nama: </label>
        <input type="text" id="nama" name="nama" value=""> 
        <span id="nama-error" style="color: red;"></span><br><br>
        
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="">
        <span id="email-error" style="color: red;"></span><br><br>
        
        <input type="submit" value="Submit">
    </form>

    <div id="hasil" style="margin-top: 15px; color: green;"></div>

<script>
$(document).ready(function() {
    $("#myForm").submit(function(event) {
        event.preventDefault(); // Mencegah reload halaman

        var nama = $("#nama").val();
        var email = $("#email").val();
        var valid = true;

        // Reset pesan error
        $("#nama-error").text("");
        $("#email-error").text("");
        $("#hasil").text("");

        // Validasi sederhana di sisi client
        if (nama === "") {
            $("#nama-error").text("Nama harus diisi!");
            valid = false;
        }

        if (email === "") {
            $("#email-error").text("Email harus diisi!");
            valid = false;
        }

        if (valid) {
            // Kirim data ke server via AJAX
            $.ajax({
                url: "proses_validasi_ajax.php",
                type: "POST",
                data: { nama: nama, email: email },
                success: function(response) {
                    $("#hasil").html(response);
                }
            });
        }
    });
});
</script>
</body>
</html>
