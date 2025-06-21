<?php
require_once '../../config/init.php';
require_login();

$id = $_GET['id'] ?? null;
if (!$id) {
    set_flash("ID tidak ditemukan.");
    header("Location: index.php");
    exit;
}

// Ambil data pegawai, pejabat, dan rekening
$pegawai = $pdo->query("SELECT * FROM pegawai")->fetchAll(PDO::FETCH_ASSOC);
$pejabat = $pdo->query("SELECT * FROM pejabat")->fetchAll(PDO::FETCH_ASSOC);
$rekening = $pdo->query("SELECT * FROM rekening")->fetchAll(PDO::FETCH_ASSOC);

// Ambil data SPPD
$stmt = $pdo->prepare("SELECT * FROM sppd WHERE id = ?");
$stmt->execute([$id]);
$sppd = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$sppd) {
    set_flash("Data tidak ditemukan.");
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_surat = $_POST['no_surat'];
    $pegawai_id = $_POST['pegawai_id'];
    $maksud = $_POST['maksud'];
    $transportasi = $_POST['transportasi'];
    $tujuan = $_POST['tujuan'];
    $tgl_berangkat = $_POST['tgl_berangkat'];
    $tgl_pulang = $_POST['tgl_pulang'];
    $rekening_id = $_POST['rekening_id'];
    $pejabat_id = $_POST['pejabat_id'];
    $lama_hari = $_POST['lama_hari'];

    $update = $pdo->prepare("UPDATE sppd SET 
        no_surat = ?, pegawai_id = ?, maksud = ?, transportasi = ?, 
        tujuan = ?, tgl_berangkat = ?, tgl_pulang = ?, 
        rekening_id = ?, pejabat_id = ?, lama_hari= ?
        WHERE id = ?");
    $update->execute([
        $no_surat, $pegawai_id, $maksud, $transportasi,
        $tujuan, $tgl_berangkat, $tgl_pulang,
        $rekening_id, $pejabat_id, $lama_hari, $id
    ]);

    set_flash("Data berhasil diperbarui.");
    header("Location: index.php");
    exit;
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
  <?php include '../partials/sidebar.php'; ?>

  <div class="flex flex-col min-h-screen w-full">


<main class="p-6 sm:ml-64 min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Edit Data SPPD</h2>
        <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label>Nomor Surat Tugas</label>
                <input type="text" name="no_surat" value="<?= $sppd['no_surat'] ?>" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label>Nama Pegawai</label>
                <select name="pegawai_id" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih --</option>
                    <?php foreach ($pegawai as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= $p['id'] == $sppd['pegawai_id'] ? 'selected' : '' ?>>
                            <?= $p['nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="md:col-span-2">
                <label>Maksud</label>
                <textarea name="maksud" class="w-full border rounded p-2" required><?= $sppd['maksud'] ?></textarea>
            </div>

            <div>
                <label>Transportasi</label>
                <select name="transportasi" class="w-full border rounded p-2" required>
                    <?php foreach (['Darat','Darat / Laut','Darat / Laut / Udara','Sungai'] as $opsi): ?>
                        <option value="<?= $opsi ?>" <?= $sppd['transportasi'] == $opsi ? 'selected' : '' ?>><?= $opsi ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label>Tujuan</label>
                <input type="text" name="tujuan" value="<?= $sppd['tujuan'] ?>" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label>Tanggal Berangkat</label>
                <input type="date" name="tgl_berangkat" value="<?= $sppd['tgl_berangkat'] ?>" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label>Tanggal Pulang</label>
                <input type="date" name="tgl_pulang" value="<?= $sppd['tgl_pulang'] ?>" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label>Bidang / Rekening</label>
                <select name="rekening_id" class="w-full border rounded p-2" required>
                    <?php foreach ($rekening as $r): ?>
                        <option value="<?= $r['id'] ?>" <?= $r['id'] == $sppd['rekening_id'] ? 'selected' : '' ?>>
                            <?= $r['bidang'] ?> - <?= $r['kode_rekening'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label>Penandatangan</label>
                <select name="pejabat_id" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih Pejabat --</option>
                    <?php foreach ($pejabat as $pj): ?>
                        <option value="<?= $pj['id'] ?>" <?= $pj['id'] == $sppd['pejabat_id'] ? 'selected' : '' ?>>
                            <?= $pj['nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label>Lama Hari</label>
                <input type="text" name="lama_hari" value="<?= $sppd['lama_hari'] ?>" class="w-full border rounded p-2" required>
            </div>

            <div class="md:col-span-2 text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</main>

<?php include '../partials/footer.php'; ?>
 </div>
</div>