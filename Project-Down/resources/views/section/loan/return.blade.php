<div class="modal fade" id="returnModal{{ $loan->id }}" tabindex="-1" aria-labelledby="returnModalLabel{{ $loan->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('loans.return', $loan->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="returnModalLabel{{ $loan->id }}">Konfirmasi Pengembalian Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah buku ini dikembalikan tepat waktu atau terlambat?</p>

                    <!-- Pilihan Tepat Waktu atau Terlambat -->
                    <div class="form-check">
                        <input class="form-check-input on-time-choice" type="radio" name="on_time" id="onTime{{ $loan->id }}" value="yes" checked>
                        <label class="form-check-label" for="onTime{{ $loan->id }}">Tepat Waktu</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input on-time-choice" type="radio" name="on_time" id="late{{ $loan->id }}" value="no">
                        <label class="form-check-label" for="late{{ $loan->id }}">Terlambat</label>
                    </div>

                    <!-- Input jumlah hari keterlambatan -->
                    <div id="lateDaysInput{{ $loan->id }}" class="mt-3" style="display: none;">
                        <label for="late_days{{ $loan->id }}" class="form-label">Jumlah Hari Terlambat</label>
                        <input type="number" class="form-control" id="late_days{{ $loan->id }}" name="late_days" min="1" placeholder="Masukkan jumlah hari">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Konfirmasi Pengembalian</button>
                </div>
            </form>
        </div>
    </div>
</div>