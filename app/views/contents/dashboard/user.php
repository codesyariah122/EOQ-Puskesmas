
<div class="py-24 p-4 sm:ml-64">
   <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
      <div class="grid grid-cols-1 gap-4 mb-4">
         <div class="col-span-full">
            <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
              <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white"><?=$welcome_text?></h5>
              <p class="mb-0 text-base text-gray-500 sm:text-lg dark:text-gray-400"><?=$description?>.</p>

               <!-- Aktifkan untuk countdown timer -->
               <?php require_once 'molecules/login-countdown.php' ?>
           </div>
        </div>
     </div>
  </div>
</div>
