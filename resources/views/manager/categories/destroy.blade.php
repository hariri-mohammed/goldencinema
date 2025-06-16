<div class="content-list">
    <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="m{{ $category->id }}" tabindex="-1" aria-labelledby="Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3 fw-bold">Delete <strong
                                style="color:#e6ee0d;">{{ $category->name }}</strong>
                            Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body fs-6 fw-bolder">
                        Are you sure you want to delete?
                    </div>
                    <div class="modal-footer">
                        <button id="close-btn" type="button" class="btn btn-secondary fw-medium"
                            data-bs-dismiss="modal">No</button>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button id="yes-btn" type="submit" class="btn btn-danger fw-medium">Yes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
