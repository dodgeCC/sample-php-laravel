@if (session('status'))
<div class="alert alert-{{ session('status')['type'] }} alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <p>{{ session('status')['message'] }}</p>
</div>
@endif
