$('.delete_product').on('click', function (e) {
    e.preventDefault();

    var id = $(this).data('id');
    const href = $(this).attr('href');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6s',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reject it!'
    }).then((result) => {
        if (result.value) {
            document.location.href = href;
        }

    });

});