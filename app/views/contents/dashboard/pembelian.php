

<div class="py-[30px] p-4 sm:ml-64">
   <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
      <div class="grid grid-cols-1 mb-6">
         <div class="col-span-full">
            <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow-lg sm:p-8 dark:bg-gray-800 dark:border-gray-700">
             <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Laporan Pembelian</h5>
             <p class="mb-0 text-base text-gray-500 sm:text-lg dark:text-gray-400">Table Data Laporan Pembelian</p>

                <!-- Aktifkan untuk countdown timer -->
               <?php require_once 'molecules/login-countdown.php' ?>
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

   <div id="displaying" class="py-2">

      <!-- Add new pembelian -->
      <div class="grid grid-cols-1 justify-items-center">
         <?php require_once 'molecules/laporan-pembelian/add-data.php'?>
      </div>

      <div class="col-span-full">
         <div class="py-2 mb-2">
            <?php require_once 'molecules/laporan-pembelian/search-data.php'?>
         </div>

         <div id="table-laporan" class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                     <th scope="col" class="px-6 py-3 hidden">
                        #ID
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Kode Pembelian
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Tanggal Pembelian
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Kode Obat
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Nama Obat
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Jumlah Beli
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Harga
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Total
                     </th>
                  </tr>
               </thead>
               <div id="toastContainer"></div>
               <!-- Data table di lakukan secara dom dari javascript -->
               <tbody id="pembelian"></tbody>
            </table>
         </div>

         <!-- Data pagination -->
         <div class="relative py-12">
            <?php require_once 'molecules/laporan-pembelian/paging.php' ?>
         </div>

      </div>
      <?php if($_SESSION['role'] === "admin"):?>
         <div class="col-span-full w-[80vw] px-36">
           <time class="text-lg font-semibold text-gray-900 dark:text-white py-2">Log Pembelian</time>
            <ol id="log-beli" class="relative border-l border-gray-200 dark:border-gray-700 mt-12">   
            </ol>
         </div>
      <?php endif;?>
   </div>
</div>
