<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            searching: false,
            order: [[0, 'asc']],
            columnDefs: [{ orderable: false, targets: 2 }],
        });
        getData();
    });

    $('.btn-get-data').click(function() {
        getData();
    });

    function esc(text) {
        return $('<div>').text(text ?? '').html();
    }

    function getData() {
        $('#loading-filter').show();
        var dataTableObj = $('#table').DataTable();
        dataTableObj.clear().draw();

        $.ajax({
            url: '{{ url("kategori/search") }}',
            dataType: 'json',
            tryCount: 0,
            retryLimit: 3,
            data: {
                kode: $('#filter-kode').val(),
                nama: $('#filter-nama').val(),
            },
            success: function(results) {
                $.each(results.data, function(index, item) {
                    var html =
                        `<a href="{{ url('kategori') }}/` + item.id + `" class="btn btn-primary btn-sm">View</a> ` +
                        `<a href="{{ url('kategori/form/edit') }}/` + item.id + `" class="btn btn-info btn-sm">Edit</a> ` +
                        `<a href="{{ url('kategori/delete') }}/` + item.id + `" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>`;

                    dataTableObj.row.add([esc(item.kode), esc(item.nama), html]);
                });
                dataTableObj.draw();
                $('#loading-filter').hide();
            },
            error: function(xhr, textStatus, errorThrown) {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    $.ajax(this);
                    return;
                }
                alert('Terjadi kesalahan server, tidak dapat mengambil data');
                $('#loading-filter').hide();
            }
        });
    }
</script>
