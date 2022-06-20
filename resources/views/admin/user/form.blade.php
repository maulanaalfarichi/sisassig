@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
@stop

@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        $('.datepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            showTodayButton: true
        });
        $('.select2').select2({
            width: '100%'
        });
        $('.select2-birth_place').select2({
            width: '100%',
            minimumInputLength: 3,
            ajax: {
                url: '{{ url('api/search/regency') }}',
                dataType: 'json',
                processResults: function (data, page) {
                    var results = [];

                    $.each(data, function(index, item) {
                        results.push({
                            id: item.id,
                            text: item.name
                        });
                    });

                    return {
                        results: results
                    };
                },
            }
        });

        function getBirthPlace(id, _callback) {
            $.ajax({
                url: '{{ url('api/regency') }}' + '/' + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    $('.select2-birth_place').html('');
                    $('.select2-birth_place').append('<option value="' + data.id + '">' + data.name + '</option>');

                    if(typeof callback == 'function') callback();
                }
            });
        }

        function getRegency(id, selected, _callback) {
            url = '{{ url('api/dropdown/regency') }}' + '/' + id;
            dropdown = $('.regency_id');
            placeholder = 'Pilih Kota/Kab';
            errorSelector = $('.response');
            callback = function() {
                $('.district_id').html('');
                $('.village_id').html('');

                if(typeof _callback == 'function') _callback();
            }

            helpers.getDropdownData(url, dropdown, placeholder, errorSelector, selected, callback);
        }

        function getDistrict(id, selected, _callback) {
            url = '{{ url('api/dropdown/district') }}' + '/' + id;
            dropdown = $('.district_id');
            placeholder = 'Pilih Kecamatan';
            errorSelector = $('.response');
            callback = function() {
                $('.village_id').html('');

                if(typeof _callback == 'function') _callback();
            }

            helpers.getDropdownData(url, dropdown, placeholder, errorSelector, selected, callback);
        }

        function getVillage(id, selected, _callback) {
            url = '{{ url('api/dropdown/village') }}' + '/' + id;
            dropdown = $('.village_id');
            placeholder = 'Pilih Kelurahan/Desa';
            errorSelector = $('.response');

            helpers.getDropdownData(url, dropdown, placeholder, errorSelector, selected, _callback);
        }
        @if ($action == 'edit')
            getBirthPlace({!! $user->birth_place !!});

            $('.province_id').val({!! $user->province_id !!}).change();
            getRegency({!! $user->province_id !!}, {!! $user->regency_id !!}, function() {
                getDistrict({!! $user->regency_id !!}, {!! $user->district_id !!}, function() {
                    getVillage({!! $user->district_id !!}, {!! $user->village_id !!});
                });
            });
        @endif
    </script>
@stop

@php ($id = ($action == 'edit') ? $user->id : '')

<form action="{{ url('admin/user/' . $id) }}" method="post" enctype="multipart/form-data">
    <div class="box-body">
        {{ csrf_field() }}
        @if ($action == 'edit')
            {{ method_field('PUT') }}
        @endif
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>{{ $user->attributes('photo') }}</label>
                    @if($action == 'edit')
                        <img src="{{ url('img/' . $user->photo) }}" id="photo" class="img-responsive">
                    @endif
                    <input type="file" name="photo" class="form-control">
                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label>{{ $user->attributes('name') }}</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                </div>

                <div class="form-group">
                    <label>{{ $user->attributes('email') }}</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                </div>

                <div class="form-group">
                    <label>{{ $user->attributes('password') }}</label>
                    <input type="password" name="password" class="form-control">
                    @if ($action == 'edit')
                        <div class="help-block" id="password-help-block">Kosongkan jika tidak ingin mengganti password.</div>
                    @endif
                </div>

                <div class="form-group">
                    <label>{{ $user->attributes('roles') }}</label>
                    @foreach ($roles as $role)
                        @if ($action == 'edit')
                            @php ($checked = in_array($role->id, $user->roles) ? 'checked' : '')
                        @else
                            @php ($checked = '')
                        @endif
                        <div class="checkbox">
                            <label><input type="checkbox" name="roles[]" id="role-{{ $role->id }}" value="{{ $role->id }}" {{ $checked }}> {{ $role->name }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="form-group">
                    <label>{{ $user->attributes('birth_place') }}</label>
                    <select name="birth_place" class="form-control select2-birth_place"></select>
                </div>

                <div class="form-group">
                    <label>{{ $user->attributes('birth_date') }}</label>
                    <input type="text" name="birth_date" class="form-control datepicker" value="{{ old('birth_date', $user->birth_date) }}">
                </div>

                <div class="form-group">
                    <label>{{ $user->attributes('bio') }}</label>
                    <textarea name="bio" class="form-control">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <div class="form-group">
                    <label>{{ $user->attributes('province_id') }}</label>
                    <select name="province_id" class="form-control select2 province_id" onchange="getRegency(this.value)">
                        <option value="">Pilih Provinsi</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>{{ $user->attributes('regency_id') }}</label>
                    <select name="regency_id" class="form-control select2 regency_id" onchange="getDistrict(this.value)"></select>
                </div>

                <div class="form-group">
                    <label>{{ $user->attributes('district_id') }}</label>
                    <select name="district_id" class="form-control select2 district_id" onchange="getVillage(this.value)"></select>
                </div>

                <div class="form-group">
                    <label>{{ $user->attributes('village_id') }}</label>
                    <select name="village_id" class="form-control select2 village_id"></select>
                </div>

                <div class="form-group">
                    <label>{{ $user->attributes('address') }}</label>
                    <textarea name="address" class="form-control">{{ old('address', $user->address) }}</textarea>
                </div>

                <div class="form-group">
                    <label>{{ $user->attributes('expertise') }}</label>
                    <textarea name="expertise" class="form-control">{{ old('expertise', $user->expertise) }}</textarea>
                </div>

                <div class="form-group">
                    <label>{{ $user->attributes('active') }}</label>
                    <select name="active" class="form-control select2">
                        <option value="">Pilih</option>
                        <option value="1" {{ $user->active ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ !$user->active ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <a href="{{ url('admin/user') }}" class="btn btn-default btn-flat">Kembali</a>
        <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
    </div>
</form>