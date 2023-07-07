
<div class="py-[30px] p-4 sm:ml-64">
   <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
      <div class="grid grid-cols-1 mb-6">
         <div class="col-span-full">
            <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow-lg sm:p-8 dark:bg-gray-800 dark:border-gray-700">
             <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Laporan Eoq</h5>
             <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">Table Laporan EOQ</p>
         </div>

         <div id="alert-error" class="w-full mb-2 py-2 hidden">
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
               <i class="fa-solid fa-circle-exclamation"></i>
               <span class="sr-only">Info</span>
               <div id="message-error"></div>
            </div>
         </div>

         <div id="alert-success" class="w-full mb-2 py-2 hidden">
            <div class="flex justify-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
               <i class="fa-solid fa-check-double"></i>
               <span class="sr-only">Info</span>
               <div id="message-success"></div>
            </div>
         </div>
      </div>
   </div>
</div>

<div id="displaying" class="mb-4 py-0">

   <!-- Add new user -->
   <div class="grid grid-cols-1 justify-items-center">
      <div class="col-span-full">
      	<button type="button" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"><i class="fa-solid fa-print"></i> Print Laporan</button>
      </div>
   </div>

   <div class="col-span-full">
      <!-- Search data -->
      <div class="relative py-4 mb-4">
         <?php require_once 'molecules/data-obat/search-data.php'?>
      </div>

      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
         <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
               <tr>
                  <th scope="col" class="px-6 py-3">
                     Kode Obat
                  </th>
                  <th scope="col" class="px-6 py-3">
                     Nama Obat
                  </th>
                  <th scope="col" class="px-6 py-3">
                     Kebutuhan Pertahun
                  </th>
                  <th scope="col" class="px-6 py-3">
                     Biaya Simpan
                  </th>
                  <th scope="col" class="px-6 py-3">
                     Biaya Pesan
                  </th>
                  <th scope="col" class="px-6 py-3">
                     Jumlah Pemesanan Economics
                  </th>
                  <th scope="col" class="px-6 py-3">
                     Interval Waktu Pemesanan
                  </th>
               </tr>
            </thead>

            <!-- Data user di lakukan secara dom dari javascript -->
            <tbody id="laporan-eoq"></tbody>

         </table>
      </div>

      <!-- Data pagination -->
      <div class="relative py-12">
         <?php require_once 'molecules/laporan-eoq/paging.php' ?>
      </div>

   </div>
</div>
</div>
