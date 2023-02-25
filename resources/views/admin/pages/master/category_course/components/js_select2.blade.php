<script>
    $('#group_category_course_id').select2({
        placeholder: "Pilih Grup Kategori",
        ajax: {
            url: "{{ $list_route['search_group_category'] }}",
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
                            "text": item.name,
                            "id": item.enc_id,
                            "data": item
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