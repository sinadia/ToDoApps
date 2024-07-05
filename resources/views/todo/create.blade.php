@extends('layouts.admin.app')

@section('title', 'Buat Catatan & Kategori')

@section('content')
<div class="container mt-5">
    <h2>Buat Catatan</h2>
    <form method="POST" action="/todo/store">
        @csrf

        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <select class="form-select" name="todo_category_id" id="todo_category_id">
                <option value="">Pilih Kategori</option> 
                @foreach ($todocategories as $value)
                    <option value="{{ $value->id }}">{{ $value->category }}</option>
                @endforeach
            </select>

            <div id="newCategoryInput" style="display: none;">
                <input type="text" class="form-control mt-2" id="new_category" name="new_category" placeholder="Nama Kategori Baru">
            </div>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <input type="text" class="form-control" id="description" name="description">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    const categorySelect = document.getElementById('todo_category_id');
    const newCategoryInput = document.getElementById('newCategoryInput');

    categorySelect.addEventListener('change', function() {
        if (this.value === 'new') {
            newCategoryInput.style.display = 'block';
        } else {
            newCategoryInput.style.display = 'none';
        }
    });
</script>

@endsection
