<?php
require_once '../../config/init.php';

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

    // Hitung lama hari (inklusi tgl berangkat dan tgl pulang)
    $start = new DateTime($tgl_berangkat);
    $end = new DateTime($tgl_pulang);
    $lama_hari = $start->diff($end)->days + 1;

    $stmt = $pdo->prepare("INSERT INTO sppd 
        (no_surat, pegawai_id, maksud, transportasi, tujuan, tgl_berangkat, tgl_pulang, lama_hari, rekening_id, pejabat_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $no_surat, $pegawai_id, $maksud, $transportasi, $tujuan,
        $tgl_berangkat, $tgl_pulang, $lama_hari, $rekening_id, $pejabat_id
    ]);

    header('Location: index.php');
    exit;
}

$pegawai = $pdo->query("SELECT * FROM pegawai")->fetchAll();
$rekening = $pdo->query("SELECT * FROM rekening")->fetchAll();
$pejabat = $pdo->query("SELECT * FROM pejabat")->fetchAll();
?>


<?php include '../partials/header.php'; ?>
<div class="flex">
  <?php include '../partials/sidebar.php'; ?>

  <div class="flex flex-col min-h-screen w-full">
<main class="p-6 sm:ml-64 min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Tambah SPPD</h2>
        <form method="POST">
            <label class="block mb-2">No Surat</label>
            <input type="text" name="no_surat" class="w-full border px-3 py-2 rounded mb-4" required>

            <label class="block mb-2">Nama Pegawai</label>
            <select name="pegawai_id" class="w-full border px-3 py-2 rounded mb-4" required>
                <option value="">-- Pilih Pegawai --</option>
                <?php foreach ($pegawai as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= $p['nama'] ?></option>
                <?php endforeach; ?>
            </select>

            <label class="block mb-2">Maksud</label>
            <textarea name="maksud" class="w-full border px-3 py-2 rounded mb-4" required></textarea>

            <label class="block mb-2">Transportasi</label>
            <select name="transportasi" class="w-full border px-3 py-2 rounded mb-4" required>
                <option value="">-- Pilih Transportasi --</option>
                <option value="Darat">Darat</option>
                <option value="Darat / Laut">Darat / Laut</option>
                <option value="Darat / Laut / Udara">Darat / Laut / Udara</option>
                <option value="Sungai">Sungai</option>
            </select>

            <label class="block mb-2">Tujuan</label>
            <input type="text" name="tujuan" class="w-full border px-3 py-2 rounded mb-4" required>

            <label class="block mb-2">Tanggal Berangkat</label>
            <input type="date" name="tgl_berangkat" class="w-full border px-3 py-2 rounded mb-4" required>

            <label class="block mb-2">Tanggal Pulang</label>
            <input type="date" name="tgl_pulang" class="w-full border px-3 py-2 rounded mb-4" required>

            <label class="block mb-2">Rekening</label>
            <select name="rekening_id" class="w-full border px-3 py-2 rounded mb-4" required>
                <option value="">-- Pilih Rekening --</option>
                <?php foreach ($rekening as $r): ?>
                    <option value="<?= $r['id'] ?>"><?= $r['bidang'] ?></option>
                <?php endforeach; ?>
            </select>

            <label class="block mb-2">Pejabat</label>
            <select name="pejabat_id" class="w-full border px-3 py-2 rounded mb-4" required>
                <option value="">-- Pilih Pejabat --</option>
                <?php foreach ($pejabat as $pj): ?>
                    <option value="<?= $pj['id'] ?>"><?= $pj['nama'] ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
                </main>
<?php include '../partials/footer.php'; ?>
</div>
</div>

