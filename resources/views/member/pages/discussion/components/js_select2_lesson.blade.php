<script>
    $('#lesson_id').select2({
        placeholder: "Pilih Pelajaran",
        ajax: {
            url: "{{ $list_route['search_lesson'] }}",
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
                            "text": item.title,
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