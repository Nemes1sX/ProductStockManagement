@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2 class="text-center">Products list</h2>
                </div>
                <div class="pull-right mb-2">
                </div>
            </div>
        </div>
        <div class="products-table">
            <table class="table table-responsive" id="tableResults">
                <thead>
                    <th>SKU</th>
                    <th>Description</th>
                    <th>Size</th>
                    <th>Photo</th>
                    <th>Stock</th>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="products-pagination"></div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            /*$.ajax({
                type: 'GET',
                url: "{{ route('product.api.index') }}",
                datatype: 'JSON',
                success: function (result) {
                    console.log(result.data);
                    let tableData = "";
                    $.each(result.data, function (index, data) {
                        let productUrl = "{{ route('product.show', ':id') }}";
                        productUrl = productUrl.replace(':id', data.id);
                        tableData += "<tr>";
                        tableData += "<td><a href="+productUrl+">" + data.sku + "</td>";
                        tableData += '<td><img src="'+data.photo+'" alt="Image" width="150" height="150"></td>';
                        tableData += "<td>" + data.size + "</td>";
                        tableData += "<td>" + data.description + "</td>";
                        if (data.stocks_count > 0) {
                            tableData += "<td>" + data.stocks_count + "</td>";
                        } else {
                            tableData += "<td>Out of stock</td>";
                        }
                        tableData += "</tr>";
                    });
                    $('#tableResults').append(tableData);
                }*/

            loadProducts();

            function loadProducts(page = 1) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('product.api.index') }}?page=" + page,
                    datatype: 'JSON',
                    success: function(result) {
                        renderProducts(result.data);
                        renderPagination(result);
                    }
                });
            }


            function renderProducts(products) {
                let tableData = "";
                $.each(products, function(index, data) {
                    let productUrl = "{{ route('product.show', ':id') }}";
                    productUrl = productUrl.replace(':id', data.id);
                    tableData += "<tr>";
                    tableData += "<td><a href=" + productUrl + ">" + data.sku + "</a></td>";
                    tableData += '<td><img src="' + data.photo +
                        '" alt="Image" width="150" height="150"></td>';
                    tableData += "<td>" + data.size + "</td>";
                    tableData += "<td>" + data.description + "</td>";
                    tableData += "<td>" + (data.stocks_count > 0 ? data.stocks_count : "Out of stock") +
                        "</td>";
                    tableData += "</tr>";
                });
                $('#tableResults tbody').html(tableData);
            }

            function renderPagination(data) {
                let pagination = '';
                if (data.last_page > 1) {
                    pagination += '<nav><ul class="pagination">';
                    if (data.prev_page_url) {
                        pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + (data
                            .current_page - 1) + '">Previous</a></li>';
                    }
                    for (let i = 1; i <= data.last_page; i++) {
                        pagination += '<li class="page-item ' + (data.current_page === i ? 'active' : '') +
                            '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                    }
                    if (data.next_page_url) {
                        pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + (data
                            .current_page + 1) + '">Next</a></li>';
                    }
                    pagination += '</ul></nav>';
                    
                }
                $('.products-pagination').html(pagination);
                

                $('.pagination a').on('click', function(e) {
                    e.preventDefault();
                    let page = $(this).data('page');
                    loadProducts(page);
                });
            }
            });
    </script>
@endsection
