<script>
    function show_trailer(id){
        loading('show')

        var url = "{{ route('course.show_trailer') }}";

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
                    var url = result['url_video'];

                    if(url.substring(0, 5) === 'https'){
                        $('#trailer_video_trailer').attr('src', url);
                    }
                    $('#trailer_modal').modal('show');
                }
                else {
                    info_server('error', result['s']);
                }
                
            },
            error: function(xhr, res, result) {
                loading('hide')
                alert_error("show", xhr);
            }
        });
    }
</script>