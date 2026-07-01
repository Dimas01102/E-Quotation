<div id="profileModal" class="fixed inset-0 z-[60] items-center justify-center bg-black/60 backdrop-blur-sm"
    style="display:none">
    <div
        class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-md mx-4 shadow-2xl
                border border-gray-200 dark:border-gray-700">

        {{--  Header  --}}
        <div
            class="flex items-center justify-between px-6 py-4
                    border-b border-gray-100 dark:border-gray-800">
            <h3 class="font-semibold text-gray-800 dark:text-white">Edit Profil Admin</h3>
            <button onclick="closeProfileModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6 space-y-4">
            <div id="profileAlert" class="hidden p-3 rounded-xl text-sm"></div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">
                    Nama <span class="text-red-500">*</span>
                </label>
                <input id="profileName" type="text"
                    class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800
                           border border-gray-200 dark:border-gray-700 rounded-xl
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           text-gray-800 dark:text-white">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">
                    Email
                </label>
                <input id="profileEmail" type="email" disabled
                    class="w-full px-4 py-2.5 text-sm bg-gray-100 dark:bg-gray-700
                           border border-gray-200 dark:border-gray-600 rounded-xl
                           text-gray-500 dark:text-gray-400 cursor-not-allowed">
            </div>

            <div class="pt-2 border-t border-gray-100 dark:border-gray-800">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">
                    Ubah Password
                </p>
                <p class="text-xs text-gray-400 mb-3">
                    Kosongkan jika tidak ingin mengubah password.
                </p>
                <div class="space-y-3">
                    <input id="profilePassword" type="password" placeholder="Password baru (min. 8 karakter)"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800
                               border border-gray-200 dark:border-gray-700 rounded-xl
                               focus:outline-none focus:ring-2 focus:ring-blue-500
                               text-gray-800 dark:text-white">
                    <input id="profilePasswordConfirm" type="password" placeholder="Konfirmasi password baru"
                        class="w-full px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800
                               border border-gray-200 dark:border-gray-700 rounded-xl
                               focus:outline-none focus:ring-2 focus:ring-blue-500
                               text-gray-800 dark:text-white">
                </div>
            </div>
        </div>

        {{-- Footer  --}}
        <div class="px-6 pb-6 flex gap-3">
            <button onclick="saveProfile()"
                class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white
                       rounded-xl text-sm font-medium transition-colors">
                Simpan Perubahan
            </button>
            <button onclick="closeProfileModal()"
                class="flex-1 py-2.5 border border-gray-200 dark:border-gray-700
                       text-gray-600 dark:text-gray-300 rounded-xl text-sm
                       hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                Batal
            </button>
        </div>

    </div>
</div>
