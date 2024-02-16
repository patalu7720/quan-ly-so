<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ThayDoiPassWord extends Component
{

    public $password, $confirmPassword;

    public function thayDoiMatKhau(){

        if($this->password == $this->confirmPassword){

            User::where('username', Auth::user()->username)->update(['password' => Hash::make($this->password)]);

            $this->password = '';
            $this->confirmPassword = '';

            flash()->addFlash('success', 'Đổi mật khẩu thành công','Thông báo');

        }else{
        
            flash()->addFlash('error', 'Nhập lại không trùng khớp','Thông báo');
            $this->password = '';
            $this->confirmPassword = '';
        
        }

    }

    public function render()
    {
        return view('livewire.thay-doi-pass-word');
    }
}
