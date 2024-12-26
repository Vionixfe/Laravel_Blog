let submit_method;

$(document).ready(function () {
    writerTable();
});

// datatable serverside
function writerTable() {
    $('#yajra').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        // pageLength: 20, // set default records per page
        ajax: "/admin/writers/serverside",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'is_verified',
                name: 'is_verified'
            },
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },
        ]
    });
};

// form create
const modalWriter = () => {
    submit_method = 'create';
    resetForm('#formWriter');
    resetValidation();
    $('#modalWriter').modal('show');
    $('.modal-title').html('<i class="fa fa-plus"></i> Create Writer');
    $('.btnSubmit').html('<i class="fa fa-save"></i> Save');
}

$('#formUpdateWriter').on('submit', function (e) {
    e.preventDefault();
    console.log("Form submitted via AJAX"); // Log untuk memastikan AJAX dijalankan
    startLoading();

    let id = $('#id').val();
    if (!id) {
        stopLoading();
        console.error("ID is missing");
        toastError("Error: ID is missing");
        return;
    }

    let url = '/admin/writers/' + id;
    const inputForm = new FormData(this);
    inputForm.append('_method', 'PUT');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: url,
        data: inputForm,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log("Success callback triggered"); // Debug log untuk memastikan callback dijalankan
            stopLoading();

            // Memastikan Swal tersedia dan berjalan
            if (typeof Swal !== "undefined") {
                Swal.fire({
                    icon: 'success',
                    title: "Success!",
                    text: response.message,
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.replace('/admin/writers'); // Redirect ke halaman utama
                    }
                });
            } else {
                alert("Success! " + response.message); // Fallback jika Swal tidak tersedia
                window.location.replace('/admin/writers');
            }
        },
        error: function (jqXHR) {
            stopLoading();
            console.log("Error Details:", jqXHR.responseText);
            if (typeof toastError === "function") {
                toastError("Error: " + jqXHR.status + ' ' + jqXHR.statusText);
            } else {
                alert("Error: " + jqXHR.status + ' ' + jqXHR.statusText);
            }
        }
    });
});






const deleteData = (e) => {
    let id = e.getAttribute('data-id');

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete this Writer?",
        icon: "question",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        allowOutsideClick: false,
        showCancelButton: true,
        showCloseButton: true
    }).then((result) => {
        if (result.value) {
            startLoading();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "DELETE",
                url: "/admin/writers/" + id,
                dataType: "json",
                success: function (response) {
                    stopLoading();
                    reloadTable();
                    toastSuccess(response.message);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    })
}

// Fungsi untuk mengedit status verifikasi writer
const editVerified = (e) => {
    let id = e.getAttribute('data-id');

    if (typeof startLoading === 'function') startLoading();
    console.log("AJAX request started for ID:", id);

    $.ajax({
        type: "GET",
        url: "/admin/writers/" + id,
        success: function (response) {
            console.log("Data received: ", response);
            let parsedData = response.data;

            if (parsedData) {
                $('#modalVerified').modal('show');
                $('#id').val(parsedData.id);
                // Mengatur nilai input is_verified, jika tidak ada nilai, biarkan kosong
                $('#is_verified').val(parsedData.is_verified ? parsedData.is_verified : ''); 
            } else {
                toastError("Data not found");
            }
        },
        error: function (jqXHR) {
            console.log("AJAX Error: ", jqXHR.responseText);
            toastError("Error: " + jqXHR.responseText);
        },
        complete: function () {
            stopLoading();
            console.log("AJAX request completed");
        }
    });
};

$('#formWriter').on('submit', function (e) {
    e.preventDefault(); // Mencegah reload halaman
    console.log("Form submitted via AJAX"); // Debugging: Pastikan form submit terpicu
    startLoading();

    let id = $('#id').val();
    if (!id) {
        stopLoading();
        console.error("ID is missing");
        toastError("Error: ID is missing");
        return;
    }

    let url = '/admin/writers/' + id + '/verified'; // Sesuai dengan definisi rute
    const inputForm = new FormData(this);
    inputForm.append('_method', 'PATCH'); // Tambahkan _method untuk mengubah POST menjadi PATCH

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST', // Tetap menggunakan POST, tapi dengan _method PATCH
        url: url,
        data: inputForm,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log("Success callback triggered");
            stopLoading();

            // Gunakan SweetAlert untuk menampilkan pesan sukses
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: response.message,
            }).then((result) => {
                // Setelah pengguna menutup alert, redirect ke halaman index
                if (result.isConfirmed) {
                    window.location.href = '/admin/writers'; // Ganti dengan URL halaman index Anda
                }
            });
        },
        error: function (jqXHR) {
            stopLoading();
            console.log("Error Details:", jqXHR.responseText);
            toastError("Error: " + jqXHR.status + ' ' + jqXHR.statusText); // Menampilkan pesan error
        }
    });
});










