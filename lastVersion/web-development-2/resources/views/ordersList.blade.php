@extends('layouts.app')


@section('content')

    <div class="container-fluid p-4 full-screen-table">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">
                <tr>
                    <td>id</td>
                    <td>name</td>
                    <td>status</td>
                </tr>
                @foreach($obj as $order)
                    <tr>
                        <td>{{$order -> id}}</td>
                        <td>{{$order -> product -> name}}</td>
                        <td>
                            @if($order->status === 'pending')
                                <span class="label label-warning">Pending</span>
                            @elseif($order->status === 'active')
                                <span class="label label-info">Active</span>
                            @else($order->status === 'completed')
                                <span class="label label-success">Completed</span>
                            @endif
                        </td>

                    </tr>

                @endforeach
            </table>
        </div>
    </div>



@endsection
