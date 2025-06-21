<?php
require_once '../../config/init.php';

require_login();

$pegawai = $pdo->query("SELECT id, nama FROM pegawai ORDER BY nama ASC")->fetchAll();
$rekening = $pdo->query("SELECT id, bidang FROM rekening ORDER BY bidang ASC")->fetchAll();
$pejabat = $pdo->query("SELECT id, nama FROM pejabat ORDER BY nama ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO sppd 
        (no_surat, pegawai_id, maksud, transportasi, tujuan, tgl_berangkat, tgl_pulang, rekening_id, pejabat_id, lama_hari) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['no_surat'],
        $_POST['pegawai_id'],
        $_POST['maksud'],
        $_POST['transportasi'],
        $_POST['tujuan'],
        $_POST['tgl_berangkat'],
        $_POST['tgl_pulang'],
        $_POST['rekening_id'],
        $_POST['pejabat_id'],
        $_POST['lama_hari'],
    ]);

    set_flash('Berhasil menambahkan SPPD');
    header('Location: index.php');
    exit;
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
  <?php include '../partials/sidebar.php'; ?>

  <div class="flex flex-col min-h-screen w-full">
    <main class="flex-grow p-6">
      <h1 class="text-xl font-bold mb-4 text-gray-700">Tambah SPPD</h1>

      <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-6 rounded shadow">
        <div>
          <label class="block font-medium mb-1">Nomor Surat Tugas</label>
          <input type="text" name="no_surat" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
          <label class="block font-medium mb-1">Nama Pegawai</label>
          <select name="pegawai_id" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Pilih Pegawai --</option>
            <?php foreach ($pegawai as $p): ?>
              <option value="<?= $p['id'] ?>"><?= $p['nama'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label class="block font-medium mb-1">Maksud</label>
          <textarea name="maksud" class="w-full border rounded px-3 py-2" rows="3"></textarea>
        </div>

        <div>
          <label class="block font-medium mb-1">Transportasi</label>
          <select name="transportasi" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Pilih Transportasi --</option>
            <option value="Darat">Darat</option>
            <option value="Darat / Laut">Darat/Laut</option>
            <option value="Darat / Laut / Udara">Darat/Laut/Udara</option>
            <option value="Sungai">Sungai</option>
          </select>
        </div>

        <div>
          <label class="block font-medium mb-1">Tujuan</label>
          <input type="text" name="tujuan" class="w-full border rounded px-3 py-2">
        </div>

        <div>
          <label class="block font-medium mb-1">Tanggal Berangkat</label>
          <input type="date" name="tgl_berangkat" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
          <label class="block font-medium mb-1">Tanggal Pulang</label>
          <input type="date" name="tgl_pulang" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
          <label class="block font-medium mb-1">Bidang (Rekening)</label>
          <select name="rekening_id" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Pilih Bidang --</option>
            <?php foreach ($rekening as $r): ?>
              <option value="<?= $r['id'] ?>"><?= $r['bidang'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label class="block font-medium mb-1">Pejabat Penandatangan Surat Tugas</label>
          <select name="pejabat_id" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Pilih Pejabat --</option>
            <?php foreach ($pejabat as $pj): ?>
              <option value="<?= $pj['id'] ?>"><?= $pj['nama'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label class="block font-medium mb-1">Lama Hari</label>
          <input type="text" name="lama_hari" class="w-full border rounded px-3 py-2">
        </div>

        <div class="md:col-span-2 flex justify-end">
          <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Simpan
          </button>
        </div>
      </form>
    </main>

    <?php include '../partials/footer.php'; ?>
  </div>
</div>