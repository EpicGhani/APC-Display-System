<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-black flex items-center justify-center h-screen">
    <div id="content" class="w-full h-full flex items-center justify-center text-white text-xl">
        <!-- GUID will be inserted here -->
    </div>

    <script>

        document.getElementById('content').textContent = '{{ $guid }}';

        setTimeout(() => 
        {
            window.Echo.channel('Display-Channel')
            .listen('.DisplayContent', (data) => {
                var content = document.getElementById('content');

                if(data.guid === '{{$guid}}')
                {

                    if (data.type === 'image') {
                        content.innerHTML = '<img src="/images/' + data.url + '" class="w-full h-full object-cover">';
                    } else if (data.type === 'video') {
                        content.innerHTML = '<video src="/videos/' + data.url + '" class="w-full h-full object-cover" autoplay loop muted></video>';
                    }

                    content.classList.add('opacity-0');
                    setTimeout(function() {
                        content.classList.remove('opacity-0');
                    }, 1000);
                }
            })
            .listen('.PingDisplay', (e) => 
            {
                var baseUrl = "{{ route('pongDisplays', ['guid' => 'placeholder']) }}";
                var url = baseUrl.replace('placeholder', '{{$guid}}');

                fetch(url)
                    .then(data => console.log(data))
                    .catch(error => console.error('Error', error));
            });
        }, 200)
    </script>
</body>
</html>