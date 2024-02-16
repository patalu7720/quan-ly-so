<div wire:ignore.self class="modal" id="downloadFileModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tải File</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
        </div>
        <div class="modal-body">
            @if ($danhSachFile != null)
                <table class="table">
                    <thead>
                        <th>File</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($danhSachFile as $item)
                            <tr>
                                <td>{{ str_replace('PhieuXXDH/' . $soPhieu . '/','',$item) }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" wire:click.prevent="downloadFile('{{ $soPhieu }}','{{ str_replace('PhieuXXDH/' . $soPhieu . '/','',$item) }}')"><i class="fa-solid fa-download"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="resetInputField()">Đóng</button>
        </div>
      </div>
    </div>
</div>