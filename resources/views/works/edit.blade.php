@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1>Modify: {{ $work->name }}</h1>
    </div>
    <div class="container">
      <form action="{{ route('works.update',$work) }}" method="POST">
        @csrf
          @method('PUT')

          <div class="mb-3">
              <label for="name" class="form-label">Title</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$work->name) }}" id="name" aria-describedby="nameHelp">
              @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
              @enderror
            </div>
            
            <div class="mb-3">
              <label for="type-id" class="form-label">Type</label>
              <select class="form-select @error('type_id') is-invalid @enderror" id="type-id" name="type_id" aria-label="Default select example">
                <option value="" selected>Select Type</option>
                @foreach ($types as $type)
                  <option @selected( old('type_id', $work->type_id ) == $type->id ) value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
              </select>
              @error('type_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="technologies" class="form-label">Technologies</label>
              <div class="d-flex @error('technologies') is-invalid @enderror flex-wrap gap-3">
                
                @foreach($technologies as $key => $technology)
                  <div class="form-check">
                    <input name="technologies[]" @checked( in_array($technology->id, old('technologies',$work->getTechnologyIds()) ) ) class="form-check-input" type="checkbox" value="{{ $technology->id }}" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                      {{ $technology->name }}
                    </label>
                  </div>
                @endforeach
              </div>
              @error('technologies')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description">{{ old('description',$work->description) }}</textarea>
              @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection