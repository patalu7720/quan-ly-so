<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;

class QuanLyUser extends Component
{

    public $username, $name, $email , $getAllRoles , $password, $confirmPassword, $newPassword, $newPasswordConfirmation, $search;

    public $sale_admin, $sale_manager, $super_admin ,$khst_user, $qa_user, $sale, $khst_manager, $it_manager, $sale_duyet_bao_gia, $gd_tql, $sale_approve_tdg_1, $sale_approve_tdg_2, $sale_approve_tdg_3, $tong_giam_doc, $qa_manager;

    public $pho_phong_sale;

    public $sale_approve_ttdh_1, $sale_approve_ttdh_2;

    protected $searchResult;

    public $getAllPermission, $quyen_truc_tiep;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount(){

        $this->getAllRoles = Role::all()->pluck('name')->toArray();

    }

    public function resetInput(){

        $this->username = '';
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->confirmPassword = '';
        $this->newPassword = '';
        $this->newPasswordConfirmation = '';

        foreach ($this->getAllRoles as $item) {
        
            if($this->{$item} == 1){

                $this->{$item} = 0;

            }

        }

    }

    public function addRolesToUserModal($username){

        $this->username = $username;

        $user = User::where('username', $this->username)->first();

        $getAllRolesOfUser = $user->getRoleNames();

        foreach ($getAllRolesOfUser as $item) {
            
            $this->{$item} = 1;

        }

    }

    public function addRolesToUser(){

        $user = User::where('username', $this->username)->first();

        $addRoles = [];

        foreach ($this->getAllRoles as $item) {
        
            if($this->{$item} == 1){

                $addRoles = array_merge($addRoles,[$item]);

            }

        }

        $user->syncRoles($addRoles);

        flash()->addFlash('success', 'Add role to user success','Notification');

        $this->emit('addRolesToUserModal');

        $this->resetInput();

    }

    public function addPermissionModal($username){

        $this->username = $username;

        $user = User::where('username', $this->username)->first();

        $this->getAllPermission = $user->getPermissionNames();

    }

    public function addPermission(){

        $user = User::where('username', $this->username)->first();
        
        $user->givePermissionTo($this->quyen_truc_tiep);

        sweetalert()->addSuccess('Thêm quyền trực tiếp thành công.');
        
        $this->emit('addPermissionModal');

        $this->resetInput();
    }

    public function editUserModal($username){

        $this->username = $username;

        $editUser = User::where('username', $this->username)->first();

        $this->username = $editUser->username;

        $this->name = $editUser->name;

        $this->email = $editUser->email;

    }

    public function editUser(){

        $user = User::where('username', $this->username)->first();

        $user->name = $this->name;

        $user->email = $this->email;

        $user->save();

        flash()->addFlash('success', 'Edit user success','Notification');

        $this->emit('editUserModal');

        $this->resetInput();

    }

    public function changePasswordModal($username){

        $this->username = $username;

    }

    public function changePassword(){

        if ($this->newPassword != $this->newPasswordConfirmation) {
            
            flash()->addFlash('error', 'Password not same','Notification');

        }else{

            $user = User::where('username', $this->username)->first();

            $user->password = Hash::make($this->newPassword);
    
            $user->save();
    
            flash()->addFlash('success', 'Change password user success','Notification');
    
            $this->emit('changePasswordModal');

            $this->resetInput();

        }
    }

    public function lockUser($username){

        $user = User::where('username', $username)->first();

        $user->isLock = 1;

        $user->save();

        flash()->addFlash('success', 'Lock user success','Notification');


    }

    public function unLockUser($username){

        $user = User::where('username', $username)->first();

        $user->isLock = 0;

        $user->save();

        flash()->addFlash('success', 'Unlock user success','Notification');


    }

    public function deleteUser($username){

        $user = User::where('username', $username)->first();

        $user->delete();

        flash()->addFlash('success', 'Delete user success','Notification');

    }

    public function addNewUser(){

        if ($this->password != $this->confirmPassword) {
            
            flash()->addFlash('error', 'Password not same','Notification');

        }else{

            User::create([

                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'isLock' => 0,
            ]);

            flash()->addFlash('success', 'Create user success','Notification');

            $this->emit('addNewUserModal');

            $this->resetInput();

        } 

    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function search(){

        $this->searchResult = User::where('username', 'like', '%' . $this->search . '%')->paginate(15);

    }

    public function render()
    {

        if($this->search == ''){

            $danhSachTaiKhoan = User::paginate(100);

        }else{
            
            $this->search();
            $danhSachTaiKhoan = $this->searchResult;

        }

        return view('livewire.quan-ly-user',compact('danhSachTaiKhoan'))->layout('layouts.adminApp');
    }
}
