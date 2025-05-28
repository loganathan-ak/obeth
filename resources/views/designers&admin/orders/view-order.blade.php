<x-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-10 mt-5 space-y-10">

        <!-- Order Summary Card -->
        <div class="w-full mx-auto bg-white shadow-xl rounded-2xl p-8 border border-gray-100 space-y-10">
            <!-- Title -->
            <div class="border-b pb-4">
                <h1 class="text-3xl font-extrabold text-gray-800">📝 Order Summary</h1>
            </div>

            <!-- Grid Fields (Short Dummy Data) -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6 text-gray-800">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Project Title</p>
                    <p class="text-base font-semibold">{{$order->project_title}}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Request Type</p>
                    <p class="text-base font-semibold">{{$order->request_type}}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Preferred Colors</p>
                    <p>{{$order->colors}}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Size</p>
                    <p>{{$order->size}}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Software</p>
                    <p>{{$order->software}}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Rush Request</p>
                    @if($order->rush === 1)
                    <span class="inline-block px-3 py-1 text-white text-xs font-semibold rounded-full bg-red-600">Yes</span>
                    @else
                    <span class="inline-block px-3 py-1 text-white text-xs font-semibold rounded-full bg-red-600">No</span>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Assigned To</p>
                    <p>{{$admins->where('id', $order->assigned_to)->first()->name ?? 'Unknown'}}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Create By</p>
                    <p>{{$subscribers->where('id', $order->created_by)->first()->name ?? 'Unknown'}} </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pre Approve</p>
                    <p>{{$order->pre_approve}}</p>
                </div>
            </div>

            <!-- Output Formats -->
            <div>
                <h4 class="text-sm font-semibold text-gray-500 mb-1">Output Formats</h4>
                <div class="flex flex-wrap gap-2 mt-1">
                    @php
                    $formats = json_decode($order->formats);
                @endphp
                
                @if(is_array($formats))
                    @foreach($formats as $format)
                        <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $format }}
                        </span>
                    @endforeach
                @endif
                
                </div>
            </div>

            <!-- Instructions -->
            <div>
                <h4 class="text-sm font-semibold text-gray-500 mb-1">Instructions</h4>
                <div class="mt-2 p-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 whitespace-pre-line">
                    {{$order->instructions}}
                </div>
            </div>
        </div>

        <!-- Work Preview + Chat Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Work Preview -->
            <div class="lg:col-span-2 bg-white shadow rounded-2xl p-6 border border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 mb-4">🎨 Work Previews</h2>
                <div class="revision-tool card p-5">

            <!-- Buttons Row -->
            <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
                <!-- Upload Button -->
                <div class="upload-section">
                    <input type="file" id="fileInput" style="display:none"
                        accept="image/jpeg, image/png, image/webp, image/bmp, image/tiff, image/svg+xml, application/pdf"
                        onchange="loadFile(event)">
                    <button class="btn btn-success" onclick="document.getElementById('fileInput').click()">
                        Upload Image or PDF
                    </button>
                </div>

                <!-- Draw Button -->
                <button class="btn btn-success" id="drawBtn" onclick="setMode('draw')">✏️ Draw</button>

                <!-- Erase Button -->
                <button class="btn btn-info" id="eraseBtn" onclick="setMode('erase')">🧹 Erase</button>

                <!-- Clear Button -->
                <button class="btn btn-danger" id="clearBtn" onclick="clearDrawings()">🗑️ Clear All Drawings</button>
            </div>


                <!-- Main Content -->
                <div class="row main-content">

                    <!-- Image Section -->
                    <div class="image-section position-relative" id="imageSection">
                    <canvas id="backgroundCanvas" style="position: absolute; top: 0; left: 0; z-index: 0;"></canvas>
                    <canvas id="drawingCanvas" style="position: absolute; top: 0; left: 0; z-index: 1;"></canvas>
                    </div>

                    <!-- Feedback Section -->
                    <div class="feedback-section mt-4">
                    <h4>Feedback:</h4>
                    <ol class="feedback-list" id="feedbackList"></ol>
                    <textarea id="feedbackInput" class="form-control mb-2" rows="3" placeholder="Enter your feedback..."></textarea>
                    <button class="submit-btn btn btn-danger" onclick="submitFeedback()">Add Points</button>
                    
                    </div>

                </div>

                <!-- Bottom Tools -->
                <div class="bottom-tools mt-4">
                    <div>Formatting Options:</div>
                    <div id="colorPicker" class="d-flex gap-2 mt-2">
                    <span class="color-circle" style="background:red" onclick="setColor('red')"></span>
                    <span class="color-circle" style="background:blue" onclick="setColor('blue')"></span>
                    <span class="color-circle" style="background:green" onclick="setColor('green')"></span>
                    <span class="color-circle" style="background:orange" onclick="setColor('orange')"></span>
                    <span class="color-circle" style="background:black" onclick="setColor('black')"></span>
                    </div>
                    <div class="mt-2">Color Picker</div>
                </div>

                </div>

            </div>

            <livewire:chatbox :order="$order" />


        </div>
            </div>


        </div>
    </div>






<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>

<script>
    function submitFeedback() {
      const feedbackInput = document.getElementById('feedbackInput').value.trim();
      if (feedbackInput) {
        const newFeedback = document.createElement('li');
        newFeedback.textContent = feedbackInput;
        document.getElementById('feedbackList').appendChild(newFeedback);
        document.getElementById('feedbackInput').value = ''; 
      } else {
        alert("Please enter some feedback.");
      }
    }

    let drawing = false, mode = "draw", img = new Image();
    let bgCanvas, bgCtx, drawCanvas, drawCtx, lastX, lastY;
    let drawColor = "red";
    let isImageUploaded = false;
    let currentView = 1;
    let autoNumber = 1;
    let markPoints = [];

    window.onload = () => {
        bgCanvas = document.getElementById('backgroundCanvas');
        drawCanvas = document.getElementById('drawingCanvas');
        [bgCtx, drawCtx] = [bgCanvas.getContext('2d'), drawCanvas.getContext('2d')];

        ['mousedown', 'mousemove', 'mouseup', 'mouseout'].forEach(event =>
            drawCanvas.addEventListener(event, handleMouse)
        );
        ['touchstart', 'touchmove', 'touchend'].forEach(event =>
            drawCanvas.addEventListener(event, handleTouch)
        );

        document.getElementById('fileInput').addEventListener('change', loadFile);

        drawCanvas.addEventListener('click', (e) => {
            if (currentView === 1 && mode === 'draw') {
                const pos = getPos(e);
                markPoints.push({ x: pos.x, y: pos.y, number: autoNumber });
                drawAutoCircle(pos.x, pos.y, autoNumber++);
            }
        });
    };

    function setColor(color) {
        drawColor = color;
    }

    function setMode(newMode) {
        mode = newMode;
        ['drawBtn', 'eraseBtn'].forEach(id => document.getElementById(id).classList.remove('active'));
        document.getElementById(newMode + 'Btn').classList.add('active');
        drawCanvas.style.cursor = newMode === 'draw' ? 'crosshair' : 'cell';
    }

    function getPos(e) {
        const rect = drawCanvas.getBoundingClientRect();
        return {
            x: (e.clientX - rect.left) * (drawCanvas.width / rect.width),
            y: (e.clientY - rect.top) * (drawCanvas.height / rect.height)
        };
    }

    function handleMouse(e) {
        // if (!isImageUploaded) {
        //     alert("Please upload an image or PDF.");
        //     return;
        // }

        const pos = getPos(e);

        if (e.type === 'mousedown') {
            drawing = true;
            [lastX, lastY] = [pos.x, pos.y];
        } else if (e.type === 'mousemove') {
            if (drawing) drawLine(pos);
        } else {
            drawing = false;
        }
    }

    function handleTouch(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const fakeMouseEvent = new MouseEvent(e.type.replace('touch', 'mouse'), {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        handleMouse(fakeMouseEvent);
    }

    function drawLine(pos) {
        drawCtx.beginPath();
        drawCtx.moveTo(lastX, lastY);
        drawCtx.lineTo(pos.x, pos.y);
        drawCtx.strokeStyle = drawColor;
        drawCtx.lineWidth = mode === "draw" ? 5 : 20;
        drawCtx.lineCap = drawCtx.lineJoin = "round";

        drawCtx.globalCompositeOperation = (mode === "erase") ? "destination-out" : "source-over";
        drawCtx.stroke();

        [lastX, lastY] = [pos.x, pos.y];
    }

    function drawAutoCircle(x, y, number) {
        drawCtx.globalCompositeOperation = 'source-over'; // Ensure circle isn't erased
        drawCtx.beginPath();
        drawCtx.arc(x, y, 30, 0, 4 * Math.PI);
        drawCtx.strokeStyle = 'black';
        drawCtx.lineWidth = 4;
        drawCtx.stroke();

        drawCtx.fillStyle = 'black';
        drawCtx.font = '40px Arial';
        drawCtx.textAlign = 'center';
        drawCtx.textBaseline = 'middle';
        drawCtx.fillText(number, x, y);
    }

    function clearDrawings() {
        drawCtx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
        markPoints = [];
        autoNumber = 1;
    }

    function switchToView(viewNum) {
        currentView = viewNum;
        drawCtx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);

        if (isImageUploaded && img) {
            bgCtx.clearRect(0, 0, bgCanvas.width, bgCanvas.height);
            bgCtx.drawImage(img, 0, 0);
        }

        markPoints.forEach(mark => drawAutoCircle(mark.x, mark.y, mark.number));
    }

 
    function loadFile(e) {
        const file = e.target.files[0];
        if (!file) return;

        const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp', 'image/svg+xml', 'image/tiff'];

        if (validImageTypes.includes(file.type)) {
            const reader = new FileReader();
            reader.onload = evt => {
                img = new Image();
                img.onload = () => {
                    [bgCanvas.width, drawCanvas.width] = [img.width, img.width];
                    [bgCanvas.height, drawCanvas.height] = [img.height, img.height];
                    bgCtx.clearRect(0, 0, bgCanvas.width, bgCanvas.height);
                    bgCtx.drawImage(img, 0, 0);
                    clearDrawings();
                    isImageUploaded = true; // <-- Upload Success
                };
                img.src = evt.target.result;
            };
            reader.readAsDataURL(file);
        } else if (file.type === 'application/pdf') {
            const reader = new FileReader();
            reader.onload = function(event) {
                const loadingTask = pdfjsLib.getDocument({data: event.target.result});
                loadingTask.promise.then(pdf => {
                    pdf.getPage(1).then(page => {
                        const viewport = page.getViewport({scale: 2.0});
                        [bgCanvas.width, drawCanvas.width] = [viewport.width, viewport.width];
                        [bgCanvas.height, drawCanvas.height] = [viewport.height, viewport.height];

                        bgCtx.clearRect(0, 0, bgCanvas.width, bgCanvas.height);
                        const renderContext = {
                            canvasContext: bgCtx,
                            viewport: viewport
                        };
                        page.render(renderContext).promise.then(() => {
                            clearDrawings();
                            isImageUploaded = true; // <-- Upload Success
                        });
                    });
                }, reason => {
                    console.error(reason);
                    alert('Error loading PDF file.');
                });
            };
            reader.readAsArrayBuffer(file);
        } else {
            alert('Unsupported file type: ' + file.type);
        }
    }

    function submitFeedback() {
        if (!isImageUploaded) {
            alert('Please upload an image or PDF first before submitting feedback.');
            return;
        }

        const feedbackInput = document.getElementById('feedbackInput').value.trim();
        if (feedbackInput) {
            const newFeedback = document.createElement('li');
            newFeedback.textContent = feedbackInput;
            document.getElementById('feedbackList').appendChild(newFeedback);
            document.getElementById('feedbackInput').value = '';
        } else {
            alert("Please enter some feedback.");
        }
    }
</script>
</x-layout>
