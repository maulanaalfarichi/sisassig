<div class="modal fade" id="modal-show">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>

            <form method="POST" id="form">
                <div class="modal-body">
                    <div class="modal-response"></div>

                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>{{ $assignment_user->attributes('user_id') }}</td>
                            <td id="user_id"></td>
                        </tr>
                        <tr>
                            <td>{{ $assignment_user->attributes('served_as') }}</td>
                            <td id="served_as"></td>
                        </tr>
                        <tr>
                            <td>{{ $assignment_user->attributes('workload') }}</td>
                            <td id="workload"></td>
                        </tr>
                        <tr>
                            <td>{{ $assignment_user->attributes('status_id') }}</td>
                            <td id="status_id"></td>
                        </tr>
                        <tr>
                            <td>{{ $assignment_user->attributes('info') }}</td>
                            <td id="info"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
