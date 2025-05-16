@extends('layouts.app')


@section('content')

    <div class="container-fluid p-4 full-screen-table">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-dark">
                <tr>
                    <th class="text-center align-middle">name</th>
                    <th class="text-center align-middle">plate number</th>
                    <th class="text-center align-middle">status</th>
                    <th></th>
                </tr>
                </thead>

                @foreach($obj as $driver)
                    {{--        <td>{{$driver -> name}}</td>--}}
                    <tr>
                        <td>{{$driver -> user -> name}}</td>
                        <td>{{$driver -> plate_number}}</td>
                        @if($driver -> verified == true)
                            <td>verified</td>
                        @else
                            <td>suspended</td>
                        @endif
                        <td>
                            <form action="{{ route('admin.update', $driver->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH') <!-- Since you're updating a resource, use PATCH -->
                                <button type="submit" class="btn btn-success" {{ $driver->verified ? 'disabled' : '' }}
                                style="{{ $driver->verified ? 'background-color: grey; border-color: grey; cursor: not-allowed;' : '' }}" onclick="return confirm('Are you sure you want to verify this driver?')">
                                    Verify
                                </button>
                            </form>
                            <form action="{{ route('admin.update2', $driver->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH') <!-- Since you're updating a resource, use PATCH -->
                                <button type="submit" class="btn btn-primary" {{ !$driver->verified ? 'disabled' : '' }}
                                style="{{ !$driver->verified ? 'background-color: grey; border-color: grey; cursor: not-allowed;' : '' }}" onclick="return confirm('Are you sure you want to suspend this driver?')">
                                    suspend
                                </button>
                            </form>
                            <form action="{{ route('admin.destroy', $driver->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to block this driver?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Block</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection


