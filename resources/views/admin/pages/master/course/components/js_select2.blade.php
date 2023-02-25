<script>
    $('#level_id').select2({
        placeholder: "Pilih Level",
        ajax: {
            url: "{{ $list_route['search_level'] }}",
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

    $('#category_id').select2({
        placeholder: "Pilih Kategori",
        ajax: {
            url: "{{ $list_route['search_category'] }}",
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
                            "id": item.code,
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