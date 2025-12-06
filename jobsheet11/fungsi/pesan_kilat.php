<?php
if (!isset($_SESSION)) {
    session_start();
}

function pesan($type, $message)
{
    $_SESSION['_flashdata'][$type] = "
        <div class='alert alert-$type alert-dismissible fade show' role='alert'>
            $message
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
    ";
}

function get_flashdata($type)
{
    if (!empty($_SESSION['_flashdata'][$type])) {
        $pesan = $_SESSION['_flashdata'][$type];
        unset($_SESSION['_flashdata'][$type]);
        return $pesan;
    }
    return '';
}
?>  
