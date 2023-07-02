
            <footer class="bg-white rounded-lg shadow dark:bg-gray-900 w-full max-w-screen-xl">
                <div class="container mx-auto  w-full max-w-screen-xl mx-auto p-4 md:py-8">
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <a href="#" class="flex items-center mb-4 sm:mb-0">
                            <span class="self-center text-xs lg:text-2xl font-semibold whitespace-nowrap dark:text-white"><?=$data['title']?></span>
                        </a>
                        <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                            <li>
                                <a href="/about" class="mr-4 hover:underline md:mr-6 ">About</a>
                            </li>
                            <li>
                                <a href="/privacy" class="mr-4 hover:underline md:mr-6">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="/licence" class="mr-4 hover:underline md:mr-6 ">Licensing</a>
                            </li>
                            <li>
                                <a href="/contact" class="hover:underline">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
                    <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© <?=date('Y')?> <a href="#" class="hover:underline"><?=$data['brand']?>™</a>. All Rights Reserved.</span>
                </div>
            </footer>
