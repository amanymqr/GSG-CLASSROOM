@if (session('msg'))
<div class="container">
    <div class="alert mt-4 alert-{{ session('type') }}" id="flash-msg">
        {{ session('msg') }}
    </div>
</div>
<script>
    setTimeout(function() {
        document.getElementById("flash-msg").remove();
    }, 2000); // 10 seconds
</script>
@endif
