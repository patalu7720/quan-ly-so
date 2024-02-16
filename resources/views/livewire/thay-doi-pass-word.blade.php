<div class="container">
    <div class="row mb-5">
    </div>
    <div class="row">
        <div class="col"></div>
        <div class="col-12 col-lg-6">
            <form wire:submit.prevent="thayDoiMatKhau"l>
                <div class="shadow p-3 mb-5 bg-body rounded">
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" placeholder="Nhập mật khẩu mới" wire:model.defer = "password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Nhập lại mật khẩu mới</label>
                        <input type="password" class="form-control" placeholder="Nhập lại" wire:model.defer = "confirmPassword" required>
                    </div>
                    <button class="btn btn-primary">Xác nhận</button>
                </div>
            </form>
        </div>
        <div class="col"></div>
    </div>
</div>
