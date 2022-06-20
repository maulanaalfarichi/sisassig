var helpers = {
    buildDropdown: buildDropdown,
    refreshData: refreshData,
    getDropdownData: getDropdownData
}

function refreshData() {
    table.ajax.reload();
}

function buildDropdown(result, dropdown, placeholder) {
    dropdown.html('');
    dropdown.append('<option value="">' + placeholder + '</option>');
    if(result != '') {
        $.each(result, function(k, v) {
            dropdown.append('<option value="' + v.id + '">' + v.name + '</option>');
        });
    }
}

function getDropdownData(url, dropdown, placeholder, errorSelector, selected, callback) {
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
            buildDropdown(data, dropdown, placeholder);

            if(typeof callback == "function") callback();
        },
        error: function(xhr, status, err) {
            obj = JSON.parse(xhr.responseText);
            response = obj.message;
            responseDetail = '<ul>';
            $.each(obj.errors, function(k, v) {
                responseDetail = responseDetail + '<li>' + v.join(', ') + '</li>';
            });
            responseDetail = responseDetail + '</ul>';

            errorSelector.html('<div class="alert alert-danger"><b>' + response + '</b> ' + responseDetail+  '</div>');
        }
    }).done(function() {
        dropdown.val(selected);
    });
}