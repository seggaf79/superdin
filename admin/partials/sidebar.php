<aside class="w-64 bg-gradient-to-b from-blue-500 to-blue-800 text-white min-h-screen">
        <nav class="p-4 space-y-4 text-sm">
        <div>
            <p class="uppercase text-xs text-gray-300 mb-2">Dashboard</p>
            <a href="../dashboard/index.php" class="flex items-center gap-2 p-2 rounded hover:bg-white hover:text-blue-700 transition-all <?= basename(dirname($_SERVER['PHP_SELF'])) == 'dashboard' ? 'bg-white text-blue-700' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m-4 4h16" />
                </svg>
                Dashboard
            </a>
        </div>

        <div>
            <p class="uppercase text-xs text-gray-300 mb-2">Modul SPPD</p>
            <a href="../sppd/index.php" class="block p-2 rounded hover:bg-white hover:text-blue-700 transition-all <?= basename(dirname($_SERVER['PHP_SELF'])) == 'sppd' ? 'bg-white text-blue-700' : '' ?>">SPPD</a>
            <a href="../laporan/index.php" class="block p-2 rounded hover:bg-white hover:text-blue-700 transition-all <?= basename(dirname($_SERVER['PHP_SELF'])) == 'laporan' ? 'bg-white text-blue-700' : '' ?>">Laporan</a>
        </div>

        <div>
            <p class="uppercase text-xs text-gray-300 mb-2">Master Data</p>
            <a href="../pegawai/index.php" class="block p-2 rounded hover:bg-white hover:text-blue-700 transition-all <?= basename(dirname($_SERVER['PHP_SELF'])) == 'pegawai' ? 'bg-white text-blue-700' : '' ?>">Pegawai</a>
            <a href="../pejabat/index.php" class="block p-2 rounded hover:bg-white hover:text-blue-700 transition-all <?= basename(dirname($_SERVER['PHP_SELF'])) == 'pejabat' ? 'bg-white text-blue-700' : '' ?>">Pejabat</a>
            <a href="../rekening/index.php" class="block p-2 rounded hover:bg-white hover:text-blue-700 transition-all <?= basename(dirname($_SERVER['PHP_SELF'])) == 'rekening' ? 'bg-white text-blue-700' : '' ?>">Rekening</a>
            <a href="../users/index.php" class="block p-2 rounded hover:bg-white hover:text-blue-700 transition-all <?= basename(dirname($_SERVER['PHP_SELF'])) == 'users' ? 'bg-white text-blue-700' : '' ?>">Manajemen User</a>
            <a href="../setting/index.php" class="block p-2 rounded hover:bg-white hover:text-blue-700 transition-all <?= basename(dirname($_SERVER['PHP_SELF'])) == 'setting' ? 'bg-white text-blue-700' : '' ?>">Pengaturan</a>
        </div>

        <div>
            <p class="uppercase text-xs text-gray-300 mb-2">Auth</p>
            <a href="../logout.php" class="block p-2 rounded hover:bg-white hover:text-blue-700 transition-all">Keluar</a>
        </div>
    
        <img src="../../assets/images/logodkipwhite.png" alt="Logo DKIP Bulungan" class="fixed bottom-5 left-5 h-14 ml-7 mr-5 mb-3">
    </nav>

</aside>