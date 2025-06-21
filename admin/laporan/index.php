<?php
require_once '../../config/init.php';
require_login();

$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$bidang = isset($_GET['bidang']) ? $_GET['bidang'] : '';

// Ambil daftar tahun unik
$tahunList = $pdo->query("SELECT DISTINCT YEAR(tgl_input) AS tahun FROM sppd ORDER BY tahun DESC")->fetchAll(PDO::FETCH_COLUMN);

// Ambil daftar bidang
$bidangList = $pdo->query("SELECT DISTINCT bidang FROM rekening ORDER BY bidang ASC")->fetchAll(PDO::FETCH_COLUMN);

// Query data utama
$sql = "SELECT sppd.*, pegawai.nama, rekening.bidang 
        FROM sppd 
        LEFT JOIN pegawai ON sppd.pegawai_id = pegawai.id
        LEFT JOIN rekening ON sppd.rekening_id = rekening.id
        WHERE YEAR(sppd.tgl_input) = :tahun";

$params = [':tahun' => $tahun];

if (!empty($bulan)) {
    $sql .= " AND MONTH(sppd.tgl_input) = :bulan";
    $params[':bulan'] = $bulan;
}
if (!empty($bidang)) {
    $sql .= " AND rekening.bidang = :bidang";
    $params[':bidang'] = $bidang;
}

$sql .= " ORDER BY sppd.tgl_input DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
<?php include '../partials/sidebar.php'; ?>
<div class="flex flex-col min-h-screen w-full">

<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Laporan SPPD</h1>

    <form method="GET" class="flex flex-wrap gap-4 mb-4 items-end">
        <div>
            <label class="block text-sm">Tahun</label>
            <select name="tahun" class="border px-2 py-1 rounded">
                <?php foreach ($tahunList as $t): ?>
                    <option value="<?= $t ?>" <?= $t == $tahun ? 'selected' : '' ?>><?= $t ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block text-sm">Bulan</label>
            <select name="bulan" class="border px-2 py-1 rounded">
                <option value="">Semua</option>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= $i ?>" <?= $i == $bulan ? 'selected' : '' ?>>
                        <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

        <div>
            <label class="block text-sm">Bidang</label>
            <select name="bidang" class="border px-2 py-1 rounded">
                <option value="">Semua</option>
                <?php foreach ($bidangList as $b): ?>
                    <option value="<?= e($b) ?>" <?= $b == $bidang ? 'selected' : '' ?>><?= e($b) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex gap-2 mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
            <a href="export_pdf.php?tahun=<?= $tahun ?>&bulan=<?= $bulan ?>&bidang=<?= $bidang ?>" class="bg-purple-600 text-white px-4 py-2 rounded">Export PDF</a>
            <a href="export_excel.php?tahun=<?= $tahun ?>&bulan=<?= $bulan ?>&bidang=<?= $bidang ?>" class="bg-green-600 text-white px-4 py-2 rounded">Export Excel</a>
            <a href="print.php?tahun=<?= $tahun ?>&bulan=<?= $bulan ?>&bidang=<?= $bidang ?>" target="_blank" class="bg-gray-700 text-white px-4 py-2 rounded">Print</a>
        </div>
    </form>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-blue-100 dark:text-blue-100">
            <thead class="text-xs text-white uppercase bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 dark:text-white">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Bidang</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Tujuan</th>
                    <th class="px-4 py-2 border">Tanggal Pergi</th>
                    <th class="px-4 py-2 border">Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 font-medium text-gray-900 whitespace-nowrap dark:text-white hover:bg-gray-50">
                <?php $no = 1; foreach ($results as $row): ?>
                <tr>
                    <td class="px-4 py-2 border"><?= $no++ ?></td>
                    <td class="px-4 py-2 border"><?= e($row['bidang']) ?></td>
                    <td class="px-4 py-2 border"><?= e($row['nama']) ?></td>
                    <td class="px-4 py-2 border"><?= e($row['tujuan']) ?></td>
                    <td class="px-4 py-2 border"><?= e($row['tgl_berangkat']) ?></td>
                    <td class="px-4 py-2 border"><?= e($row['tgl_input']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
</div>
</div>