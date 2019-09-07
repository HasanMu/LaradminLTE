<div class="modal fade" id="modalHapusLog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Anda Yakin Ingin Menghapus Log Ini?</h4>
            </div>
            <form id="formHapusLog">
                <div class="modal-body">
                    <div class="notify-alert-delete-log"></div>
                    <div class="form-group">
                        <input type="hidden" name="id" id="hidden-id-log">
                        <label for="passowrd">Passoword</label>
                        <input id="passowrd" class="form-control" type="password" name="password">
                        <small>* Password dibutuhkan untuk konfirmasi</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light pull-left" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus Log!</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
