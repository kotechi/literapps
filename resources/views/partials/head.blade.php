<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ isset($title) && filled($title) ? $title.' - Literapps' : 'Literapps' }}</title>

<link rel="icon" href="/logo.svg" type="image/svg+xml">
<link rel="shortcut icon" href="/logo.svg" type="image/svg+xml">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])

<script>
	if (! window.localStorage.getItem('flux.appearance')) {
		window.localStorage.setItem('flux.appearance', 'light');
	}
</script>

@fluxAppearance
