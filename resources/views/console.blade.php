<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Console</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        .logo {
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        #displays-section, #files-section {
            transition: opacity 0.5s;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-blue-200 to-blue-300 flex h-screen">
    <div class="bg-blue-950 w-64 p-0 pt-10 flex flex-col justify-between py flex-shrink-0">
        <div>
            <div class="mb-10">
                <!-- Replace with your logo -->
                <img src="logo.png" alt="Logo" class="w-32 h-32 mx-auto logo">
            </div>
            <button class="bg-blue-800 hover:bg-blue-500 text-white font-bold py-2 px-0 rounded-none mb-0 w-full border-b border-blue-600" onclick='showDisplays()'>
                Displays
            </button>
            <button class="bg-blue-800 hover:bg-blue-500 text-white font-bold py-2 px-0 rounded-none mb-0 w-full border-b border-blue-600" onclick='showFiles()'>
                Files
            </button>
            <!-- <button class="bg-blue-800 hover:bg-blue-500 text-white font-bold py-2 px-0 rounded-none mb-0 w-full border-b border-blue-600" onclick='(function(){window.location="/logs";})()'>
                Logs
            </button> -->
        </div>
        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-0 rounded-none mb-0 w-full" onclick='(function(){window.location="/logout";})()'>
            Log out
        </button>
    </div>
    <div class="flex-grow bg-gradient-to-r from-white to-blue-200 relative">
        <div id='welcome-page' class="absolute top-0 left-0 w-full p-4 text-center pt-60">
            <h1 class="text-4xl font-bold mb-4">Display Control Panel</h1>
            <p class="text-xl">Welcome to the control panel. Control each individual displays here!</p>
        </div>
        <div id="displays-section" class="grid grid-cols-4 gap-4 p-4 pt-20" style="visibility: hidden">
            <button class="absolute top-4 left-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick='pingDisplays()'>
                Ping Displays
            </button>
            <!-- Displays will be inserted here -->
        </div>
        <div id="files-section" class="grid grid-cols-4 gap-4 p-4" style="visibility: hidden">
            <!-- Files will be inserted here -->
        </div>
    </div>
</body>

<script>
    var channels = [];

    function hideWelcomeDiv() {
        // Get the welcome div
        var welcomeDiv = document.getElementById('welcome-page');

        if(welcomeDiv)
        {
            // Fade out the welcome div
            welcomeDiv.style.opacity = '0';
            setTimeout(function() {
                welcomeDiv.style.visibility = 'hidden';

                // Remove the welcome div from the DOM
                welcomeDiv.remove();
            }, 500); // This should match the transition duration
        }
    }

    function showDisplays() 
    {
        // Get the sections
        var filesSectionDiv = document.getElementById('files-section');
        var displaysSectionDiv = document.getElementById('displays-section');

        // Hide the files section and the welcome div
        filesSectionDiv.style.opacity = '0';

        // Show the displays section with a fade effect
        displaysSectionDiv.style.visibility = 'visible';
        displaysSectionDiv.style.height = '0';
        hideWelcomeDiv();
        setTimeout(function() {
            displaysSectionDiv.style.opacity = '1';
        }, 50); // This delay is to ensure the visibility and height changes have taken effect
    }

    function showFiles()
    {
        // Define your mock files
        var files = ['File 1', 'File 2', 'File 3','File 32','File 454','File 5','File 3s','File 12','File 13'];

        // Get the files section div and clear its content
        var filesSectionDiv = document.getElementById('files-section');
        filesSectionDiv.innerHTML = '';

        // Add Tailwind CSS classes to make the div a grid container
        filesSectionDiv.className = 'grid grid-cols-4 gap-4 p-4';

        // Loop through the files and add them to the files section div
        files.forEach(function(file) {
            var fileDiv = document.createElement('div');
            fileDiv.textContent = file;

            // Add Tailwind CSS classes for styling
            fileDiv.className = 'bg-blue-800 p-4 rounded shadow text-white font-medium text-center';

            filesSectionDiv.appendChild(fileDiv);
        });

        // Hide the displays section and the welcome div
        var displaysSectionDiv = document.getElementById('displays-section');
        displaysSectionDiv.style.opacity = '0';

        // Show the files section with a fade effect
        filesSectionDiv.style.visibility = 'visible';
        filesSectionDiv.style.height = '0';
        hideWelcomeDiv();
        setTimeout(function() {
            filesSectionDiv.style.opacity = '1';
        }, 50); // This delay is to ensure the visibility and height changes have taken effect
    }

    // BUTTONS
    
    function pingDisplays()
    {
        var baseUrl = "{{ route('pingDisplays') }}";

        fetch(baseUrl)
            .catch(error => console.error('Error', error));
    }

    // EVENT RELATED CODES

    setTimeout(() =>
    {
        window.Echo.channel('Display-Page')
            .listen('.Display', (e) =>{
                var channel = {
                    name: e.guid,
                }

                channels.push(channel);
                addDisplayBox(e.guid);
            })
            .listen('.PongDisplay', (e) => {
                console.log(e.guid + 'PONGED!');
            });
        
            function addDisplayBox(displayName) {
                // Get the displays section div
                var displaysSectionDiv = document.getElementById('displays-section');

                // Create a new div for the display box
                var displayBoxDiv = document.createElement('div');
                displayBoxDiv.textContent = displayName;

                // Add Tailwind CSS classes for styling
                // These classes will create a larger box than the file boxes
                displayBoxDiv.className = 'bg-blue-200 p-10 rounded shadow-lg text-center relative';

                // Create the Image button
                var imageButton = document.createElement('button');
                imageButton.textContent = 'Image';
                imageButton.className = 'absolute bottom-4 left-1/4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded';
                imageButton.addEventListener('click', function() {
                    // Add your code here
                    var fileUrl = encodeURIComponent('/images/sample.jpg');

                    var baseUrl = "{{ route('displayContent', ['url' => 'sample.jpg', 'type' => 'image', 'guid' => 'tempFile']) }}";
                    var url = baseUrl.replace('tempFile', displayName);

                    fetch(url)
                        .catch(error => console.error('Error', error));
                });
                
                // Create the Video button
                var videoButton = document.createElement('button');
                videoButton.textContent = 'Video';
                videoButton.className = 'absolute bottom-4 right-1/4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded';
                videoButton.addEventListener('click', function() {
                    // Add your code here
                    var fileUrl = encodeURIComponent('/videos/sample.mp4');

                    var baseUrl = "{{ route('displayContent', ['url' => 'sample.mp4', 'type' => 'video', 'guid' => 'tempFile']) }}";
                    var url = baseUrl.replace('tempFile', displayName);

                    fetch(url)
                        .catch(error => console.error('Error', error));
                });

                // Add the buttons to the display box div
                displayBoxDiv.appendChild(imageButton);
                displayBoxDiv.appendChild(videoButton);

                // Add the display box div to the displays section div
                displaysSectionDiv.appendChild(displayBoxDiv);
            }
    }, 200);
</script>
</html>