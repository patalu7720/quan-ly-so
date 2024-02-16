<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Chi tiết phiếu TTDH</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
                {!! nl2br($detail) !!}
                <div class="shadow p-3 bg-body-tertiary rounded">
                  @if ($log != null)
                      <div class="row">
                          <div class="table-responsive caption-top">
                              <caption>Lịch sử</caption>
                              <table class="table table-striped">
                                  <thead>
                                      <th>
                                          Trạng thái
                                      </td>
                                      <th>
                                          Trạng thái Log
                                      </td>
                                      <th>
                                          Username
                                      </td>
                                      <th>
                                          Thời gian
                                      </td>
                                  </thead>
                                  <tbody>
                                      @foreach ($log as $item)
                                          <tr>
                                              <td>
                                                  {{ $item->status ?? $item['status'] }}
                                              </td>
                                              <td>
                                                  {{ $item->status_log ?? $item['status_log'] }}
                                              </td>
                                              <td>
                                                  {{ $item->updated_user ?? $item['updated_user'] }}
                                              </td>
                                              <td>
                                                  {{ $item->updated_at ?? $item['updated_at'] }}
                                              </td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  @endif
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          </div>
        </div>
      </div>
</div>