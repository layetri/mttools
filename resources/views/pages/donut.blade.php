<html>
    @include('parts.head')
    <meta name="author" content="Layetri">
    <meta name="description" content="Donut is a DIY 12-voice polyphonic digital synthesizer.">
    <meta name="og:description" content="Donut is a DIY 12-voice polyphonic digital synthesizer.">
    <meta name="og:title" content="donut by layetri">


    <title>donut | layetri</title>
    <body>
        <div id="app">
            <donut-main></donut-main>
        </div>
        <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
    </body>
</html>