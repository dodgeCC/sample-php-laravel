<div class="modal fade" id="deleteItem" tabindex="-1" role="dialog" aria-labelledby="deleteItemLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST">
                @method('DELETE')
                @csrf
                <div class="modal-body">
                    <div class="form-group text-center">
                        <p class="lead"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
