{{--
    Form logout tersembunyi (POST + token CSRF).
    Tautan "Logout" di halaman ini mengirim form lewat JavaScript, jadi
    logout tidak bisa dipicu otomatis dari halaman atau situs lain.
    Bila JavaScript dimatikan, tautan tetap aman karena hanya membuka
    halaman konfirmasi (GET /logout).
--}}
<form id="logout-form" method="POST" action="{{ route('logout') }}" hidden>
    @csrf
</form>

<script>
    document.addEventListener('click', function (event) {
        var tautan = event.target.closest('[data-logout]');

        if (!tautan) {
            return;
        }

        if (tautan.dataset.logout === 'konfirmasi'
            && !confirm('Yakin ingin keluar?')) {
            return;
        }

        event.preventDefault();
        document.getElementById('logout-form').submit();
    });
</script>
