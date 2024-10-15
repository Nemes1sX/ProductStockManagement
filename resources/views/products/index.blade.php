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
            <div>
                <div class="p-2">
                    <nav id="paginationNav" aria-label="Page navigation example">
                        <ul class="pagination">
                            <!-- Previous Button -->
                            <li class="page-item" id="previousPage">
                                <a href="#" class="page-link">Previous</a>
                            </li>
            
                            <!-- First Page -->
                           <li class="page-item" id="page1">
                                <a href="#" class="page-link">1</a>
                            </li>
            
                            <!-- Left Ellipsis -->
                            <li class="page-item d-none" id="leftEllipsis">
                                <a href="#" class="page-link">...</a>
                            </li>
            
                            <!-- Dynamic Page Numbers -->
                            <li class="page-item d-none" id="pageBeforePrevious">
                                <a href="#" class="page-link"></a>
                            </li>
                            <li class="page-item d-none" id="previous">
                                <a href="#" class="page-link"></a>
                            </li>
                            <li class="page-item" id="currentPage">
                                <a href="#" class="page-link"></a>
                            </li>
                            <li class="page-item d-none" id="next">
                                <a href="#" class="page-link"></a>
                            </li>
                            <li class="page-item d-none" id="pageAfterNext">
                                <a href="#" class="page-link"></a>
                            </li>
            
                            <!-- Right Ellipsis -->
                            <li class="page-item d-none" id="rightEllipsis">
                                <a href="#" class="page-link">...</a>
                            </li>
            
                            <!-- Last Page -->
                            <li class="page-item" id="lastPage">
                                <a href="#" class="page-link"></a>
                            </li>
            
                            <!-- Next Button -->
                            <li class="page-item" id="nextPage">
                                <a href="#" class="page-link">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
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

       

            let currentPage = 1;
    let totalPages = 10; // Set this dynamically based on your backend response.

    function paginate(page) {
        if (page < 1 || page > totalPages) return; // Prevent out-of-bound page numbers

        currentPage = page;

        // Update UI
        renderPagination();
        loadProducts(page); // Your function to load data for the current page
    }

    function renderPagination() {
        // Update "Previous" button
        $('#previousPage').toggleClass('disabled', currentPage === 1);
        $('#nextPage').toggleClass('disabled', currentPage === totalPages);

        // Update first page link
        $('#page1').toggleClass('active', currentPage === 1);
        $('#currentPage').toggleClass('active not-clickable', currentPage === currentPage);
        $('#currentPage').toggleClass('d-none', currentPage === 1 || currentPage == totalPages);

        // Update dynamic page numbers and ellipsis
        $('#leftEllipsis, #pageBeforePrevious').toggleClass('d-none', currentPage <= 3);
        $('#previous').toggleClass('d-none', currentPage <= 2);
        $('#rightEllipsis, #pageAfterNext').toggleClass('d-none', currentPage >= totalPages - 2);
        $('#next').toggleClass('d-none', currentPage >= totalPages - 1);
        

        if (currentPage - 1 >= 1) {
            $('#previous a').text(currentPage - 1);
        }
        if (currentPage + 1 < totalPages) {
            $('#next a').text(currentPage + 1);
        }
        if (currentPage - 2 > 1) {
            $('#pageBeforePrevious a').text(currentPage - 2);
        }
        if (currentPage + 2 < totalPages) {
            $('#pageAfterNext a').text(currentPage + 2);
        }

        // Update current page number
        $('#currentPage a').text(currentPage);

        // Update last page link
        $('#lastPage a').text(totalPages).toggleClass('active', currentPage === totalPages);
    }

    // Bind click events for pagination
    $('#paginationNav').on('click', '.page-link', function (e) {
        e.preventDefault();
        let pageText = $(this).text();

        if (pageText === 'Previous') {
            paginate(currentPage - 1);
        } else if (pageText === 'Next') {
            paginate(currentPage + 1);
        } else {
            paginate(parseInt(pageText));
        }
    });

    // Initial pagination rendering
    renderPagination();

    function loadProducts(page = 1) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('product.api.index') }}?page=" + page,
                    datatype: 'JSON',
                    success: function(result) {
                        currentPage = result.current_page;
                        totalPages = result.total_pages;
                        console.log(currentPage, totalPages);
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

            /*function renderPagination(data) {
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
            }*/
            });
    </script>
@endsection
