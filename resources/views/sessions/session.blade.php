        <!--<div class="fixed flex-col z-50 bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center"  role="alert">
            <div x-show="open" x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-gray-100 rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                <button type="button" class="flex" @click="openAlertBox = false">
                    <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 ml-4"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="w-full">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Eliminar registro
                    </h3>
                    <div class="mt-2">
                        <div class="mt-10 text-gray-700">
                            ¿Estas seguro?
                        </div>
                        <div class="mt-10 flex justify-center">
                            <span class="mr-2">
                                <button x-bind:disabled="working" class="w-32 rounded-md shadow-sm inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:border-gray-700 focus:shadow-outline-teal active:bg-gray-700 transition ease-in-out duration-150">
                                    No
                                </button>
                            </span>
                            <span x-on:click="working = !working">
                                <button class="w-32 rounded-md shadow-sm inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:border-red-700 focus:shadow-outline-teal active:bg-blue-700 transition ease-in-out duration-150">
                                    Sí
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->