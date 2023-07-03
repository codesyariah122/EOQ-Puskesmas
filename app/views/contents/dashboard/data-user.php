
<div id="data-user" class="py-20 p-4 sm:ml-64">
   <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
      <div class="grid grid-cols-1 mb-6">
         <div class="col-span-full">
            <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
              <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Data User</h5>
              <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">Table Data User</p>
           </div>
        </div>
     </div>

     <div class="grid grid-cols-1 mb-4">
        <div class="col-span-full">
                       
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
               <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                  <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                     <tr>
                        <th scope="col" class="px-6 py-3">
                           Kode User
                        </th>
                        <th scope="col" class="px-6 py-3">
                           Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                           Alamat
                        </th>
                        <th scope="col" class="px-6 py-3">
                           No Telp
                        </th>
                        <th scope="col" class="px-6 py-3">
                           Username
                        </th>
                        <th scope="col" class="px-6 py-3">
                           <span class="sr-only">Edit</span>
                        </th>
                     </tr>
                  </thead>
                  <tbody id="user-data">
                      <?php foreach($rows as $idx => $data): ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                           
                           <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              <?=$data['kd_admin']?>
                           </th>
                           <td class="px-6 py-4">
                              <?=$data['nm_lengkap']?>
                           </td>
                           <td class="px-6 py-4">
                              <?=$data['alamat']?>
                           </td>
                           <td class="px-6 py-4">
                              <?=$data['notlp']?>
                           </td>
                           <td class="px-6 py-4">
                              <?=$data['username']?>
                           </td>
                           <td>
                              <div class="flex justify-center space-x-4">
                                 <div>
                                    <button id="edit" type="button" class="px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg">
                                       <i class="fa-solid fa-pen-to-square"></i>
                                    </button>                                 
                                 </div>
                                 <div>
                                    <button type="button" class="px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg">
                                       <i class="fa-solid fa-trash"></i>
                                    </button>
                                 </div>
                              </div>
                           </td>
                        </tr>
                     <?php endforeach;?>
                  </tbody>
               </table>
            </div>

        </div>
     </div>
  </div>
</div>
