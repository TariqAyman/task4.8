@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table id="cart" class="table">
            <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th >Quantity</th>
                <th class="text-center">Subtotal</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php $total = 0 ?>
            @if(\Illuminate\Support\Facades\Cookie::get('cart'))
                @foreach( json_decode(\Illuminate\Support\Facades\Cookie::get('cart'),true) as $id => $details)
                    <?php $total += $details['price'] * $details['quantity'] ?>
                    <tr>
                        <td data-th="Product">
                            <div class="row">
                                <div class="col-sm-3 hidden-xs"><img src="{{ $details['photo'] }}" width="100" height="100" class="img-responsive"/></div>
                                <div class="col-sm-9">
                                    <h4 class="nomargin">{{ $details['name'] }}</h4>
                                </div>
                            </div>
                        </td>
                        <td data-th="Price">SAR {{ $details['price'] }}</td>
                        <td data-th="Quantity">
                            <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity"/>
                        </td>
                        <td data-th="Subtotal" class="text-center">${{ $details['price'] * $details['quantity'] }}</td>
                        <td class="actions" data-th="">
                            <button class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button>
                            <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                @endforeach
            @endif

            </tbody>
            <tfoot>
            <tr class="visible-xs">
                <td class="text-right"><strong>Total {{ $total }}</strong></td>
            </tr>
            <tr>
                <td><a href="{{ route('products') }}" class="btn btn-info"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                    <a href="{{ route('products') }}" class="btn btn-primary"><i class="fa fa-angle-right"></i> Checkout</a>
                    <a href="{{ route('empty-cart') }}" class="btn btn-primary"><i class="fa fa-angle-right"></i> Empty cart</a>
                </td>
                <td colspan="2" class="hidden-xs"></td>
                <td class="hidden-xs text-center"><strong>Total SAR {{ $total }}</strong></td>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection


@section('scripts')

    <script type="text/javascript">
        $(".update-cart").click(function (e) {
            e.preventDefault();
            var elment = $(this);
            $.ajax({
                url: '{{ route('update-cart') }}',
                method: "patch",
                data: {_token: '{{ csrf_token() }}', id: elment.attr("data-id"), quantity: elment.parents("tr").find(".quantity").val()},
                success: function (response) {
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var elment = $(this);
            if (confirm("Are you sure")) {
                $.ajax({
                    url: '{{ route('remove-from-cart') }}',
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: elment.attr("data-id")},
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>
@endsection
