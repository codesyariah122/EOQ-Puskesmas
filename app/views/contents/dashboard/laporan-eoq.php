

<style>
   .table-footer {
       margin-top: 3rem;
       float: right;
       text-align: right;
       background-color: transparent;
   }

   .table-footer th,
   .table-footer td {
       background-color: #fff;
       border: none!important;
   }

   .table-footer .name {
      margin-top: 4rem;
   }

   .dom-laporan-table {  
     font-family: arial, sans-serif;  
     border-collapse: collapse;  
     width: 100%;  
   }

  .dom-laporan-table td {  
     border: 1px solid #dddddd;  
     text-align: left;  
     padding: 8px;
     font-size: 11px;
     text-align: center!important;
   } 
  .dom-laporan-table th{
     border: 1px solid #dddddd;  
     text-align: left;  
     padding: 8px;  
     background-color: rgba(61, 61, 61, 0.7);  
     color:white;
     font-size: 11.3px;
   }

  .dom-laporan-table tr:nth-child(odd) {  
     background-color: #dddddd;  
   }
</style>

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

<div id="displaying" class="mb-4 py-2">

	<div class="grid grid-cols-1 justify-items-center sm:py-6 py-0">
      <div class="col-span-full">
      	<button type="button" id="print-laporan" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2"><i class="fa-solid fa-clipboard-check"></i> Select Data</button>
      	<button type="button" id="close-selected" class="hidden text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"><i class="fa-regular fa-folder-closed"></i> Close Selected Pdf</button>
      </div>
   </div>

   <div class="col-span-full">

      <!-- Dom data untuk preview print & pdf content -->
      <div id="tableContainer" class="overflow-x-auto sm:rounded-lg py-2 mb-4">
         <div id="tableContainerHeader" class="hidden mb-12 flex justify-center">
            <div>               
               <h4 align="center" class="table-header">Laporan &nbsp;&nbsp; Analisa &nbsp;&nbsp; EOQ</h4>
            </div>
         </div>
      </div>


      <div id="table-laporan"  class="relative overflow-x-auto shadow-md sm:rounded-lg">

      	<div class="py-4 mb-4">
      		<?php require_once 'molecules/laporan-eoq/search-data.php'?>
      	</div>

         <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
               <tr>
                  <th scope="col" class="px-6 py-3">
                  	<div class="flex items-center mb-4">
                  		<input id="default-checkbox" type="checkbox" value="" class="selectAll w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                  	</div>
                  </th>
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
