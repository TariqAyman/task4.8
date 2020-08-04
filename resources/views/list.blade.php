<div class="row">
    @if($products->count())
        @foreach($products as $product)
            <div class="col-xs-18 col-sm-6 col-md-3">
                <div class="thumbnail">
                    <img src="{{ $product->photo }}" width="500" height="300">
                    <div class="caption">
                        <h4>{{ $product->name }}</h4>
                        <p><strong>Price: </strong> {{ $product->price }} SAR</p>
                        <p class="btn-holder"><a href="{{ url('add-to-cart/'.$product->id) }}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a></p>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <h2>
            Not Product Found
        </h2>
    @endif
</div>
<div class="pagination">
    {{ $products->render() }}
</div>
