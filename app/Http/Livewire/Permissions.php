<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;

class Permissions extends Component
{
    public $permissionName, $search;

    protected $searchResult;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function addNewPermission(){

        Permission::create(['name' => $this->permissionName]);

        $this->permissionName = '';

        flash()->addFlash('success', 'Tạo permission thành công','Thông báo');

        $this->emit('addNewPermissionModal');

    }

    public function deletePermissionModal($permissionName){

        $this->permissionName = $permissionName;

    }

    public function deletePermission(){

        $permission = Permission::findByName($this->permissionName);

        $permission->delete();

        flash()->addFlash('success', 'Delete Permission success','Notification');

        $this->emit('deletePermissionModal');

    }

    public function search(){

        $this->searchResult = Permission::where('name','like', '%' . $this->search . '%')->paginate(15);

    }

    public function render()
    {

        if($this->search == ''){

            $listPermission = Permission::paginate(15);

        }else{

            $this->search();
            $listPermission = $this->searchResult;

        }

        return view('livewire.permissions',compact('listPermission'))->layout('layouts.adminApp');
    }
}
