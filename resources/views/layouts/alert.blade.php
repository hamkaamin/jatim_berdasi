<div class="col-12" id="container-alert"></div>

@if (session('success'))
<script>window._flashSuccess = @json(session('success'));</script>
@elseif(session('error'))
<script>window._flashError = @json(session('error'));</script>
@elseif($errors->any())
<script>window._flashErrors = @json($errors->all());</script>
@endif