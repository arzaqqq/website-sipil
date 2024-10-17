</<?php  
// app/Http/Livewire/EditTextCell.php


use Livewire\Component;
use Illuminate\Support\Facades\DB;

class EditTextCell extends Component
{
    public $recordId;
    public $columnName;
    public $value;

    public function mount($recordId, $columnName, $value)
    {
        $this->recordId = $recordId;
        $this->columnName = $columnName;
        $this->value = $value;
    }

    public function updatedValue()
    {
        // Simpan data ke database saat nilai diperbarui
        DB::table('your_table_name') // ganti dengan nama tabel yang sesuai
            ->where('id', $this->recordId)
            ->update([$this->columnName => $this->value]);

        $this->emit('cellUpdated'); // Emit event untuk memperbarui tabel jika diperlukan
    }

    public function render()
    {
        return view('livewire.edit-text-cell');
    }
}