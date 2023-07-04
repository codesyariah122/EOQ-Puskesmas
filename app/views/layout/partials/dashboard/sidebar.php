

<aside id="default-sidebar" class="fixed <?=!$is_mobile ? 'top-20' : 'top-0'?> left-0 z-40 w-64 h-screen transition-transform shadow-md box-shadow-md -translate-x-full sm:translate-x-0" aria-label="Sidebar">
   <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
      <ul class="space-y-2 font-medium">
         <li>
            <a href="/dashboard/<?=$_SESSION['role']?>" class="flex items-center p-2 <?=$page === 'admin' ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 '?> rounded-lg">
               <i class="fa-solid fa-gauge"></i>
               <span class="ml-3">Dashboard</span>
            </a>
         </li>
         <li>
            <a href="/dashboard/data-user" class="flex items-center p-2 <?=$page === 'data-user' ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 '?> rounded-lg">
               <i class="fa-solid fa-users"></i>
               <span class="flex-1 ml-3 whitespace-nowrap">Data Pengguna</span>
            </a>
         </li>
         <li>
            <a href="/dashboard/data-obat" class="flex items-center p-2 <?=$page === 'data-obat' ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 '?> rounded-lg">
               <i class="fa-solid fa-box"></i>
               <span class="flex-1 ml-3 whitespace-nowrap">Persedian Data Obat</span>
            </a>
         </li>
         <li>
            <a href="/dashboard/pengajuan-obat" class="flex items-center p-2 <?=$page === 'pengajuan-obat' ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 '?> rounded-lg">
               <i class="fa-solid fa-house-medical-circle-check"></i>
               <span class="flex-1 ml-3 whitespace-nowrap">Pengajuan Obat</span>
            </a>
         </li>
         <li>
            <a href="/dashboard/laporan-eoq" class="flex items-center p-2 <?=$page === 'laporan-eoq' ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 '?> rounded-lg">
               <i class="fa-solid fa-calculator"></i>
               <span class="flex-1 ml-3 whitespace-nowrap">Laporan Analisa EOQ</span>
            </a>
         </li>
         <li>
            <a href="/dashboard/pembelian" class="flex items-center p-2 <?=$page === 'pembelian' ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 '?> rounded-lg">
               <i class="fa-solid fa-cubes"></i>
               <span class="flex-1 ml-3 whitespace-nowrap">Kelola Pembelian</span>
            </a>
         </li>
         <li>
            <a href="/dashboard/laporan-pembelian" class="flex items-center p-2 <?=$page === 'laporan-pembelian' ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 '?> rounded-lg">
               <i class="fa-solid fa-database"></i>
               <span class="flex-1 ml-3 whitespace-nowrap">Laporan Pembelian</span>
            </a>
         </li>
      </ul>
   </div>
</aside>