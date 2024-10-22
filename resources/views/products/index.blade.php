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

            loadProducts();
            let currentPage = 1;
            let totalPages = 10; 

            function paginate(page) {
                if (page < 1 || page > totalPages) return;

                currentPage = page;

                renderPagination();
                loadProducts(page);
            }

            function renderPagination() {
                $('#previousPage').toggleClass('disabled', currentPage === 1);
                $('#nextPage').toggleClass('disabled', currentPage === totalPages);

                $('#page1').toggleClass('active', currentPage === 1);
                $('#currentPage').toggleClass('active not-clickable', currentPage === currentPage);
                $('#currentPage').toggleClass('d-none', currentPage === 1 || currentPage == totalPages);

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

                $('#currentPage a').text(currentPage);

                $('#lastPage a').text(totalPages).toggleClass('active', currentPage === totalPages);
            }

            $('#paginationNav').on('click', '.page-link', function(e) {
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
        });
    </script>
@endsection
