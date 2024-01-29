<script>
    function action_product_cart(id, is_buy_now = false) {
        loading('show')

        var url = "{{ route('course.store_product_to_cart') }}";

        var file_data = new FormData();
        file_data.append('product_id', id);

        $.ajax({
            url: url,
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            data: file_data,
            success: function(result) {
                loading('hide')
                if (result['st'] == 's') {
                    if (is_buy_now) {
                        var routeUrl = "{{ route('member.cart.index') }}";
                        window.location.href = routeUrl;
                    } else {
                        info_server('success', result['s']);
                    }
                    livewire.emit('refreshNotification');
                } else {
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
