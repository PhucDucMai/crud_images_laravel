@extends('images.layout')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Laravel 8 CRUD with Image Upload Example from scratch - ItSolutionStuff.com</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('images.create') }}"> Create New Product</a>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Image</th>
        <th>Name</th>
        <th>Details</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($images as $product)
    <tr>
        <td>{{ ++$i }}</td>
        <td><img src="/image/{{ $product->image }}" width="100px"></td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->detail }}</td>
        <td>
            <form action="{{ route('images.destroy',$product->id) }}" method="POST">

                <a class="btn btn-info" href="{{ route('images.show',$product->id) }}">Show</a>

                <a class="btn btn-primary" href="{{ route('images.edit',$product->id) }}">Edit</a>

                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{!! $images->links() !!}

@endsection