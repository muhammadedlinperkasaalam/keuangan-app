<?php
require __DIR__ .'/includes/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    set_flash('success', 'Form diterima! Token CSRF cocok.');
    redirect('demo-layout.php');
}

$judul = 'Demo Layout';
include ROOT_PATH . '/layouts/header.php';
?>
<div class="card p-4">
    <h4>Uji Helper &amp; Layout (PART 2)</h4>
    <P>rupiah(1250000) &rarr; <b><?= rupiah(1250000) ?></b></P>
    <P>tgl('2026-10-31') &rarr; <b><?= tgl('2026-10-31') ?></b></P>
    <P>e('&lt;script&gt;') &rarr; <b><?= e('<script>') ?></b> (tampil sebagai teks, bukan dieksekusi)</P>
    <P>url('dompet/') &rarr; <b><?= url('dompet/') ?></b></P>
    <form method="post" class="form-hapus">
        <?= csrf_field() ?>
        <button class="btn btn-primary">Kirim (uji SCRF + flash message)</button>
    </form>
</div>
<?php include ROOT_PATH . '/layouts/footer.php';