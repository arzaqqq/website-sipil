
<div>
<x-filament::breadcrumbs :breadcrumbs="[
    'evaluasis' => 'Evaluasi',
    '#' => 'List',
    
]" />
<div class="flex justify-between ">
    <div class="font-bold text-3xl">EVALUASI</div>
    <div>
        {{ $data }} 
    </div>
</div>
</div>

<div>
    <form wire:submit.prevent="save" class="w-full max-w-sm flex flex-col mt-2">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="fileInput">
                Pilih Berkas
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="fileInput" type="file" wire:model="file">
        </div>
        
        <div class="flex items-center justify-between mt-3">
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="submit">
                Unggah
            </button>
        </div>
    </form>
    
</div>

