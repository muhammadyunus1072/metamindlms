<script>
    function action_favorite(id, view){
        loading('show')

        var url = "{{ route('course.store_favorite') }}";

		var file_data = new FormData();
		file_data.append('course_id', id);

		$.ajax({
            url: url,
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            data: file_data,
            success: function(result) {
                loading('hide')

                if (result['st'] == 's'){
                    change_icon_favorite(result['d'], view);
                }
                else {
                    info_server('error', result['s']);
                }
                // reload_navbar();
            },
            error: function(xhr, res, result) {
                loading('hide')
                alert_error("show", xhr);
            }
        });
    }
</script>