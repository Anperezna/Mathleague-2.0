@php
	$imagenes = glob(public_path('images/*.{jpg,jpeg,png,gif}', GLOB_BRACE));
@endphp

<div style="display: flex; gap: 16px; flex-wrap: wrap; justify-content: center;">
	@foreach ($imagenes as $img)
		<img src="{{ asset('images/' . basename($img)) }}" alt="imagen" style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px; background: #eee;" />
	@endforeach
</div>
@php
	$imagenes = [
		'manolo.png',
		'mathbus.png',
		'mathentrevista.png',
		'mathmatch.png',
	]; // Pon aquí los nombres de tus imágenes
@endphp

<div style="display: flex; gap: 16px; flex-wrap: wrap; justify-content: center;">
	@foreach ($imagenes as $img)
		<div style="width: 200px; height: 200px; overflow: hidden; border-radius: 8px; background: #eee; display: flex; align-items: center; justify-content: center;">
			<img src="{{ asset('img/juegos' . $img) }}" alt="imagen" style="max-width: 100%; max-height: 100%; object-fit: cover;" />
		</div>
	@endforeach
</div>
