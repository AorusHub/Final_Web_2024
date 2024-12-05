<!-- Modal Tambah Buku -->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('catalog.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookModalLabel">Tambah Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Judul Buku -->
                    <div class="form-group mb-3">
                        <label for="title">Judul Buku</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <!-- Penulis -->
                    <div class="form-group mb-3">
                        <label for="author">Penulis</label>
                        <input type="text" class="form-control" id="author" name="author" required>
                    </div>
                    <!-- Penerbit -->
                    <div class="form-group mb-3">
                        <label for="publisher">Penerbit</label>
                        <input type="text" class="form-control" id="publisher" name="publisher">
                    </div>
                    <!-- Deskripsi -->
                    <div class="form-group mb-3">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>
                    <!-- Stok -->
                    <div class="form-group mb-3">
                        <label for="stock">Stok</label>
                        <input type="number" class="form-control" id="stock" name="stock" min="0" required>
                    </div>
                    <!-- Kategori -->
                    <div class="form-group mb-3">
                        <label for="category">Kategori</label>
                        <input type="text" class="form-control" id="category" name="category" required>
                    </div>
                    <!-- Gambar Buku -->
                    <div class="form-group mb-3">
                        <label for="book_image">Unggah Gambar Buku</label>
                        <input type="file" class="form-control" id="book_image" name="book_image">
                    </div>
                    <!-- URL Gambar -->
                    <div class="form-group mb-3">
                        <label for="image_url">Atau Masukkan URL Gambar</label>
                        <input type="url" class="form-control" id="image_url" name="image_url">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
