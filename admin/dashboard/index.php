<?php
require_once '../../config/init.php';
require_login();

$username = $_SESSION['user']['nama'];

// Set zona waktu & tanggal hari ini
date_default_timezone_set('Asia/Makassar');
$today = date('Y-m-d');

$sql = "
SELECT p.nama, s.tujuan, s.maksud, s.tgl_pulang
FROM sppd s
JOIN pegawai p ON s.pegawai_id = p.id
WHERE s.tgl_berangkat <= :today AND s.tgl_pulang >= :today
ORDER BY s.tgl_pulang ASC
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['today' => $today]);
$dinas_luar = $stmt->fetchAll();

// Statistik
$jumlah_pegawai = $pdo->query("SELECT COUNT(*) FROM pegawai")->fetchColumn();
$jumlah_sppd = $pdo->query("SELECT COUNT(*) FROM sppd")->fetchColumn();
$jumlah_user = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

// Data grafik SPPD per bulan
$bulanData = $pdo->query("
    SELECT MONTH(tgl_input) as bulan, COUNT(*) as jumlah 
    FROM sppd 
    GROUP BY MONTH(tgl_input)
")->fetchAll(PDO::FETCH_KEY_PAIR);

$grafik_sppd = [];
for ($i = 1; $i <= 12; $i++) {
    $grafik_sppd[] = isset($bulanData[$i]) ? (int)$bulanData[$i] : 0;
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
    <?php include '../partials/sidebar.php'; ?>

    <div class="flex flex-col min-h-screen w-full">
        <main class="flex-grow p-4 space-y-6">
            <h1 class="text-xl md:text-2xl font-bold text-gray-700">Selamat Datang, <?= e($username) ?></h1>

            <!-- Tile Statistik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-blue-600 text-white p-5 rounded-xl shadow flex flex-col items-center justify-center">
                    <div class="text-sm">Jumlah Pegawai</div>
                    <div class="text-3xl font-bold"><?= $jumlah_pegawai ?></div>
                </div>
                <div class="bg-green-600 text-white p-5 rounded-xl shadow flex flex-col items-center justify-center">
                    <div class="text-sm">Jumlah SPPD</div>
                    <div class="text-3xl font-bold"><?= $jumlah_sppd ?></div>
                </div>
                <div class="bg-yellow-500 text-white p-5 rounded-xl shadow flex flex-col items-center justify-center">
                    <div class="text-sm">Jumlah User</div>
                    <div class="text-3xl font-bold"><?= $jumlah_user ?></div>
                </div>
            </div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
  <?php if (count($dinas_luar) > 0): ?>
    <?php foreach ($dinas_luar as $row): ?>
      <div class="bg-gradient-to-br from-yellow-100 via-pink-100 to-blue-100 rounded-2xl shadow-lg p-4">
        <div class="flex items-center mb-3">
          <div class="text-white bg-orange-500 p-2 rounded-full">
            <!-- Icon Pegawai -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 20h5v-2a3 3 0 00-3-3h-4a4 4 0 00-4-4H5a3 3 0 00-3 3v2h5M9 7a4 4 0 118 0 4 4 0 01-8 0z" />
            </svg>
          </div>
          <div class="ml-3">
            <h2 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($row['nama']) ?></h2>
            <span class="text-xs text-gray-600 bg-blue-100 text-blue-800 px-2 py-1 rounded-full">Sedang Dinas Luar</span>
          </div>
        </div>
        <p class="text-sm text-gray-700 mb-1"><strong>Tujuan:</strong> <?= htmlspecialchars($row['tujuan']) ?></p>
        <p class="text-sm text-gray-700 mb-1"><strong>Maksud:</strong> <?= htmlspecialchars($row['maksud']) ?></p>
        <p class="text-sm text-gray-700"><strong>Sampai:</strong> <?= date('d M Y', strtotime($row['tgl_pulang'])) ?></p>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="col-span-3 text-center text-gray-500 italic">Tidak ada pegawai yang sedang dinas luar hari ini.</div>
  <?php endif; ?>
</div>

            <!-- Grafik -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-4 rounded-xl shadow">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Grafik SPPD per Bulan</h2>
                    <canvas id="sppdChart" class="w-full h-64"></canvas>
                </div>
                <div class="bg-white p-4 rounded-xl shadow">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Jumlah Pegawai</h2>
                    <canvas id="grafikPegawai" class="w-full h-64"></canvas>
                </div>
            </div>
        </main>

        <?php include '../partials/footer.php'; ?>
    </div>
</div>

<script>
const sppdChart = new Chart(document.getElementById('sppdChart'), {
    type: 'bar',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [{
            label: 'SPPD Bulanan',
            data: <?= json_encode($grafik_sppd) ?>,
            backgroundColor: 'rgba(59, 130, 246, 0.7)'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true }
        }
    }
});

  const ctx = document.getElementById('grafikPegawai').getContext('2d');

  const data = {
    labels: ['Laki-laki', 'Perempuan'],
    datasets: [{
      label: 'Jumlah Pegawai',
      data: [19, 7],
      backgroundColor: ['#4e73df', '#f6c23e'],
      borderWidth: 1
    }]
  };

  const config = {
    type: 'pie',
    data: data,
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: 'Grafik Jumlah Pegawai DKIP Bulungan'
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              const total = context.dataset.data.reduce((a, b) => a + b, 0);
              const value = context.raw;
              const percent = ((value / total) * 100).toFixed(1);
              return `${context.label}: ${value} orang (${percent}%)`;
            }
          }
        }
      }
    }
  };

  new Chart(ctx, config);
</script>
