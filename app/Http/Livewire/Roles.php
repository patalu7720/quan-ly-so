<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;

class Roles extends Component
{
    public $roleName,$search;

    public $menu_contracts, $create_contracts, $edit_contracts, $delete_contracts, $approve_contracts, $approve_1_contracts;

    public $menu_pxxdhs, $view_pxxdhs, $create_pxxdhs, $edit_pxxdhs, $delete_pxxdhs, $khst_approve_pxxdhs, $qa_approve_pxxdhs, $sale_approve_pxxdhs , $sm_approve_pxxdhs, $sale_admin_approve_pxxdhs, $quan_ly_khst_approve_pxxdhs, $phan_bo_pxxdh;

    public $menu_ptksx, $create_ptksx, $edit_ptksx, $delete_ptksx, $qa_approve_ptksx, $sale_approve_ptksx, $khst_approve_ptksx, $quan_ly_khst_approve_ptksx, $sm_approve_ptksx;

    public $menu_bao_gia, $create_bao_gia, $edit_bao_gia, $delete_bao_gia, $approve_1_bao_gia , $approve_2_bao_gia, $approve_3_bao_gia;

    public $menu_tdg, $create_tdg, $edit_tdg, $delete_tdg, $approve_1_tdg, $approve_2_tdg, $approve_3_tdg, $approve_4_tdg;

    public $menu_ttdh, $create_ttdh, $edit_ttdh, $delete_ttdh, $approve_1_ttdh, $approve_2_ttdh, $approve_3_ttdh;

    public $menu_xac_nhan_don_hang, $create_xac_nhan_don_hang, $edit_xac_nhan_don_hang, $delete_xac_nhan_don_hang, $approve_1_xac_nhan_don_hang, $approve_2_xac_nhan_don_hang, $approve_3_xac_nhan_don_hang;

    public $menu_mo_phong, $create_mo_phong, $ket_thuc_mo_phong;

    public $menu_cancel_revised_so, $create_cancel_revised_so, $update_cancel_revised_so, $delete_cancel_revised_so, $approve_1_cancel_revised_so, $approve_2_cancel_revised_so, $approve_3_cancel_revised_so, $approve_4_cancel_revised_so;

    public $menu_tckh, $create_tckh, $sale_duyet_tckh, $qa_duyet_tckh;

    public $menu_tdtm, $create_tdtm, $sm_duyet_tdtm, $qa_duyet_tdtm, $khst_duyet_tdtm;

    public $getAllPermission, $getAllUsersOfRole;

    protected $searchResult;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount(){

        $this->getAllPermission =  Permission::all()->pluck('name')->toArray();

    }

    public function resetInput(){

        $this->roleName = '';
        $this->menu_contracts = '';
        $this->create_contracts = '';
        $this->edit_contracts = '';
        $this->delete_contracts = '';
        $this->approve_contracts = '';

        foreach ($this->getAllPermission as $item) {
        
            if($this->{$item} == 1){

                $this->{$item} = 0;

            }

        }

    }

    public function addNewRoles(){

        $this->validate([
            'roleName' => 'required'
        ]);
        
        $Addpermission = [];

        foreach ($this->getAllPermission as $item) {
        
            if($this->{$item} == 1){

                $Addpermission = array_merge($Addpermission,[$item]);

            }

        }

        $roles = Role::create(['name' => $this->roleName]);

        $roles->syncPermissions($Addpermission);

        flash()->addFlash('success', 'Create role success','Notification');

        $this->emit('addNewRolesModal');

        $this->resetInput();

    }

    public function detailRolesModal($roleName){

        $this->resetInput();

        $this->roleName = $roleName;

        $getPermissions = Role::findByName($roleName)->permissions->pluck('name');

        foreach ($getPermissions as $item) {
            
            $this->{$item} = 1;

        }

        $this->getAllUsersOfRole = User::role($roleName)->get();

    }

    public function editRolesModal($roleName){

        $this->resetInput();

        $this->roleName = $roleName;

        $getPermissions = Role::findByName($roleName)->permissions->pluck('name');

        foreach ($getPermissions as $item) {
            
            $this->{$item} = 1;

        }

        $this->getAllUsersOfRole = User::role($roleName)->get();

    }

    public function editRoles(){

        $this->validate([
            'roleName' => 'required'
        ]);

        $Addpermission = [];

        foreach ($this->getAllPermission as $item) {
        
            if($this->{$item} == 1){

                $Addpermission = array_merge($Addpermission,[$item]);

            }

        }

        $roles = Role::findByName($this->roleName);

        $roles->syncPermissions($Addpermission);

        flash()->addFlash('success', 'Edit role success','Notification');

        $this->emit('editRolesModal');

        $this->resetInput();

    }

    public function deleteRoleModal($roleName){

        $this->roleName = $roleName;

    }

    public function deleteRole(){

        $role = Role::findByName($this->roleName);

        $role->delete();

        flash()->addFlash('success', 'Delete role success','Notification');

        $this->emit('deleteRoleModal');

    }

    public function search(){

        $this->searchResult = Role::where('name','like', '%' . $this->search . '%')->paginate(15);

    }

    public function render()
    {
    
        if($this->search == ''){

            $listRoles = Role::paginate(15);

        }else{

            $this->search();
            $listRoles = $this->searchResult;

        }

        $baoGiaPermission = Permission::where('name', 'like', '%bao_gia')->get();

        $xacNhanDonHangPermission = Permission::where('name', 'like', '%xac_nhan_don_hang')->get();

        $ttdhPermission = Permission::where('name', 'like', '%ttdh')->get();

        $tdgPermission = Permission::where('name', 'like', '%tdg')->get();

        $contractsPermission = Permission::where('name', 'like', '%contracts')->get();

        $pxxdhsPermission = Permission::where('name', 'like', '%pxxdhs')->get();

        $ptksxPermission = Permission::where('name', 'like', '%ptksx')->get();

        $moPhongPermission = Permission::where('name', 'like', '%mo_phong')->get();

        $cancelRevisedSOPermission = Permission::where('name', 'like', '%cancel_revised_so')->get();

        $tckhPermission = Permission::where('name', 'like', '%tckh')->get();

        $tdtmPermission = Permission::where('name', 'like', '%tdtm')->get();

        return view('livewire.roles', compact('listRoles', 'tdgPermission', 'baoGiaPermission','contractsPermission',
        'pxxdhsPermission', 'ptksxPermission', 'ttdhPermission', 'xacNhanDonHangPermission', 'moPhongPermission', 'cancelRevisedSOPermission', 'tckhPermission', 'tdtmPermission'))->layout('layouts.adminApp');
    }
}
