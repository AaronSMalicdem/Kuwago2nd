<?php

namespace App\Http\Livewire\Order\Modal;

use App\Http\Livewire\Modal;
use Auth;

class EditTable extends Modal
{
    public $newTableName;
    public $tableId;

    protected $listeners = ['editTable' => 'editTableName'];

    public function editTableName($tableId)
    {
        $this->toggleModal();
        $this->tableId = $tableId;
    }

    public function updateTableName()
    {
        Auth::user()->assignTables()->updateExistingPivot($this->tableId, ['table_name' => $this->newTableName]);
        return redirect()->to('/waiter-order');
    }

    public function close()
    {
        $this->toggleModal();
        $this->reset();
    }

    public function render()
    {
        return view('livewire.order.modal.edit-table');
    }
}
