<!-- Modal Edit Buku -->
<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('catalog.update', $book->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBookModalLabel">Edit Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Judul Buku -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $book->title }}" required>
                    </div>
                    <!-- Penulis -->
                    <div class="mb-3">
                        <label for="author" class="form-label">Penulis</label>
                        <input type="text" class="form-control" id="author" name="author" value="{{ $book->author }}" required>
                    </div>
                    <!-- Penerbit -->
                    <div class="mb-3">
                        <label for="publisher" class="form-label">Penerbit</label>
                        <input type="text" class="form-control" id="publisher" name="publisher" value="{{ $book->publisher }}">
                    </div>
                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $book->description) }}</textarea>
                    </div>
                    <!-- Kategori -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <input type="text" class="form-control" id="category" name="category" value="{{ $book->category }}" required>
                    </div>
                    <!-- Stok -->
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ $book->stock }}" required min="0">
                    </div>
                    <!-- Gambar -->
                    <div class="mb-3">
                        <label for="book_image" class="form-label">Unggah Gambar Baru</label>
                        <input type="file" class="form-control" id="book_image" name="book_image">
                    </div>
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Atau Masukkan URL Gambar Baru</label>
                        <input type="url" class="form-control" id="image_url" name="image_url" value="{{ $book->image_path }}">
                    </div>
                    <!-- Gambar Saat Ini -->
                    @if ($book->image_path)
                        <div class="mb-3">
                            <label for="current_image" class="form-label">Gambar Saat Ini</label>
                            <div>
                                <img src="{{ $book->image_path }}" alt="{{ $book->title }}" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
