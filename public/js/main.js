function loading(action) {
    if (action == "show") {
        $.LoadingOverlay('show');
    }

    if (action == "hide") {
        $.LoadingOverlay('hide');
    }
}

function alert_error(error, xhr){
    if (error == "show") {
        Swal.fire('Gagal!', 'Terjadi kesalahan dalam memproses, harap menghubungi Administrator' + xhr.responseText, 'error');
    }

    if (error == "hide") {
        Swal.fire('Gagal!', 'Terjadi kesalahan dalam memproses, harap menghubungi Administrator', 'error');
    }
}