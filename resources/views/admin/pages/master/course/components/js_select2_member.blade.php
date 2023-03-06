<script>
    $('#add_member_course_member_id').select2({
        placeholder: "Pilih Member",
        ajax: {
            url: "{{ $list_route['search_member'] }}",
            dataType: "json",
            type: "GET",
            data: function(params) {
                return {
                    search: params.term,
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            "text": item.name + ' - ' + item.email,
                            "id": item.enc_id,
                        }
                    })
                };
            },
            error: function(xhr, res, result) {
                alert_error("hide", xhr);
            }
        },
        cache: true
    });

</script>