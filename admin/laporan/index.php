<?php
require_once '../../config/init.php';

// Ambil data filter
$filter_bidang = $_GET['bidang'] ?? '';
$filter_bulan = $_GET['bulan'] ?? '';
$filter_tahun = $_GET['tahun'] ?? '';
$filter_pegawai = $_GET['pegawai'] ?? '';

// Ambil daftar pegawai
$pegawai_stmt = $conn->query("SELECT id, nama FROM pegawai ORDER BY nama ASC");
$daftar_pegawai = $pegawai_stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil daftar bidang
$bidang_stmt = $conn->query("SELECT DISTINCT bidang FROM rekening ORDER BY bidang ASC");
$daftar_bidang = $bidang_stmt->fetchAll(PDO::FETCH_ASSOC);

// Query data SPPD dengan filter
$where = [];
$params = [];

if ($filter_bidang) {
    $where[] = "rekening.bidang = :bidang";
    $params[':bidang'] = $filter_bidang;
}
if ($filter_bulan) {
    $where[] = "MONTH(sppd.tgl_berangkat) = :bulan";
    $params[':bulan'] = $filter_bulan;
}
if ($filter_tahun) {
    $where[] = "YEAR(sppd.tgl_berangkat) = :tahun";
    $params[':tahun'] = $filter_tahun;
}
if ($filter_pegawai) {
    $where[] = "pegawai.id = :pegawai";
    $params[':pegawai'] = $filter_pegawai;
}

$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT sppd.*, pegawai.nama AS nama_pegawai, rekening.bidang 
        FROM sppd
        JOIN pegawai ON sppd.pegawai_id = pegawai.id
        JOIN rekening ON sppd.rekening_id = rekening.id
        $whereSQL
        ORDER BY sppd.tgl_input DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
<?php include '../partials/sidebar.php'; ?>
<div class="flex flex-col min-h-screen w-full">

<div class="p-4 sm:ml-10">
    <div class="p-4 border-gray-200 border-dashed rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Laporan SPPD</h1>

        <form method="get" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <select name="bidang" class="p-2 border rounded">
                <option value="">Semua Bidang</option>
                <?php foreach ($daftar_bidang as $b): ?>
                    <option value="<?= $b['bidang'] ?>" <?= ($filter_bidang == $b['bidang']) ? 'selected' : '' ?>>
                        <?= $b['bidang'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="bulan" class="p-2 border rounded">
                <option value="">Semua Bulan</option>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= $i ?>" <?= ($filter_bulan == $i) ? 'selected' : '' ?>>
                        <?= date('F', mktime(0, 0, 0, $i, 10)) ?>
                    </option>
                <?php endfor; ?>
            </select>

            <select name="tahun" class="p-2 border rounded">
                <option value="">Semua Tahun</option>
                <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                    <option value="<?= $y ?>" <?= ($filter_tahun == $y) ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>

            <select name="pegawai" class="p-2 border rounded">
                <option value="">Semua Pegawai</option>
                <?php foreach ($daftar_pegawai as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= ($filter_pegawai == $p['id']) ? 'selected' : '' ?>>
                        <?= $p['nama'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="col-span-1 md:col-span-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
                <a href="export_pdf.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>&bidang=<?= $bidang ?>&pegawai=<?= $pegawai ?>" target="_blank" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Export PDF</a>
                <a href="export_excel.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>&bidang=<?= $bidang ?>&pegawai=<?= $pegawai ?>" class="btn btn-success" target="_blank">Export Excel</a>
            </div>
        </form>

        <div class="overflow-auto">
            <table class="min-w-full bg-white border rounded-lg shadow">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Bidang</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Tujuan</th>
                        <th class="px-4 py-2">Tanggal Pergi</th>
                        <th class="px-4 py-2">Tanggal Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $i => $row): ?>
                        <tr class="border-t">
                            <td class="px-4 py-2"><?= $i + 1 ?></td>
                            <td class="px-4 py-2"><?= $row['bidang'] ?></td>
                            <td class="px-4 py-2"><?= $row['nama_pegawai'] ?></td>
                            <td class="px-4 py-2"><?= $row['tujuan'] ?></td>
                            <td class="px-4 py-2"><?= date('d/m/Y', strtotime($row['tgl_berangkat'])) ?></td>
                            <td class="px-4 py-2"><?= date('d/m/Y', strtotime($row['tgl_input'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (count($data) === 0): ?>
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">Data tidak ditemukan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
</div>
</div>