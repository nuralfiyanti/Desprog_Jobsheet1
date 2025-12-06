<?php
include('koneksi.php');

// DataTables Server Side Processing
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$search = $_POST['search']['value'];
$order_column_index = $_POST['order'][0]['column'];
$order_dir = $_POST['order'][0]['dir'];

$columns = array(
    0 => 'id',
    1 => 'nama',
    2 => 'jenis_kelamin',
    3 => 'alamat',
    4 => 'no_telp',
    5 => 'id'
);

$order_by = $columns[$order_column_index];

$query_total = "SELECT count(*) as total FROM anggota";
$result_total = $db1->query($query_total);
$row_total = $result_total->fetch_assoc();
$totalData = $row_total['total'];
$totalFiltered = $totalData;

$sql = "SELECT * FROM anggota WHERE 1=1";

if (!empty($search)) {
    $search = $db1->real_escape_string($search);
    $sql .= " AND (nama LIKE '%$search%' 
        OR alamat LIKE '%$search%' 
        OR no_telp LIKE '%$search%')";
    $result_filtered = $db1->query($sql);
    $totalFiltered = $result_filtered->num_rows;
}

$sql .= " ORDER BY $order_by $order_dir LIMIT $start, $length";
$result = $db1->query($sql);

$data = array();
$no = $start + 1;

while ($row = $result->fetch_assoc()) {
    $kelamin_text = ($row["jenis_kelamin"] == "L") ? "Laki-Laki" : "Perempuan";

    $aksi = '
        <button id="' . $row['id'] . '" class="btn btn-success btn-sm edit_data">
            <i class="fa fa-edit"></i> Edit
        </button>
        <button id="' . $row['id'] . '" class="btn btn-danger btn-sm hapus_data">
            <i class="fa fa-trash"></i> Hapus
        </button>';

    $nestedData = array();
    $nestedData['no'] = $no++;
    $nestedData['id'] = $row['id'];
    $nestedData['nama'] = $row['nama'];
    $nestedData['jenis_kelamin'] = $kelamin_text;
    $nestedData['alamat'] = $row['alamat'];
    $nestedData['no_telp'] = $row['no_telp'];
    $nestedData['aksi'] = $aksi;

    $data[] = $nestedData;
}

$json_data = array(
    "draw" => intval($draw),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
);

header('Content-Type: application/json');
echo json_encode($json_data);
?>
