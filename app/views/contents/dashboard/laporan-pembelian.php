<div class="py-[30px] p-4 sm:ml-64">
   <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
      <div class="grid grid-cols-1 mb-6">
         <div class="col-span-full">
            <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow-lg sm:p-8 dark:bg-gray-800 dark:border-gray-700">
               <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Laporan Pembelian</h5>
               <p class="mb-0 text-base text-gray-500 sm:text-lg dark:text-gray-400">Table Data Laporan Pembelian</p>

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

   <div id="displaying" class="py-2">
      <div class="grid grid-cols-1 justify-items-center sm:py-6 py-0">
         <div class="col-span-full">
            <button type="button" id="print-laporan" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2"><i class="fa-solid fa-clipboard-check"></i> Select Data</button>
            <button type="button" id="close-selected" class="hidden text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"><i class="fa-regular fa-folder-closed"></i> Close Selected Pdf</button>
         </div>
      </div>

      <div class="col-span-full">
         <!-- Dom data untuk preview print & pdf content -->
         <center>
            <div id="tableContainer" class="overflow-x-auto sm:rounded-lg py-2 mb-4">
               <div id="tableContainerHeader" class="hidden mb-12 flex justify-center">
                  <div>
                     <h4 align="center" class="table-header">Laporan &nbsp;Pembelian</h4>
                  </div>
                  <br />
               </div>
            </div>
         </center>

         <!-- <div class="mb-4">
            <h2 class="text-md text-gray-800 font-semibold">
               Filter Berdasarkan Periode
            </h2>

            <div class="flex items-center py-4">
               <input id="default-checkbox" type="checkbox" value="" class="change__input-date w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
               <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Date Range</label>
            </div>

            <div id="single" class="flex justify-start space-x-4 py-2">
               <div>
                  <div class="relative max-w-sm">
                     <input type="date" id="tgl_beli" type=" text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                  </div>
               </div>
            </div>

            <div id="multiple" class="flex justify-start space-x-4 py-2 hidden">
               <div>
                  <div class="flex items-center">
                     <div class="relative">
                        <input name="start" id="start_date" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start">
                     </div>
                     <span class="mx-4 text-gray-500">to</span>
                     <div class="relative">
                        <input name="end" id="end_date" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end">
                     </div>
                  </div>
               </div>
            </div>
         </div> -->

         <div class="py-2 mb-2">
            <?php require_once 'molecules/laporan-pembelian/search-data.php' ?>
         </div>

         <div id="table-laporan" class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                     <th scope="col" class="p-4">
                        <div class="flex items-center">
                           <input id="default-checkbox" type="checkbox" class="checkAll w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                           <label for="default-checkbox" class="sr-only">All</label>
                        </div>
                     </th>
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
               <tbody id="laporan-pembelian"></tbody>
            </table>
         </div>

         <!-- Data pagination -->
         <div class="relative py-12">
            <?php require_once 'molecules/laporan-pembelian/paging.php' ?>
         </div>

      </div>
   </div>
</div>