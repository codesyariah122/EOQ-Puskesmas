<aside id="default-sidebar" class="fixed <?= !$is_mobile ? 'top-20' : 'top-0' ?> left-0 z-40 w-64 h-screen transition-transform border-r-4 shadow-lg box-shadow-lg -translate-x-full sm:translate-x-0" aria-label="Sidebar">
   <div class="h-full px-3 py-8 overflow-y-auto bg-gray-50 dark:bg-gray-800">
      <ul class="space-y-2 font-medium">
         <li>
            <a href="/dashboard/<?= $_SESSION['role'] ?>" class="flex items-center p-2 <?= $page === $_SESSION['role'] ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 ' ?> rounded-lg">
               <i class="fa-solid fa-gauge"></i>
               <span class="ml-3">Dashboard</span>
            </a>
         </li>
         <?php if ($_SESSION['role'] !== 'user') : ?>
            <li>
               <a href="/dashboard/data-user" class="flex items-center p-2 <?= $page === 'data-user' ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 ' ?> rounded-lg">
                  <i class="fa-solid fa-users"></i>
                  <span class="flex-1 ml-3 whitespace-nowrap">Data Pengguna</span>
               </a>
            </li>
         <?php endif; ?>
         <li>
            <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
               <i class="fa-solid fa-square-root-variable"></i>
               <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Hitung Kebutuhan</span>
               <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
               </svg>
            </button>
            <ul id="dropdown-example" class="<?php $page === 'kebutuhan-pertahun' || $page === 'biaya' ? 'block' : 'hidden' ?>py-2 space-y-2">
               <li>
                  <a href="/dashboard/kebutuhan-pertahun" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group <?= $page === 'kebutuhan-pertahun' ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 ' ?>">
                     <div class="flex space-x-2">
                        <div>
                           <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div>
                           Kebutuhan Pertahun
                        </div>
                     </div>
                  </a>
               </li>
               <li>
                  <a href="/dashboard/biaya" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group <?= $page === 'biaya' ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 ' ?>">
                     <div class="flex space-x-2">
                        <div>
                           <i class="fa-solid fa-calculator"></i>
                        </div>
                        <div>
                           Biaya
                        </div>
                     </div>
                  </a>
               </li>
            </ul>
         </li>
         <li>
            <a href="/dashboard/data-obat" class="flex items-center p-2 <?= $page === 'data-obat' ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 ' ?> rounded-lg">
               <i class="fa-solid fa-box"></i>
               <span class="flex-1 ml-3 whitespace-nowrap">Persedian Data Obat</span>
            </a>
         </li>
         <li>
            <a href="/dashboard/pengajuan-obat" class="flex items-center p-2 <?= $page === 'pengajuan-obat' ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 ' ?> rounded-lg">
               <i class="fa-solid fa-house-medical-circle-check"></i>
               <span class="flex-1 ml-3 whitespace-nowrap">Pengajuan Obat</span>
            </a>
         </li>
         <li>
            <a href="/dashboard/laporan-eoq" class="flex items-center p-2 <?= $page === 'laporan-eoq' ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 ' ?> rounded-lg">
               <i class="fa-solid fa-calculator"></i>
               <span class="flex-1 ml-3 whitespace-nowrap">Laporan Analisa EOQ</span>
            </a>
         </li>
         <li>
            <a href="/dashboard/pembelian" class="flex items-center p-2 <?= $page === 'pembelian' ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 ' ?> rounded-lg">
               <i class="fa-solid fa-cubes"></i>
               <span class="flex-1 ml-3 whitespace-nowrap">Pembelian</span>
            </a>
         </li>
         <!-- <li>
            <a href="/dashboard/laporan-pembelian" class="flex items-center p-2 <?= $page === 'laporan-pembelian' ? 'bg-gray-400 text-white dark:text-white hover:bg-gray-600 dark:hover:bg-gray-700' : 'dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 ' ?> rounded-lg">
               <i class="fa-solid fa-database"></i>
               <span class="flex-1 ml-3 whitespace-nowrap">Laporan Pembelian</span>
            </a>
         </li> -->
      </ul>
   </div>
</aside>