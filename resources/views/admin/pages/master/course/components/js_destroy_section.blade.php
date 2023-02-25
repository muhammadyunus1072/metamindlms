<script>
    function destroy_section(id){
        var url = "{{ $list_route['destroy_section'] }}" + id;

		var file_data = new FormData();
        r_action_table(file_data, "Apakah anda yakin ingin menghapus konten ini ?", url, 'redirect', null);
    }
</script>