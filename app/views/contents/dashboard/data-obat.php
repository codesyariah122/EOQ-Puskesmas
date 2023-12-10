<div class="py-[30px] p-4 sm:ml-64">
   <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
      <div class="grid grid-cols-1 mb-6">
         <div class="col-span-full">
            <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow-lg sm:p-8 dark:bg-gray-800 dark:border-gray-700">
               <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Data Obat</h5>
               <p class="mb-0 text-base text-gray-500 sm:text-lg dark:text-gray-400">Table Persediaan Data Obat</p>

               <!-- Aktifkan untuk countdown timer -->
               <?php //require_once 'molecules/login-countdown.php' 
               ?>
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
         <?php require_once 'molecules/data-obat/add-data.php' ?>
      </div>

      <div class="col-span-full">
         <!-- Search data -->
         <div class="relative py-4 mb-4">
            <?php require_once 'molecules/data-obat/search-data.php' ?>
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
                        Stok
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Isi
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Jenis Obat
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Harga
                     </th>
                     <th scope="col" class="px-6 py-3">
                       Sisa Stok
                     </th>
                     <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                     </th>
                  </tr>
               </thead>

               <!-- Data table di lakukan secara dom dari javascript -->
               <tbody id="data-obat"></tbody>

            </table>
         </div>

         <!-- Data pagination -->
         <div class="relative py-12">
            <?php require_once 'molecules/data-obat/paging.php' ?>
         </div>

      </div>
   </div>
</div>