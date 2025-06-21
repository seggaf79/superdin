<?php
require_once '../../config/init.php';
require_login();

$username = $_SESSION['user']['nama'];

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

            <!-- Grafik -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-4 rounded-xl shadow">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Grafik SPPD per Bulan</h2>
                    <canvas id="sppdChart" class="w-full h-64"></canvas>
                </div>
                <div class="bg-white p-4 rounded-xl shadow">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Grafik Dummy Pegawai</h2>
                    <canvas id="pegawaiChart" class="w-full h-64"></canvas>
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
            legend: { display: false }
        }
    }
});

const pegawaiChart = new Chart(document.getElementById('pegawaiChart'), {
    type: 'doughnut',
    data: {
        labels: ["Tidak Dibedakan"],
        datasets: [{
            label: 'Jumlah Pegawai',
            data: [<?= $jumlah_pegawai ?>],
            backgroundColor: ['#16A34A']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>
