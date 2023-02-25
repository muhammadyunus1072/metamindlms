<script>
    $(function() {
        bsCustomFileInput.init();

        $('#url_video').trigger('change');
    });

    function refresh_video(){
        var url = $('#url_video').val();
        if(url.substring(0, 5) === 'https'){
            $('#video_trailer').attr('src', url);
        }
    }
</script>