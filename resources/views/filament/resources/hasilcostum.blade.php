<x-filament-panels::page>
    <style>
        /* Tambahkan gaya CSS murni di sini */
        .btn-save {
            background-color: #10B981; /* Hijau */
            color: #ffffff;
            font-weight: bold;
            padding: 0.5rem 1rem;
            margin-top: 1rem;
            width: 10rem;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .btn-save:hover {
            background-color: #60A5FA; /* Biru saat hover */
        }
    </style>

    <form method="POST" wire:submit.prevent="save">
        {{ $this->form }}
        <button type="submit" class="btn-save">
            Save
        </button>
    </form>
</x-filament-panels::page>
