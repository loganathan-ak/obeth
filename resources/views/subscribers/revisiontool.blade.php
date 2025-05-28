<!-- revisiontool -->


<style>
 .revision-tool {
      border: 1px solid #000;
      padding: 20px;
      position: relative;
    }

    .upload-section {
      text-align: right;
    }

    .upload-btn {
      background-color: #f1f1f1;
      padding: 8px 15px;
      border: 1px solid #000;
      cursor: pointer;
    }

    .main-content {
      display: flex;
      margin-top: 20px;
      gap: 20px;
    }

    .image-section {
      flex: 1;
      position: relative;
      border: 1px solid #000;
      min-height: 400px;
      background: #eee;
    }

    .uploaded-image {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    .feedback-section {
      flex: 1;
      border: 1px solid #000;
      padding: 20px;
      position: relative;
    }

    .feedback-section h4 {
      margin-top: 0;
    }

    .feedback-list {
      margin-top: 10px;
      padding-left: 20px;
    }

    .submit-btn {
      position: absolute;
      bottom: 20px;
      right: 20px;
      background: #ccc;
      border: 1px solid #000;
      padding: 10px 20px;
      cursor: pointer;
    }

    .bottom-tools {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
      font-size: 14px;
      padding: 10px 0;
    }

    .box {
      position: absolute;
      border: 2px dashed;
      pointer-events: none;
      font-weight: bold;
      font-size: 14px;
      color: black;
    }

    #backgroundCanvas, #drawingCanvas {
   width:-webkit-fill-available;
    height: 397px;
}


.color-circle {
  display: inline-block;
  width: 25px;
  height: 25px;
  border-radius: 50%;
  border: 2px solid #000;
  cursor: pointer;
  margin-left: 10px;
}
.color-circle:hover {
  transform: scale(1.2);
}


</style>


<x-layout>
<div class="container-fluid mt-5 pt-4 mb-5 pb-5">
  <div class="page-inner">
  <div class="page-header">
      <h3 class="fw-bold mb-3">Revision Tool</h3>
      <ul class="breadcrumbs mb-3">
        <li class="nav-home">
          <a href="/">
            <i class="fas fa-house"></i>
          </a>
        </li>
        <li class="separator">
          <i class="fa-solid fa-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="/">Home</a>
        </li>
        <li class="separator">
          <i class="fa-solid fa-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="/revisiontool">Revision Tool</a>
        </li>
      </ul>
    </div>


  
<div class="revision-tool card p-5">
  <div class="upload-section">
  <input type="file" id="fileInput" style="display:none" accept="image/jpeg, image/png, image/webp, image/bmp, image/tiff, image/svg+xml, application/pdf" onchange="loadFile(event)">
      <button class="btn btn-success" onclick="document.getElementById('fileInput').click()">Upload Image or PDF</button>
  </div>


  <div style="margin-top: 10px;" class="mb-4 toolbar">
      <button class="btn btn-success" id="drawBtn" onclick="setMode('draw')">✏️ Draw</button>
      <button class="btn btn-info" id="eraseBtn" onclick="setMode('erase')">🧹 Erase</button>
      <button class="btn btn-danger" id="clearBtn" onclick="clearDrawings()">🗑️ Clear All Drawings</button>
  </div>


  <div class="row main-content">
  <!-- Inside your main-content -->
  <div class="image-section" id="imageSection">
  <!-- Single canvas for both drawing and displaying the image -->
  <canvas id="backgroundCanvas" style="position: absolute; top: 0; left: 0; z-index: 0;"></canvas>
  <canvas id="drawingCanvas" style="position: absolute; top: 0; left: 0; z-index: 1;"></canvas>
</div>



<div class="feedback-section">
  <h4>Feedback:</h4>
  <ol class="feedback-list" id="feedbackList">
   
  
  </ol>

  <textarea id="feedbackInput" class="form-control" rows="3" placeholder="Enter your feedback..."></textarea>

  <button class="submit-btn btn btn-danger" onclick="submitFeedback()">Submit</button>
</div>



  </div>

  <div class="bottom-tools">
    <div>Formatting Options:</div>
    <div id="colorPicker">
      <span class="color-circle" style="background:red" onclick="setColor('red')"></span>
      <span class="color-circle" style="background:blue" onclick="setColor('blue')"></span>
      <span class="color-circle" style="background:green" onclick="setColor('green')"></span>
      <span class="color-circle" style="background:orange" onclick="setColor('orange')"></span>
      <span class="color-circle" style="background:black" onclick="setColor('black')"></span>
    </div>
    </div>
        <div>Color Picker</div>
      </div>
    </div>



  </div>
</div>





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
        if (!isImageUploaded) {
            alert("Please upload an image or PDF.");
            return;
        }

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