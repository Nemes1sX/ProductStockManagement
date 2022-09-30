@extends('layouts.app')

@section('content')
<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Products list</h2>
            </div>
            <div class="pull-right mb-2">
            </div>
        </div>
    </div>
    <div class="products-table">
    </div>
</div>
@endsection
<script type="text/javascript">
    $(document).ready(function () {
       /*let htmlData = "<table class='table table-bordered'>" +
           <thead>
           <tr>
               <th>S.No</th>
               <th>Company Name</th>
               <th>Company Email</th>
               <th>Company Address</th>
               <th width="280px">Action</th>
           </tr>
           </thead>
           <tbody>
           <tr>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td>
           </td>
           </tr>
           </tbody>
       </table>";*/
       $.ajax({
            type: 'GET',
            url: "{{ route('product.api.index') }}",
            datatype: 'JSON',
            success: function (result) {
                console.log(result);
            }
       });
    });
</script>
