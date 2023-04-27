@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex align-items-center">
            <div class="me-auto mt-4">
                <h1>
                    {{ $work->name }}
                    @if($work->type)
                        <span class="badge rounded-pill bg-warning">{{ $work->type->name }}</span>
                    @else
                        <span class="badge rounded-pill bg-secondary">No Type</span>
                    @endif
                </h1>
                <p>/{{ $work->slug }}</p>
                <div>
                    @forelse( $work->technologies as $technology )
                        <span class="badge rounded-pill text-bg-light">{{ $technology->name }}</span>
                    @empty
                        -
                    @endforelse
                </div>
            </div>

            <div class="d-flex">
                <a class="btn btn-sm btn-secondary" href="{{ route('works.edit',$work) }}">Edit</a>
                @if($work->trashed())
                    <form form action="{{ route('works.restore',$work) }}" method="POST">
                        @csrf
                        <input class="btn btn-sm btn-success" type="submit" value="Restore">
                    </form>
                @endif
            </div>
            
        </div>
    </div>
    <div class="container">
        <p>
            {{ $work->description }}
        </p>
    </div>
@endsection