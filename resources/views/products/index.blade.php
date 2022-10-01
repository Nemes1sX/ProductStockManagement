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
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $.ajax({
            type: 'GET',
            url: "{{ route('product.api.index') }}",
            datatype: 'JSON',
            success: function (result) {
                console.log(result.data);
                let tableData = "";
                $.each(result.data, function (index, data) {
                    let productUrl = "{{route('product.show', ':id')}}";
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
            }
        });
    });
</script>
@endsection

