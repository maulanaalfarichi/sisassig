<div class="modal fade" id="modal-form">
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

                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="assignment_id" id="assignment_id">

                    <div class="form-group">
                        <label>{{ $assignment_user->attributes('user_id') }}</label>
                        <select name="user_id" id="user_id" class="form-control select2-name"></select>
                    </div>

                    <div class="form-group">
                        <label>{{ $assignment_user->attributes('served_as') }}</label>
                        <select name="served_as" id="served_as" class="form-control select2">
                            <option value="">Pilih</option>
                            @foreach ($assignment_as as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>{{ $assignment_user->attributes('workload') }}</label>
                        <input type="number" name="workload" id="workload" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>{{ $assignment_user->attributes('status_id') }}</label>
                        <select name="status_id" id="status_id" class="form-control select2">
                            <option value="">Pilih</option>
                            @foreach ($assignment_status as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>{{ $assignment_user->attributes('info') }}</label>
                        <textarea name="info" id="info" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn-flat pull-right" id="submit">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
