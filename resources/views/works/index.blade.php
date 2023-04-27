@extends('layouts.app')

@section('content')
    @if(request()->session()->exists('message'))

        <div class="alert alert-primary" role="alert">
            {{ request()->session()->pull('message') }}
        </div>

    @endif
    <div class="container py-5">
        <div class="d-flex align-items-center gap-2">
            <h1 class="me-auto">All work</h1>

            <div>
                @if(request('trashed'))
                    <a class="btn btn-sm btn-light" href="{{ route('works.index') }}">All work</a>
                @else
                    <a class="btn btn-sm btn-light" href="{{ route('works.index',['trashed' => true]) }}">Trash ({{ $num_of_trashed}})</a>
                @endif
                <a class="btn btn-sm btn-primary" href="{{ route('works.create') }}">New work</a>
            </div>
        </div>
    </div>

    <div class="container">
      <table class="table table-striped table-inverse table-responsive">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Description</th>
            <th>Slug</th>
            <th>Technology</th>
            <th>Creation data</th>
            <th>Change data</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($works as $work)
              <tr>
                <td>{{ $work->id }}</td>
                <td>
                    <a href="{{ route('works.show',$work) }}">{{ $work->name }}</a>
                </td>
                <td>{{ $work->type ? $work->type->name : '-' }} </td>
                <td>{{ $work->description }}</td>
                <td>{{ $work->slug }}</td>
                <td>
                  @forelse($work->technologies()->orderBy('name','asc')->get() as $technology )
                    <span class="badge rounded-pill text-bg-light">{{ $technology->name }}</span>
                  @empty
                    -
                  @endforelse
                </td>
                <td>{{ $work->created_at->format('d/m/Y') }}</td>
                <td>{{ $work->updated_at->format('d/m/Y') }}</td>
                <td>
                    <div class="d-flex gap-2">
                        <a class="btn btn-sm btn-secondary" href="{{ route('works.edit',$work) }}">Edit</a>
                        <form action="{{ route('works.destroy',$work) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input class="btn btn-sm btn-danger" type="submit" value="Delete">
                        </form>
                        @if($work->trashed())
                          <form action="{{ route('works.restore',$work) }}" method="POST">
                            @csrf
                            <input class="btn btn-sm btn-success" type="submit" value="Restore">
                          </form>
                        @endif
                    </div>
                </td>
              </tr>
          @empty
            <tr>
              <th colspan="6">No works found</th>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
@endsection