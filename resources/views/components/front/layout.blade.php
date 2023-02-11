<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ empty($title) ? '' : $title . ' | ' }} Clovercraft SMP</title>
    <x-front.document-head />
</head>

<body class="front">
    <section id="app" class="d-flex flex-row">
        <x-front.navigation />
        <main id="page" class="flex-grow-1">
            <!-- #Begin Content -->
            {{ $slot }}
            <!-- #End Content -->
        </main>
    </section>
    <x-extras.extras />
    <div id="alertPlaceholder"></div>
    <input type="hidden" id="_token" value="{{ csrf_token() }}" />
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
