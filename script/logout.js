function logoutconfirm() {
    Swal.fire({
        icon: 'warning',
        title: 'Logout',
        text: 'Yakin Ingin Keluar ?',
        showConfirmButton: true,
        confirmButtonText: 'Keluar',
        showCancelButton: true,    // WAJIB agar tombol Batal muncul
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {   // gunakan isConfirmed (nama yang benar)
            window.location.href = "login.php";
        }
    });
}
