
<h4>{{ $treatment->paciente->nome }}</h4>
<div class="text-center">
	<h4><strong>{{ $test->name }}</strong></h4>
	{{ $test->protocol->name }}
	<span class="text-muted">{{ $test->description }}</span>
</div>
