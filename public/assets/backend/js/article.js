let submit_method;

$(document).ready(function () {
    articleTable();
});

// datatable serverside
function articleTable() {
    $('#yajra').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        // pageLength: 20, // set default records per page
        ajax: "/admin/articles/serverside",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'category_id',
                name: 'category_id'
            },
            {
                data: 'tag_id',
                name: 'tag_id'
            },
            {
                data: 'views',
                name: 'views'
            },
            {
                data: 'published',
                name: 'published'
            },
            {
                data: 'is_confirm',
                name: 'is_confirm'
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

const deleteData = (e) => {
    let id = e.getAttribute('data-id');

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete this article?",
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
                url: "/admin/articles/" + id,
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

const editConfirm = (e) => {
    let uuid = e.getAttribute('data-id');

    if (typeof startLoading === 'function') startLoading();
    console.log("AJAX request started for ID:", uuid);

    $.ajax({
        type: "GET",
        url: "/admin/articles/" + uuid,
        success: function (response) {
            console.log("Data received: ", response);
            let parsedData = response.data;

            if (parsedData) {
                $('#modalConfirm').modal('show');
                $('#uuid').val(parsedData.uuid);
                $('#is_confirm').val(parsedData.is_confirm).change(); // Set nilai is_confirm sesuai data
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

$('#formConfirm').on('submit', function (e) {
    e.preventDefault(); // Mencegah reload halaman
    console.log("Form submitted via AJAX");
    startLoading();

    let uuid = $('#uuid').val();
    if (!uuid) {
        stopLoading();
        console.error("ID is missing");
        toastError("Error: ID is missing");
        return;
    }

    let url = '/admin/articles/' + uuid + '/confirm'; // Sesuai dengan definisi rute
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
                    window.location.href = '/admin/articles'; // Ganti dengan URL halaman index Anda
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







const deleteForceData = (e) => {
    let id = e.getAttribute('data-id');

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete permanently this article?",
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
                url: "/admin/articles/force-delete/" + id,
                dataType: "json",
                success: function (response) {
                    stopLoading();

                    Swal.fire({
                        icon: 'success',
                        title: "Success!",
                        text: response.message,
                    }).then(result => {
                        if (result.isConfirmed) {
                            window.location.href = '/admin/articles';
                        }
                    })
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    })
}
