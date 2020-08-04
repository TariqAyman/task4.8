@extends('layouts.app')

@section('title', 'Products')

@section('content')

    <div class="container products">

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif

        <div class="form-group">
            <input type="text" name="product_name" id="product_name" class="form-control input-lg" placeholder="Enter Product Name" autocomplete="off"/>
            <div id="countryList">
            </div>
        </div>
        {{ csrf_field() }}

        <div id="list">
            @include('list',$products)
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#product_name').keyup(function () {
                $('#list').html("<div class=\"loader\"></div>");
                var query = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('products.search') }}",
                    method: "POST",
                    data: {query: query, _token: _token},
                    success: function (data) {
                        $('#list').html("");
                        $('#list').html(data);
                    }
                });
            });
        });
    </script>
@endsection
