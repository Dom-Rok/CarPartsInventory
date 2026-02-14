<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @routes
        @vite(['resources/scss/app.scss', 'resources/js/app.ts'])
        @inertiaHead
      
    </head>
    <body>
        @inertia
    </body>
</html>