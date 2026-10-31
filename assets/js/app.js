// konfirmasi sebelum hapus: tambahkan class "form hapus" pada <form>
document.querySelectorAll('.form-hapus').forEach(function (f) {
    f.addEventListener('submit', function (ev) {
        if (!confirm('Yakin ingin menghapus data ini ?')) ev.preventDefault();
    });
});